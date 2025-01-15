<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	header('Content-Type: application/json');

	$dados = json_decode(file_get_contents("php://input"), true);
	$consulta = isset($dados['consulta']) ? $dados['consulta'] : null; 
	$mes = isset($dados['mes']) ? $dados['mes'] : null; 
	$ano = isset($dados['ano']) ? $dados['ano'] : null; 

  	include_once '../../objetos_chart.php'; 
	$siteCharts = new SITE_CHARTS(); 
	
	 switch ($consulta) {
        case 'inadimplencia':
			$valorInadimplencia = $siteCharts->getInadimplenciaFull($mes,$ano);
			echo json_encode(['valor' => $valorInadimplencia]);
            break;

        case 'despesas':
			$siteCharts->getDespesasFull();
			echo json_encode($siteCharts->ARRAY_DESPESAFULLINFO);
            break;

        case 'receita':
			$siteCharts->getReceitasFull($mes,$ano);
			echo json_encode($siteCharts->ARRAY_RECEITAFULLINFO);
            break;

        default:
            $resultados = ['erro' => 'Consulta inválida ou não especificada'];
            break;
    }
	






?>

