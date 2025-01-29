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

    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ler o cabeçalho
        $header = fgetcsv($handle);  // Aqui lemos o cabeçalho

        //campos a serem verificados
        $TAXA_CONDOMINAL = [];
        $isTaxaCondominial = false;
        $MULTAS = [];
        $isMultas = false;
        $JUROS = [];
        $isJuros = false;
        $ADVOCATICIOS = [];
        $isAdvocaticios = false;
        $ATUALIZACAO_MONETARIA = [];
        $isAtualizacaoMonetaria = false;
        $PAGAMENTO_A_MENOR = [];
        $isPagamentoMenor = false;
        $CARTAO_ACESSO = [];
        $isCartaoAcesso = false;
        $OUTRAS_RECEITAS = [];
        $isOutrasReceitas = false;
        $RENDIMENTO_APLICACAO = [];
        $isRendimentoAplicacao = false;
        $FUNDO_INADIMPLENCIA = [];
        $isFundoInadimplencia = false;
        $CONSUMO_AGUA = [];
        $isConsumoAgua = false;
        $AGUA_E_ESGOTO = [];
        $isAguaEsgoto = false;
        $PARCELAMENTO_SABESP = [];
        $isParcelamentoSabesp = false;
        $SALAO_FESTA = [];
        $isSalaoFesta = false;
        $ACORDOS_RECEBIDOS = [];
        $isAcordosRecebidos = false;
        $AUDITORIA = [];
        $isAuditoria = false;

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
        
            // Verifica se a primeira coluna começa com "Total"
            if (stripos($nome, 'Total') === 0) {
                continue; // Pula a linha se começar com "Total"
            }
        
            // Processamento dos dados
            foreach ($data as &$item) {
                // Substitui NBSP por espaços comuns
                $item = str_replace("\xC2\xA0", ' ', $item);
                $item = trim($item);
                // Substitui múltiplos espaços internos (inclusive NBSP) por um único espaço comum
                $item = preg_replace('/\s+/', ' ', $item);
            }
         
            
            // Extrair os campos relevantes
            $liquidacao = $data[3]; // Campo 'Liquid.'
            $fornecedor = $data[5]; // Campo 'Fornecedor'
            $valorLiquido = $data[8]; // Campo 'Valor liquído'


            echo "$fornecedor<br>";

            
        }









/*
            
           // INI TAXA CONDOMINAL
            if ($data[0] == "Taxa Condominial"){$isTaxaCondominial = true;continue;}
            // Se estamos na seção "Taxa Condominial" e a linha não está vazia
            if ($isTaxaCondominial && !empty($data[0])) {
                // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
                if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                    $isTaxaCondominial = false; // Sai da seção
                    continue;
                }    
                
                // Extrai o mês e o ano se o valor da competência estiver no formato esperado
                $competencia = $data[1];

                $mes = $competencia; // Valor padrão, caso não seja no formato esperado
                $ano = null;         // Valor padrão para o ano

                if (preg_match('/^([A-Za-z]{3})-(\d{2,4})$/', $competencia, $matches)) {
                    // Formatos: Oct-24 ou Oct-2024
                    $mes = ucfirst(strtolower($matches[1])); // Garante a capitalização correta (Oct)
                    $ano = (strlen($matches[2]) == 2) ? '20' . $matches[2] : $matches[2]; // Converte ano de 2 dígitos para 4
                
                } elseif (preg_match('/^(\d{2})[-\/](\d{2,4})$/', $competencia, $matches)) {
                    // Formatos: 10-2024 ou 10/2024
                    $meses = [
                        '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
                        '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug',
                        '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
                    ];
                
                    $mes = $meses[$matches[1]]; // Converte o número do mês para a abreviação em inglês
                    $ano = (strlen($matches[2]) == 2) ? '20' . $matches[2] : $matches[2]; // Converte ano de 2 dígitos para 4
                }

                $data[3] = converterParaFormatoAmericano($data[3]);

                $TAXA_CONDOMINAL[] = [
                    'DESCRICAO' => $data[0],
                    'COMPETENCIA MES' => $mes,
                    'COMPETENCIA ANO' => $ano,
                    'VALOR' => $data[3], 
                    'DATANOW' => $dataHoraAtual,
                    'COMPETENCIA MES USUARIO' => $mesUser,
                    'COMPETENCIA ANO USUARIO' => $anoUser,
                    'TIPO' => 'RECEITA',
                    'TITULO' => 'Taxa Condominial',
                ];
            }
            // FIM TAXA CONDOMINAL
        }


/*
        //Alertas de campos vazio e inserção no bd

        $erros = [];
        $campos = [
            "TAXA_CONDOMINAL" => $TAXA_CONDOMINAL,
            "MULTAS" => $MULTAS,
            "JUROS" => $JUROS,
            "ADVOCATICIOS" => $ADVOCATICIOS,
            "ATUALIZACAO_MONETARIA" => $ATUALIZACAO_MONETARIA,
            "PAGAMENTO_A_MENOR" => $PAGAMENTO_A_MENOR,
            "CARTAO_ACESSO" => $CARTAO_ACESSO,
            "OUTRAS_RECEITAS" => $OUTRAS_RECEITAS,
            "RENDIMENTO_APLICACAO" => $RENDIMENTO_APLICACAO,
            "FUNDO_INADIMPLENCIA" => $FUNDO_INADIMPLENCIA,
            "CONSUMO_AGUA" => $CONSUMO_AGUA,
            "PARCELAMENTO_SABESP" => $PARCELAMENTO_SABESP,
            "SALAO_FESTA" => $SALAO_FESTA,
            "ACORDOS_RECEBIDOS" => $ACORDOS_RECEBIDOS,
            "AUDITORIA" => $AUDITORIA,
            "AGUA_E_ESGOTO" => $AGUA_E_ESGOTO
        ];

        foreach ($campos as $nome => $valor) {
            if (count($valor) == 0) {
                $erros[] = "<strong>ATENÇÃO:</strong> A Receita com nome $nome está vazia, Contate o Administrador do Sistema.";
            } else {
                $siteAdmin->insertConciliacaoInfo($valor);
            }
        } 
*/

        fclose($handle);

        return "Processamento concluído";

    } else {
        echo "Erro ao abrir o arquivo.";
    }
}

$caminhoDestino = "teste.csv";
$result = processCSV($caminhoDestino, "setembro", "2004");

?>
