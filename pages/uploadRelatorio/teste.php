<?php

ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 
    $receitas = [];
    $filePath = "set_new.csv";
    $mesUser = "Setembro";
    $anoUser = "2024";

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



    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== false) {
        // Ignorar as duas primeiras linhas
        fgetcsv($handle);
        fgetcsv($handle);

        $iniciarLeitura = false;
        $descricaoReceita = "";

        // Ler os dados do CSV
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
                    if (stripos(trim($coluna), 'Receitas Ordinárias') !== false) {
                        $iniciarLeitura = true; // Inicia a leitura
                        break;
                    }
                }
                continue; // Pula as linhas até encontrar a desejada
            }

            // Para de ler ao encontrar "Total de Receitas"
            if (stripos($data[0] ?? '', 'Total de Receitas') === 0) {
                break;
            }

            // Identifica tipo de receita
            if (stripos($data[0] ?? '', 'Taxa Condominial') === 0) {
                $descricaoReceita = "Taxa Condominio";
            }
            if (stripos($data[0] ?? '', 'Total de Taxa Condominial') === 0) {
                $descricaoReceita = "Receitas";
            }
            
            // Obtém nome e valor (primeira e última coluna)
            $nome = $data[0] ?? ''; 
            $valor = end($data) ?? '';

            // Verifica se ambos os campos estão preenchidos
            if (empty($nome) || empty($valor)) {
                continue;
            }

            // Pula linhas que começam com termos indesejados
            if (
                stripos($nome, 'Total') === 0 || 
                stripos($nome, 'Mov. Líquido(Receitas-Despesas)') === 0 || 
                stripos($nome, 'F. ') === 0
            ) {
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
            $valorFormatado = isset($data[3]) ? converterParaFormatoAmericano($data[3]) : '';

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
                'TITULO' => $descricaoReceita,
            ];
        }

        fclose($handle);
    }

    // Insere os dados processados no banco
    $siteAdmin->insertConciliacaoInfo($receitas);



?>