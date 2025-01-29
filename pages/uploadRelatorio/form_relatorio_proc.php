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
        $PARCELAMENTO_SABESP = [];
        $isParcelamentoSabesp = false;
        $SALAO_FESTA = [];
        $isSalaoFesta = false;
        $ACORDOS_RECEBIDOS = [];
        $isAcordosRecebidos = false;
        $AUDITORIA = [];
        $isAuditoria = false;

        //Ler os dados de pagamento da taxa condominal
        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {

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

                        // INI HONORARIOS ADVOCATICIOS
           if ($data[0] == "Taxa Auditoria"){$isAuditoria = true;continue;}
           if ($isAuditoria && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAuditoria = false; // Sai da seção
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

               $AUDITORIA[] = [
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
        }



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
            "AUDITORIA" => $AUDITORIA
        ];

        foreach ($campos as $nome => $valor) {
            if (count($valor) == 0) {
                $erros[] = "ATENÇÃO: A Rceita com nome $nome está vazia, Contate o Administrador do Sistema.";
            } else {
                $siteAdmin->insertConciliacaoInfo($valor);
            }
        }

        fclose($handle);

        return $erros;

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
            $result = processCSV($caminhoDestino, $mesUser, $anoUser);
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
                    echo "Resultado Processamento";
                        // Exibir os erros de uma vez só, se houver
                        if (!empty($result)) {
                            echo implode("<br>", $result);
                        }

                        var_dump($result);
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











