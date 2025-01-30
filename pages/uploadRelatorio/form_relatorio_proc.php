<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	include_once "../../objects/objects.php";

function removeBOM($filePath) {
    // Ler o conteúdo do arquivo
    $fileContents = file_get_contents($filePath);

    // Verificar se o arquivo contém o BOM UTF-8
    if (substr($fileContents, 0, 3) == "\xEF\xBB\xBF") {
        // Remover o BOM (os três primeiros bytes)
        $fileContents = substr($fileContents, 3);
        
        // Regravar o arquivo sem o BOM
        file_put_contents($filePath, $fileContents);
    }
}

function converterParaFormatoAmericano($valor) {
    // Verifica se o número está no formato brasileiro (milhares com ponto e decimal com vírgula)
    if (preg_match('/^\d{1,3}(\.\d{3})*,\d{2}$/', $valor)) {
        // Substitui o ponto (.) por nada (remove separador de milhares)
        $valor = str_replace('.', '', $valor);
        // Substitui a vírgula (,) por ponto (separador decimal)
        $valor = str_replace(',', '.', $valor);
    }
    return $valor;
}

function procCondominio($filePath, $mesUser, $anoUser) {

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    

   
 
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        
        $receitas = [];
        $iniciarLeitura = false;
        
        // buscas as taxas de condominio
        while (($data = fgetcsv($handle, 1000, ';')) !== false) {  
            // Limpa os espaços indesejados e caracteres especiais
            foreach ($data as &$item) {
                $item = str_replace("\xC2\xA0", ' ', $item); // Remove NBSP
                $item = trim($item);
                $item = preg_replace('/\s+/', ' ', $item); // Remove espaços extras
            }
            
            // Verifica se encontrou a linha inicial para leitura
            if (!$iniciarLeitura) {
                foreach ($data as $coluna) {
                    if (stripos(trim($coluna), 'Taxa Condominial') !== false) {
                        $iniciarLeitura = true; // Inicia a leitura
                        break; 
                    }
                }
                continue; // Pula as linhas até encontrar a desejada
            }
         
            if (stripos($data[0] ?? '', 'Total de Taxa Condominial') === 0) {
                break;
            }  

            if (empty(end($data))) {
                array_pop($data); // Remove o último campo se estiver vazio
            }
            
            // Obtém nome e valor (primeira e última coluna)
            $nome = trim($data[0]); // Primeira coluna (Nome)
            $valor = trim(end($data)); // Última coluna (Valor)
                 

            // Verifica se ambos os campos estão preenchidos
            if (empty($nome) || empty($valor)) {
                continue;
            }

            // Extração do mês e ano da competência
            $competencia = $data[1] ?? '';
            $mes = $competencia;
            $ano = null;            

            if (preg_match('/^([A-Za-z]{3})-(\d{2,4})$/', $competencia, $matches)) {
                $mes = ucfirst(strtolower($matches[1]));
                $ano = (strlen($matches[2]) == 2) ? '20' . $matches[2] : $matches[2];
            } elseif (preg_match('/^(\d{2})[-\/](\d{2,4})$/', $competencia, $matches)) {
                $meses = [
                    '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                    '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
                    '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
                ];
                $mes = $meses[$matches[1]] ?? $mes;
                $ano = (strlen($matches[2]) == 2) ? '20' . $matches[2] : $matches[2];
            }

            // Converte valor para formato americano, se existir
            $valorFormatado = isset($valor) ? converterParaFormatoAmericano($valor) : '';

            // Adiciona ao array de receitas
            $receitas[] = [
                'DESCRICAO' => $nome,
                'COMPETENCIA MES' => $mes,
                'COMPETENCIA ANO' => $ano,
                'VALOR' => $valorFormatado,
                'DATANOW' => $dataHoraAtual,
                'COMPETENCIA MES USUARIO' => $mesUser,
                'COMPETENCIA ANO USUARIO' => $anoUser,
                'TIPO' => 'RECEITA',
                'TITULO' => "Taxa Condominal",
            ];

           
            
            
        }

        // Insere os dados processados no banco
        $siteAdmin->insertConciliacaoInfo($receitas);
        

        fclose($handle);

    }



}

