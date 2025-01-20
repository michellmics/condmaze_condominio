<?php
	include_once "../objects/objects.php";

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação básica para os campos obrigatórios
    $dataInicio = $_POST['dataInicio'] ?? null;
    $dataFim = $_POST['dataFim'] ?? null;
    $clienteOrigin = $_POST['clienteOrigin'] ?? null;
    $status = $_POST['status'] ?? null;
    $mktId = $_POST['mktId'] ?? null; 
    $publiDesc = $_POST['publiDesc'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $link = $_POST['link'] ?? null;
    $imagem="";

    $publi = new SITE_ADMIN();

    if (!$dataInicio || !$dataFim || !$clienteOrigin || !$status || !$mktId || !$tipo) {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
        exit;
    }

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];

        $microtime = microtime(true); // Retorna o tempo atual como float
        $timestamp = (int)($microtime * 1000); // Converte para milissegundos

        // Define o diretório de upload
        $clienteOriginPath = preg_replace('/[^a-zA-Z0-9_-]/', '', $clienteOrigin);
        $uploadDirectory = "uploads/$clienteOriginPath/";
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Cria o diretório se não existir
        }

        // Define o caminho para salvar a imagem
        $uploadPath = $uploadDirectory . $timestamp . "_" . basename($file['name']);

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $imagem = $uploadPath; // Adiciona o caminho da imagem ao resultado
        } else {
            $result['success'] = false;
            $result['message'] = 'Erro ao mover o arquivo';
        }
    } else {
        $imagem = null; // Caso nenhuma imagem seja enviada
    }

    $checkExist = $publi->checkPubliExisInfo($mktId); //verifica se a publi já esta no sistema

    if ($checkExist === true) 
    {
        $updatePubli = $publi->updatePubliInfo($dataInicio,$dataFim,$clienteOrigin,$status,$mktId,$imagem,$publiDesc,$tipo,$link);    
        echo $updatePubli; //retorna OK se tudo ocorreu bem
    } 
    if ($checkExist === false) 
    {
        $insertPubli = $publi->insertPubliInfo($dataInicio,$dataFim,$clienteOrigin,$status,$mktId,$imagem,$publiDesc,$tipo,$link);    
        echo $insertPubli; //retorna OK se tudo ocorreu bem
    } 

} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
