<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../objetos.php';

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
        $PARCELAMENTO_SABESP = [];
        $isParcelamentoSabesp = false;
        $SALAO_FESTA = [];
        $isSalaoFesta = false;
        $ACORDOS_RECEBIDOS = [];
        $isAcordosRecebidos = false;

        //Ler os dados de pagamento da taxa condominal
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

            foreach ($data as &$item) {
                // Substitui NBSP por espaços comuns
                $item = str_replace("\xC2\xA0", ' ', $item);
                $item = trim($item);
                // Substitui múltiplos espaços internos (inclusive NBSP) por um único espaço comum
                $item = preg_replace('/\s+/', ' ', $item);
            }

            
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
                
                if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                    $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                    $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
                }
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

           // INI MULTAS
           if ($data[0] == "Multas"){$isMultas = true;continue;}
           if ($isMultas && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isMultas = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $MULTAS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Multas',
               ];
            }
            // FIM MULTAS

            // INI JUROS
           if ($data[0] == "Juros"){$isJuros = true;continue;}
           if ($isJuros && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isJuros = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $JUROS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Juros',
               ];
            }
            // FIM JUROS
            
            // INI HONORARIOS ADVOCATICIOS
           if ($data[0] == "Honorários Advocaticios"){$isAdvocaticios = true;continue;}
           if ($isAdvocaticios && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAdvocaticios = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $ADVOCATICIOS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Honorários Advocaticios',
               ];
            }
            // FIM HONORARIOS ADVOCATICIOS
                        
            // INI ATUALIZACAO MONETARIA
           if ($data[0] == "Atualização Monetária"){$isAtualizacaoMonetaria = true;continue;}
           if ($isAtualizacaoMonetaria && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAtualizacaoMonetaria = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $ATUALIZACAO_MONETARIA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Atualização Monetária',
               ];
            }
            // FIM ATUALIZACAO MONETARIA

            // INI PAGAMENTO A MENOR
           if ($data[0] == "Pagamento a menor"){$isPagamentoMenor = true;continue;}
           if ($isPagamentoMenor && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isPagamentoMenor = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $PAGAMENTO_A_MENOR[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Pagamento a menor',
               ];
            }
            // FIM PAGAMENTO A MENOR

            // INI CARTAO DE ACESSO
           if ($data[0] == "Cartão de Acesso"){$isCartaoAcesso = true;continue;}
           if ($isCartaoAcesso && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isCartaoAcesso = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $CARTAO_ACESSO[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Cartão de Acesso',
               ];
            }
            // FIM CARTAO DE ACESSO

            // INI OUTRAS RECEITAS
           if ($data[0] == "Outras Receitas"){$isOutrasReceitas = true;continue;}
           if ($isOutrasReceitas && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isOutrasReceitas = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               if ($data[3] != "") { //junção de varias receitas sem total.
                $OUTRAS_RECEITAS[] = [
                    'DESCRICAO' => $data[0],
                    'COMPETENCIA MES' => $mes,
                    'COMPETENCIA ANO' => $ano,
                    'VALOR' => $data[3],
                    'DATANOW' => $dataHoraAtual,
                    'COMPETENCIA MES USUARIO' => $mesUser,
                    'COMPETENCIA ANO USUARIO' => $anoUser,
                    'TIPO' => 'RECEITA',
                    'TITULO' => 'Outras Receitas',
                ];
                }
            }
            // FIM OUTRAS RECEITAS

            // INI RENDIMENTO APLICAÇÃO
           if ($data[0] == "Rendimento Aplicação F.O."){$isRendimentoAplicacao = true;continue;}
           if ($isRendimentoAplicacao && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isRendimentoAplicacao = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $RENDIMENTO_APLICACAO[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Rendimento Aplicação F.O.',
               ];
            }
            // FIM RENDIMENTO APLICAÇÃO

            // INI FUNDO INADIMPLENCA
           if ($data[0] == "F. Inadimplencia"){$isFundoInadimplencia = true;continue;}
           if ($isFundoInadimplencia && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isFundoInadimplencia = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $FUNDO_INADIMPLENCIA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'F. Inadimplencia',
               ];
            }
            // FIM FUNDO INADIMPLENCA

            // INI CONSUMO AGUA
           if ($data[0] == "Consumo de água"){$isConsumoAgua = true;continue;}
           if ($isConsumoAgua && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isConsumoAgua = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $CONSUMO_AGUA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Consumo de água',
               ];
            }
            // FIM CONSUMO AGUA

            // INI PARCELAMENTO SABESP
           if ($data[0] == "Parcelamento SABESP"){$isParcelamentoSabesp = true;continue;}
           if ($isParcelamentoSabesp && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isParcelamentoSabesp = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $PARCELAMENTO_SABESP[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Parcelamento SABESP',
               ];
            }
            // FIM PARCELAMENTO SABESP

            // INI SALAO DE FESTAS
           if ($data[0] == "Salao de Festa"){$isSalaoFesta = true;continue;}
           if ($isSalaoFesta && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isSalaoFesta = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $SALAO_FESTA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Salao de Festa',
               ];
            }
            // FIM SALAO DE FESTAS

            // INI ACORDOS RECEBIDOS
           if ($data[0] == "Acordos Recebidos"){$isAcordosRecebidos = true;continue;}
           if ($isAcordosRecebidos && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAcordosRecebidos = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $ACORDOS_RECEBIDOS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Salao de Festa',
               ];
            }
            // FIM ACORDOS RECEBIDOS

            // INI EVENTOS
           if ($data[0] == "Receitas de Eventos"){$isSalaoFesta = true;continue;}
           if ($isSalaoFesta && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isSalaoFesta = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $SALAO_FESTA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => $mesUser,
                   'COMPETENCIA ANO USUARIO' => $anoUser,
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Receitas de Eventos',
               ];
            }
            // FIM EVENTOS
        }

        //Alertas de campos vazio
        if(count($TAXA_CONDOMINAL) == 0){echo "ATENÇÃO: TAXA_CONDOMINAL VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($TAXA_CONDOMINAL);}
        if(count($MULTAS) == 0){echo "ATENÇÃO: MULTAS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($MULTAS);}
        if(count($JUROS) == 0){echo "ATENÇÃO: JUROS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($JUROS);}
        if(count($ADVOCATICIOS) == 0){echo "ATENÇÃO: ADVOCATICIOS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ADVOCATICIOS);}
        if(count($ATUALIZACAO_MONETARIA) == 0){echo "ATENÇÃO: ATUALIZACAO_MONETARIA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ATUALIZACAO_MONETARIA);}
        if(count($PAGAMENTO_A_MENOR) == 0){echo "ATENÇÃO: PAGAMENTO_A_MENOR VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($PAGAMENTO_A_MENOR);}
        if(count($CARTAO_ACESSO) == 0){echo "ATENÇÃO: CARTAO_ACESSO VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($CARTAO_ACESSO);}
        if(count($OUTRAS_RECEITAS) == 0){echo "ATENÇÃO: OUTRAS_RECEITAS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($OUTRAS_RECEITAS);}
        if(count($RENDIMENTO_APLICACAO) == 0){echo "ATENÇÃO: RENDIMENTO_APLICACAO VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($RENDIMENTO_APLICACAO);}
        if(count($FUNDO_INADIMPLENCIA) == 0){echo "ATENÇÃO: FUNDO_INADIMPLENCIA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($FUNDO_INADIMPLENCIA);}
        if(count($CONSUMO_AGUA) == 0){echo "ATENÇÃO: CONSUMO_AGUA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($CONSUMO_AGUA);}
        if(count($PARCELAMENTO_SABESP) == 0){echo "ATENÇÃO: PARCELAMENTO_SABESP VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($PARCELAMENTO_SABESP);}
        if(count($SALAO_FESTA) == 0){echo "ATENÇÃO: SALAO_FESTA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($SALAO_FESTA);}
        if(count($ACORDOS_RECEBIDOS) == 0){echo "ATENÇÃO: ACORDOS_RECEBIDOS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ACORDOS_RECEBIDOS);}

        fclose($handle);

        echo "Dados importados com sucesso!";
    } else {
        echo "Erro ao abrir o arquivo.";
    }
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

        // Processar as linhas restantes
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Limpar espaços e caracteres especiais
            foreach ($data as &$item) {
                $item = str_replace("\xC2\xA0", ' ', $item); // Substituir NBSP por espaço comum
                $item = trim($item);
            }

            // Extrair os campos relevantes
            $liquidacao = $data[3]; // Campo 'Liquid.'
            $fornecedor = $data[5]; // Campo 'Fornecedor'
            $valorLiquido = $data[8]; // Campo 'Valor liquído'

            // Ignorar linhas vazias ou sem valor líquido
            if (empty($liquidacao) || empty($fornecedor) || empty($valorLiquido)) {
                continue;
            }

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
            processCSV($caminhoDestino, $mesUser, $anoUser);
        }
        if($tipo == "despesa")
        {
            processCSVDespesa($caminhoDestino, $mesUser, $anoUser);
        }

        $resultadoParser = "Sucesso: Arquivo processado.";
    } else {
        $resultadoParser = "Erro: Não foi possível salvar o arquivo.";
    }


}
    


?>

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>Condomínio Parque das Hortências</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">

        <!-- SWEETALERT -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<link rel="icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="shortcut icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="apple-touch-icon" href="https://www.prqdashortensias.com.br/logo_icon.png">
    	<meta name="apple-mobile-web-app-title" content="Hortensias">
    	<meta name="apple-mobile-web-app-capable" content="yes">
    	<meta name="apple-mobile-web-app-status-bar-style" content="default">

        <style>
          /* Configuração geral do HTML e Body */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Footer fixo no final */
.footerNew {
    background-color: #f0f0f0; /* Cinza bem claro */
    color: #000; /* Cinza clarinho para o texto */
    font-size: 12px; /* Fonte pequena */
    text-align: center; /* Centraliza o texto */
    padding: 0; /* Remove espaçamento interno */
    height: 65px; /* Altura do footer */
    line-height: 30px; /* Centraliza verticalmente o texto */
    position: fixed; /* Fixa o footer */
    bottom: 0; /* Colado no final da página */
    width: 100%; /* Largura total */
}
 /* Botão de Salvar em lilás */
 .btn-primary {
      background-color:#8a0653; /* Lilás */
      border-color: #8a0653; /* Mesma cor da borda */
      color: white; /* Texto branco */
  }
  .btn-primary:hover {
      background-color: #993399; /* Lilás mais claro ao passar o mouse */
  }

  /* Botão de Voltar em lilás mais claro */
  .btn-warning {
      background-color: #D8BFD8; /* Lilás mais claro */
      border-color: #D8BFD8; /* Mesma cor da borda */
      color: #4B0082; /* Texto em roxo escuro */
  }
  .btn-warning:hover {
      background-color: #E6E6FA; /* Lilás ainda mais claro ao passar o mouse */
  }

</style>

	
    </head>
    <body>
	
		<!-- Preloader -->
		<?php include 'src/preloader.php'; ?>
		<!-- End Preloader -->
     

		<!-- Header Area -->
		<?php include 'src/header.php'; ?>
		<!-- End Header Area -->



	

 

		<section class="content" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    		
        <?php echo $resultadoParser; ?>
        <br>
        <a href="javascript:history.back()">Clique aqui para voltar</a>



		</section>



<!-- Footer -->
<footer class="footerNew">
<?php include 'src/footer.php'; ?>
</footer>
		


		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>

		
		
    </body>
</html>