function procReceitaTotal($filePath, $mesUser, $anoUser) {

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    

   
 
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        
        $receitas = [];
        $iniciarLeitura = false;
  
        // buscas o total de receita
        while (($data = fgetcsv($handle, 1000, ';')) !== false) {  
                    // Limpa os espaços indesejados e caracteres especiais
                    foreach ($data as &$item) {
                        $item = str_replace("\xC2\xA0", ' ', $item); // Remove NBSP
                        $item = trim($item);
                        $item = preg_replace('/\s+/', ' ', $item); // Remove espaços extras
                    }
        
                    // Verifica se encontrou a linha inicial para leitura
                    if (!$iniciarLeitura) {
                        foreach ($data as $coluna) {
                            if ($coluna == 'Taxa Condominial') {
                                $iniciarLeitura = true; // Inicia a leitura
                                break;
                            }
                        }
                        continue; // Pula as linhas até encontrar a desejada
                    }

                    if (empty(end($data))) {
                        array_pop($data); // Remove o último campo se estiver vazio
                    }

                    // Obtém nome e valor (primeira e última coluna)
                    $nome = trim($data[0]); // Primeira coluna (Nome)
                    $valor = trim(end($data)); // Última coluna (Valor) 

                    if($nome != "Total de Receitas") {
                        continue;
                    }
                        
                    // Verifica se ambos os campos estão preenchidos
                    if (empty($nome) || empty($valor)) {
                        continue;
                    }
        
                    // Extração do mês e ano da competência
                    $competencia = $data[1] ?? '';

                    if($mesUser  == "janeiro"){$mes = "Jan";}
                    if($mesUser  == "fevereiro"){$mes = "Feb";}
                    if($mesUser  == "março"){$mes = "Mar";}
                    if($mesUser  == "abril"){$mes = "Apr";}
                    if($mesUser  == "maio"){$mes = "May";}
                    if($mesUser  == "junho"){$mes = "Jun";}
                    if($mesUser  == "julho"){$mes = "Jul";}
                    if($mesUser  == "agosto"){$mes = "Aug";}
                    if($mesUser  == "setembro"){$mes = "Sep";}
                    if($mesUser  == "outubro"){$mes = "Oct";}
                    if($mesUser  == "novembro"){$mes = "Nov";}
                    if($mesUser  == "dezembro"){$mes = "Dec";}

                    $ano = $anoUser;       
        
                    // Converte valor para formato americano, se existir
                    $valorFormatado = isset($valor) ? converterParaFormatoAmericano($valor) : '';
        
                    // Adiciona ao array de receitas
                    $receitas[] = [
                        'DESCRICAO' => $nome,
                        'COMPETENCIA MES' => $mes,
                        'COMPETENCIA ANO' => $ano,
                        'VALOR' => $valorFormatado,
                        'DATANOW' => $dataHoraAtual,
                        'COMPETENCIA MES USUARIO' => $mesUser,
                        'COMPETENCIA ANO USUARIO' => $anoUser,
                        'TIPO' => 'RECEITA',
                        'TITULO' => "Receita Total",
                    ];       
        }

        // Insere os dados processados no banco
        $siteAdmin->insertConciliacaoInfo($receitas);

        fclose($handle);

    }



}

