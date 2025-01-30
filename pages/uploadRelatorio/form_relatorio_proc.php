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

function processCSV($filePath, $mesUser, $anoUser) {

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    $receitas = [];

   
 
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        
        
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
            
            // Obtém nome e valor (primeira e última coluna)
            $nome = trim($data[0]); // Primeira coluna (Nome)
            $valor = trim($data[3]); // Última coluna (Valor)
                 

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

                    // Obtém nome e valor (primeira e última coluna)
                    $nome = trim($data[0]); // Primeira coluna (Nome)
                    $valor = trim($data[3]); // Última coluna (Valor)

                    if($nome != "Total de Receitas") {
                        continue;
                    }
                        
                    // Verifica se ambos os campos estão preenchidos
                    if (empty($nome) || empty($valor)) {
                        continue;
                    }
        
                    // Extração do mês e ano da competência
                    $competencia = $data[1] ?? '';
                    $mes = $mesUser;
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

        fclose($handle);
    }
    // Insere os dados processados no banco
    $siteAdmin->insertConciliacaoInfo($receitas);


}

function processCSVDespesa($filePath, $mesUser, $anoUser) {
    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    $despesas = [];
 
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        fgetcsv($handle);

        $iniciarLeitura = false;

        // Ler os dados de pagamento da taxa condominial
        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            
            // Verifica se a linha contém "Despesas Ordinárias"
            if (!$iniciarLeitura) {
                foreach ($data as $coluna) {
                    if (strpos($coluna, 'Despesas Ordinárias') !== false) {
                        $iniciarLeitura = true; // Inicia a leitura a partir desta linha
                        break;
                    }
                }
                continue; // Pula as linhas até encontrar a desejada
            }
        
            // Verifica se há pelo menos duas colunas na linha (evita erros)
            if (count($data) < 2) {
                continue; // Ignora linhas que não têm pelo menos duas colunas
            }
        
            // Obtém o primeiro e o último elemento da linha
            $nome = trim($data[0]); // Primeira coluna (Nome)
            $valor = trim(end($data)); // Última coluna (Valor)
        
            // Verifica se ambos os campos estão preenchidos
            if (empty($nome) || empty($valor)) {
                continue; // Pula essa linha se um dos dois estiver vazio
            }
        

            // Verifica se a primeira coluna começa com "Total", "Mov. Líquido(Receitas-Despesas)" ou "F. "
            if (
                stripos($nome, 'Total') === 0 || 
                stripos($nome, 'Mov. Líquido(Receitas-Despesas)') === 0 || 
                stripos($nome, 'F. ') === 0
            ) {
                continue; // Pula a linha se começar com esses termos
            }
        
            // Processamento dos dados
            foreach ($data as &$item) {
                // Substitui NBSP por espaços comuns
                $item = str_replace("\xC2\xA0", ' ', $item);
                $item = trim($item);
                // Substitui múltiplos espaços internos (inclusive NBSP) por um único espaço comum
                $item = preg_replace('/\s+/', ' ', $item);
            }
         
            $valor = converterParaFormatoAmericano($valor);
            
            // Extrair os campos relevantes
            $fornecedor = $data[0]; // Campo 'Fornecedor'
            $valorLiquido = $valor; // Campo 'Valor liquído'

            // Adicionar aos resultados
            $despesas[] = [
                'TITULO' => $fornecedor,
                'VALOR' => $valorLiquido,
                'DATANOW' => $dataHoraAtual,
                'COMPETENCIA MES USUARIO' => $mesUser,
                'COMPETENCIA ANO USUARIO' => $anoUser,
                'TIPO' => 'DESPESA'
            ];

            
            
        }
        fclose($handle);
    }

    $siteAdmin->insertConciliacaoInfoDespesa($despesas);
    return "Fim do processamento";

}


$caminhoDestino = "nov.csv";
$mesUser = "novembro";
$anoUser = "2024";

$result = processCSV($caminhoDestino, $mesUser, $anoUser);
echo "O processamento foi concluído com sucesso.";

/*

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
            $result = processCSV($caminhoDestino, $mesUser, $anoUser);
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
    
*/
?>








<?php
/*




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

*/

?>