function processCSVDespesa($filePath, $mesUser, $anoUser) {

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    

   
 
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        
        $despesas = [];
        $iniciarLeitura = false;
  
        // buscas o total de despesas
        while (($data = fgetcsv($handle, 1000, ';')) !== false) {  
                    // Limpa os espaços indesejados e caracteres especiais
                    foreach ($data as &$item) {
                        $item = str_replace("\xC2\xA0", ' ', $item); // Remove NBSP
                        $item = trim($item);
                        $item = preg_replace('/\s+/', ' ', $item); // Remove espaços extras
                    }
        
                    // Verifica se encontrou a linha inicial para leitura
                    if (!$iniciarLeitura) {
                        foreach ($data as $coluna) {
                            if ($coluna == 'Taxa Condominial') {
                                $iniciarLeitura = true; // Inicia a leitura
                                break;
                            }
                        }
                        continue; // Pula as linhas até encontrar a desejada
                    }

                    if (empty(end($data))) {
                        array_pop($data); // Remove o último campo se estiver vazio
                    }

                    // Obtém nome e valor (primeira e última coluna)
                    $nome = trim($data[0]); // Primeira coluna (Nome)
                    $valor = trim(end($data)); // Última coluna (Valor) 

                    if($nome != "Total de Despesas") {
                        continue;
                    }
                        
                    // Verifica se ambos os campos estão preenchidos
                    if (empty($nome) || empty($valor)) {
                        continue;
                    }
        
             
        
                    // Converte valor para formato americano, se existir
                    $valorFormatado = isset($valor) ? converterParaFormatoAmericano($valor) : '';
        
                    // Adiciona ao array de receitas
            // Adicionar aos resultados
            $despesas[] = [
                'TITULO' => $nome,
                'VALOR' => $valorLiquido,
                'DATANOW' => $dataHoraAtual,
                'COMPETENCIA MES USUARIO' => $mesUser,
                'COMPETENCIA ANO USUARIO' => $anoUser,
                'TIPO' => 'DESPESA'
            ];    
        }

        // Insere os dados processados no banco
        $siteAdmin->insertConciliacaoInfo($receitas);

        fclose($handle);

    }



}


if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
    $mesUser = isset($_POST['mes']) ? trim($_POST['mes']) : '';
    $anoUser = isset($_POST['ano']) ? trim($_POST['ano']) : '';

    $arquivo = $_FILES['arquivo'];
    $tiposPermitidos = ['text/csv'];
    $tamanhoMaximo = 2 * 1024 * 1024; // 2 MB
    $diretorioDestino = "csv_parser/"; // Pasta onde os arquivos serão salvos

    // Valida o tamanho do arquivo
    if ($arquivo['size'] > $tamanhoMaximo) {
        die("Erro: O arquivo excede o tamanho máximo permitido de 2 MB.");
    }

    // Valida o tipo do arquivo
    if (!in_array($arquivo['type'], $tiposPermitidos)) {
        die("Erro: Tipo de arquivo não permitido.");
    }
    $nomeArquivo = uniqid() . "-" . basename($arquivo['name']);
    $caminhoDestino = $diretorioDestino . $nomeArquivo;

    // Cria o diretório de destino, se não existir
    if (!is_dir($diretorioDestino)) {
        mkdir($diretorioDestino, 0777, true);
    }
    if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino)) {
        removeBOM($caminhoDestino);
        if($tipo == "receita")
        {
            $result = procCondominio($caminhoDestino, $mesUser, $anoUser);
            $result = procReceitaTotal($caminhoDestino, $mesUser, $anoUser);
            $result = processCSVDespesa($caminhoDestino, $mesUser, $anoUser);
            $status = "O processamento foi concluído com sucesso.";
        }
        if($tipo == "despesa")
        {
            processCSVDespesa($caminhoDestino, $mesUser, $anoUser);
            $status = "O processamento foi concluído com sucesso.";
        }

        $resultadoParser = "Sucesso: Arquivo processado.";
    } else {
        $resultadoParser = "Erro: Não foi possível salvar o arquivo.";
    }


}
    

?>













<!DOCTYPE html>
<html lang="en" data-layout="topnav">

<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

		<!-- Top bar Area -->
		<?php include '../../src/top_bar.php'; ?>
		<!-- End Top bar -->
 
		<!-- Menu Nav Area -->
		<?php include '../../src/menu_nav.php'; ?>
		<!-- End Menu Nav -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                </div>
                <!-- container -->
            </div>
            <!-- content -->

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Enviar Arquivo</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php
                        echo "Arquivo processado<br><br>";
                    ?>


                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <?php include '../../src/footer_nav.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->



    

    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Code Highlight js -->
    <script src="../../assets/vendor/highlightjs/highlight.pack.min.js"></script>
    <script src="../../assets/vendor/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/hyper-syntax.js"></script>

    <!-- Dropzone File Upload js -->
    <script src="../../assets/vendor/dropzone/dropzone-min.js"></script>

    <!-- File Upload Demo js -->
    <script src="../../assets/js/ui/component.fileupload.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>









