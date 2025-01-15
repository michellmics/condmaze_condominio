<?php

    //include_once 'db.php'; 

    include '../../phpMailer/src/PHPMailer.php';
    include '../../phpMailer/src/SMTP.php';
    include '../../phpMailer/src/Exception.php'; 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


	class SITE_ADMIN
	{
        //declaração de variaveis 
        public $pdo;
        public $ARRAY_SITEINFO;
        public $ARRAY_LISTAINFO;
        public $ARRAY_USERINFOLIST;
        public $ARRAY_USERINFOBYID;
        public $ARRAY_DESCEMPRESAINFO;
        public $ARRAY_ALERTA;
        public $ARRAY_PARAMETERINFO;
        public $ARRAY_MORADORINFO;
        public $ARRAY_LISTAMORADORESINFO;
        public $ARRAY_FOOTERPUBLISHINFO;
        public $ARRAY_LOGINFO;
        public $ARRAY_POPUPPUBLISHINFO;
        public $ARRAY_RELINFO;
        public $configPath = '../../config.cfg';


        function conexao()
        {
            /*
                load fiule config.cfg

                [DATA DB]
                host = localhost
                dbname = dbname
                user = dbuser
                pass = dbpass
            */

            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }

            $configContent = parse_ini_file($this->configPath, true);  // true para usar seções

            if (!$configContent) {
                die("Erro: Não foi possível ler o arquivo de configuração.");
            }

            $host = $configContent['DATA DB']['host'];
            $dbname = $configContent['DATA DB']['dbname'];
            $user = $configContent['DATA DB']['user'];
            $pass = $configContent['DATA DB']['pass'];

            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        public function sendEmailPHPMailer($addAddress, $Subject, $Body, $anexo)
        {     
            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }
                       
            $configMail = parse_ini_file($this->configPath, true);  // true para usar seções
            $user = $configMail['EMAIL']['Username'];
            $pass = $configMail['EMAIL']['Password'];

            $mail = new PHPMailer(true);

            if($anexo != "na")
            {
                foreach ($anexo as $item) 
                {
                    if (!empty($item)) 
                    { 
                        $fileContent = file_get_contents($item); 
                        $fileName = basename($item); 
                        $mail->addStringAttachment($fileContent, $fileName, 'base64', 'application/pdf');
                    } else {
                        $this->InsertAlarme("Gerar Boleto: Caminho do arquivo está vazio.","High");
                        return "O caminho do arquivo está vazio: $item<br>";
                    }
                    sleep(2);
                }
            }
           

            try {
                //Configurações do servidor
                $mail->isSMTP(); 
                $mail->Host = $configMail['EMAIL']['Host'];
                $mail->SMTPAuth = true; 
                $mail->Username = $user;
                $mail->Password = $pass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port = $configMail['EMAIL']['Port'];

                // Configurações de codificação
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
            
                // Destinatários
                $mail->setFrom('no-reply@dominio.com', 'Codemaze');
                $mail->addAddress($addAddress); // Adicione um destinatário
                $mail->addBCC('suporte@codemaze.com.br'); // Se desejar enviar cópia oculta
            
                // Conteúdo do e-mail
                $mail->isHTML(true); // Defina o formato do e-mail como HTML
                $mail->Subject = $Subject;
                $mail->Body    = $Body; 
            
                $mail->send();
                return 'E-mail enviado com sucesso';
            } catch (Exception $e) {
                $this->InsertAlarme("Erro ao enviar e-mail. $mail->ErrorInfo","High");
                return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            }            
        }

        public function updateDataVisita($LIS_IDLISTACONVIDADOS)
        {    
               
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');
            

            try {
                $sql = "UPDATE LIS_LISTACONVIDADOS 
                        SET LIS_DTULTIMA_ENTRADA = :LIS_DTULTIMA_ENTRADA
                        WHERE 	LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DTULTIMA_ENTRADA', $DATA, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);

                $stmt->execute();
            
                return "Data de entrada do convidado atualizada com sucesso.";
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return "Erro ao atualizar a data de entrada do convidado.";
            }
        }
        
        public function updateDataVisitaRem($LIS_IDLISTACONVIDADOS)
        {    
               
            $DATA = "0000-00-00 00:00:00";            

            try {
                $sql = "UPDATE LIS_LISTACONVIDADOS 
                        SET LIS_DTULTIMA_ENTRADA = :LIS_DTULTIMA_ENTRADA
                        WHERE 	LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DTULTIMA_ENTRADA', $DATA, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);

                $stmt->execute();
            
                return "Entrada do convidado foi removida com sucesso.";
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return "Erro ao remover a entrada do convidado.";
            }
        }


        public function stmtToArray($stmtFunction)
		{		
			$stmtFunction_array = array();							
			while ($row = $stmtFunction->fetch(PDO::FETCH_ASSOC))
			{	
				array_push($stmtFunction_array, $row);	
			}		
	
			return $stmtFunction_array;
		}	
	

        public function getParameterInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT CFG_DCPARAMETRO, 
                                CFG_DCVALOR
                                FROM CFG_CONFIGURACAO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PARAMETERINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }       
        }

        public function getVarEnvInfo()
        {       
            if(!$this->pdo){$this->conexao();}            
                      
            $sql = "SELECT VEN_IDVARENV, VEN_PARAMETER, VEN_VALUE FROM VEN_VARENV ORDER BY VEN_IDVARENV ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $result;              
        }

        public function getListaInfoByid($LIS_IDLISTACONVIDADOS)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM LIS_LISTACONVIDADOS
                                WHERE LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaMoradoresInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE USU_DCNIVEL = 'SINDICO' OR USU_DCNIVEL = 'MORADOR'
                                ORDER BY USU_DCAPARTAMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAMORADORESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getFooterPublish()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT PUB_DCDESC  FROM PUB_PUBLICIDADE
                        WHERE PUB_STSTATUS = 'ATIVA' AND PUB_DCTIPO LIKE '%TEXTO%'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_FOOTERPUBLISHINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getPopupImagePublish()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT PUB_DCIMG, PUB_DCLINK  FROM PUB_PUBLICIDADE
                        WHERE PUB_STSTATUS = 'ATIVA' AND PUB_DCTIPO LIKE '%IMAGEM%'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_POPUPPUBLISHINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getMoradoreInfoById($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE USU_IDUSUARIO = :USU_IDUSUARIO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_MORADORINFO = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaMoradoresInfoBySearch($SEARCH)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE 
                                (USU_DCNIVEL = 'SINDICO' OR USU_DCNIVEL = 'MORADOR') 
                                AND (USU_DCNOME LIKE :SEARCH
                                OR USU_DCAPARTAMENTO LIKE :SEARCH)
                                ORDER BY USU_DCAPARTAMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':SEARCH', '%' . $SEARCH . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_LISTAMORADORESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }
       
        public function checkQtdeListaAtivo($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT COUNT(*) AS TOTAL FROM LIS_LISTACONVIDADOS
                        WHERE USU_IDUSUARIO = :USU_IDUSUARIO AND LIS_STSTATUS = 'ATIVO'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function updateVisitanteInfo($LIS_DCNOME, $USU_IDUSUARIO, $LIS_DCDOCUMENTO, $LIS_STSTATUS, $LIS_IDLISTACONVIDADOS)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            /*
            if($LIS_STSTATUS == "ATIVO")
            {
                $checkQtde = $this->checkQtdeListaAtivo($USU_IDUSUARIO);
                if($checkQtde["TOTAL"] >= 60)
                {
                    return "O limite máximo para convidados ativos é 60. Desative um convidado e tente ativar este novamente.";
                }
            }
            */
            try {
                $sql = "UPDATE LIS_LISTACONVIDADOS 
                        SET LIS_DCNOME = :LIS_DCNOME,
                        LIS_DCDOCUMENTO = :LIS_DCDOCUMENTO,
                        LIS_STSTATUS = :LIS_STSTATUS
                        WHERE LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DCNOME', $LIS_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DCDOCUMENTO', $LIS_DCDOCUMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_STSTATUS', $LIS_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);

                $stmt->execute();
            
                return "Convidado atualizado com sucesso.";
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function getListaInfo($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM LIS_LISTACONVIDADOS WHERE USU_IDUSUARIO = $USU_IDUSUARIO ORDER BY LIS_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getLogInfo() 
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM LOG_LOGSISTEMA ORDER BY LOG_DTLOG DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LOGINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaActiveInfo($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM LIS_LISTACONVIDADOS WHERE (USU_IDUSUARIO = $USU_IDUSUARIO AND LIS_STSTATUS = 'ATIVO') ORDER BY LIS_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getUserInfoList()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM USA_USERADMIN ORDER BY USA_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_USERINFOLIST = $stmt->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getUserInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT USA_IDUSERADMIN,                                  
                                USA_DCEMAIL, 
                                USA_DCNOME,
                                USA_DCSEXO,
                                USA_DCSENHA
                                FROM USA_USERADMIN WHERE USA_IDUSERADMIN = $ID";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_USERINFOBYID = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getRelatoriosDisponiveis()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT DISTINCT CON_DCMES_COMPETENCIA_USUARIO AS MES, 
                        CON_DCANO_COMPETENCIA_USUARIO AS ANO
                        FROM CON_CONCILIACAO
                        ORDER BY CON_DCMES_COMPETENCIA_USUARIO DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_RELINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function insertUserInfo($USU_DCEMAIL, $USU_DCNOME, $USU_DCBLOCO, $USU_DCAPARTAMENTO, $USU_DCNIVEL, $USU_DCSENHA)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO USU_USUARIO 
                        (USU_DCEMAIL, USU_DCNOME, USU_DCBLOCO, USU_DCAPARTAMENTO, USU_DCNIVEL, USU_DCSENHA, USU_DTCADASTRO) 
                        VALUES (:USU_DCEMAIL, :USU_DCNOME, :USU_DCBLOCO, :USU_DCAPARTAMENTO, :USU_DCNIVEL, :USU_DCSENHA, :USU_DTCADASTRO)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':USU_DCEMAIL', $USU_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNOME', $USU_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCBLOCO', $USU_DCBLOCO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $USU_DCAPARTAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNIVEL', $USU_DCNIVEL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCSENHA', $USU_DCSENHA, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DTCADASTRO', $DATA, PDO::PARAM_STR);
            
                $stmt->execute();
           
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Morador cadastrado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        function formatarValorParaMySQL($valor) {
            // Remove separadores de milhar
            $valor = str_replace(',', '', $valor);
            // Retorna o valor convertido para float
            return (float)$valor;
        }

        public function insertConciliacaoInfo($ARRAY_DADOS)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
           // Preparar e executar as inserções no banco de dados
            foreach ($ARRAY_DADOS as $dados) {

                $dados['VALOR'] = $this->formatarValorParaMySQL($dados['VALOR']); 

                // Query de inserção
                $sql = "INSERT INTO CON_CONCILIACAO (CON_DCTIPO, CON_DCMES_COMPETENCIA, CON_DCDESC, CON_NMVALOR, CON_DTINSERT, CON_DCMES_COMPETENCIA_USUARIO, CON_DCANO_COMPETENCIA_USUARIO, CON_DCANO_COMPETENCIA, CON_NMTITULO)
                          VALUES (:tipo, :mes_competencia, :descricao, :valor, :datanow, :mes_competencia_usuario, :ano_competencia_usuario, :ano_competencia, :titulo)";

                // Preparar a consulta
                $stmt = $this->pdo->prepare($sql);
                if (!$stmt) {
                    die("Erro ao preparar a consulta: " . $conn->error);
                }
            
                $stmt->bindValue(':tipo', $dados['TIPO'], PDO::PARAM_STR);
                $stmt->bindValue(':mes_competencia', $dados['COMPETENCIA MES'], PDO::PARAM_STR);
                $stmt->bindValue(':descricao', $dados['DESCRICAO'], PDO::PARAM_STR);
                $stmt->bindValue(':valor', $dados['VALOR'], PDO::PARAM_STR);
                $stmt->bindValue(':datanow', $dados['DATANOW'], PDO::PARAM_STR);
                $stmt->bindValue(':mes_competencia_usuario', $dados['COMPETENCIA MES USUARIO'], PDO::PARAM_STR);
                $stmt->bindValue(':ano_competencia_usuario', $dados['COMPETENCIA ANO USUARIO'], PDO::PARAM_STR);
                $stmt->bindValue(':ano_competencia', $dados['COMPETENCIA ANO'], PDO::PARAM_STR);
                $stmt->bindValue(':titulo', $dados['TITULO'], PDO::PARAM_STR);
            
                // Executar a consulta
                if (!$stmt->execute()) {
                    echo "Erro ao inserir os dados: " . $stmt->error . "<br>";
                } else {
                    //echo "Registro inserido com sucesso!<br>";
                }
            
            }

        }

        public function insertConciliacaoInfoDespesa($ARRAY_DADOS)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
           // Preparar e executar as inserções no banco de dados
            foreach ($ARRAY_DADOS as $dados) {

                $dados['VALOR'] = $this->formatarValorParaMySQL($dados['VALOR']); 

                // Query de inserção
                $sql = "INSERT INTO CON_CONCILIACAO (CON_DCTIPO, CON_NMVALOR, CON_DTINSERT, CON_DCMES_COMPETENCIA_USUARIO, CON_DCANO_COMPETENCIA_USUARIO, CON_NMTITULO)
                          VALUES (:tipo, :valor, :datanow, :mes_competencia_usuario, :ano_competencia_usuario, :titulo)";

                // Preparar a consulta
                $stmt = $this->pdo->prepare($sql);
                if (!$stmt) {
                    die("Erro ao preparar a consulta: " . $conn->error);
                }
            
                $stmt->bindValue(':tipo', $dados['TIPO'], PDO::PARAM_STR);
                $stmt->bindValue(':valor', $dados['VALOR'], PDO::PARAM_STR);
                $stmt->bindValue(':datanow', $dados['DATANOW'], PDO::PARAM_STR);
                $stmt->bindValue(':mes_competencia_usuario', $dados['COMPETENCIA MES USUARIO'], PDO::PARAM_STR);
                $stmt->bindValue(':ano_competencia_usuario', $dados['COMPETENCIA ANO USUARIO'], PDO::PARAM_STR);
                $stmt->bindValue(':titulo', $dados['TITULO'], PDO::PARAM_STR);
            
                // Executar a consulta
                if (!$stmt->execute()) {
                    echo "Erro ao inserir os dados: " . $stmt->error . "<br>";
                } else {
                    //echo "Registro inserido com sucesso!<br>";
                }
            
            }

        }

        public function checkPubliExisInfo($ID)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
        
            try {           
                $sql = "SELECT 1 FROM PUB_PUBLICIDADE WHERE MKT_IDMKTPUBLICIDADE = :MKT_IDMKTPUBLICIDADE";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':MKT_IDMKTPUBLICIDADE', $ID, PDO::PARAM_STR);
                $stmt->execute();
        
                // Verifica se encontrou algum registro
                return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        
        public function insertPubliInfo($PUB_DTINI, $PUB_DTFIM, $PUB_DCCLIENTEORIG, $PUB_STSTATUS, $MKT_IDMKTPUBLICIDADE, $PUB_DCIMG, $PUB_DCDESC, $PUB_DCTIPO, $PUB_DCLINK)
        {                            
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try {

                $sql = "INSERT INTO PUB_PUBLICIDADE 
                        (PUB_DTINI, PUB_DTFIM, PUB_DCCLIENTEORIG, PUB_STSTATUS, MKT_IDMKTPUBLICIDADE, PUB_DCIMG, PUB_DCDESC, PUB_DCTIPO, PUB_DCLINK) 
                        VALUES (:PUB_DTINI, :PUB_DTFIM, :PUB_DCCLIENTEORIG, :PUB_STSTATUS, :MKT_IDMKTPUBLICIDADE, :PUB_DCIMG, :PUB_DCDESC, :PUB_DCTIPO, :PUB_DCLINK)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PUB_DTINI', $PUB_DTINI, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DTFIM', $PUB_DTFIM, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCCLIENTEORIG', $PUB_DCCLIENTEORIG, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_STSTATUS', $PUB_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':MKT_IDMKTPUBLICIDADE', $MKT_IDMKTPUBLICIDADE, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCIMG', $PUB_DCIMG, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCDESC', $PUB_DCDESC, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCTIPO', $PUB_DCTIPO, PDO::PARAM_STR); 
                $stmt->bindParam(':PUB_DCLINK', $PUB_DCLINK, PDO::PARAM_STR);

            
                $stmt->execute();

                if($PUB_STSTATUS == "ATIVA")
                {
                    return "PUBLICADO";
                } 
                else
                    {
                        return "PENDENTE";
                    }

                        

            } catch (PDOException $e) {
                // Captura e retorna o erro
                return "ERRO: Não foi possível inserir a publicidade.";
            }
        }

        public function updatePubliInfo($PUB_DTINI, $PUB_DTFIM, $PUB_DCCLIENTEORIG, $PUB_STSTATUS, $MKT_IDMKTPUBLICIDADE, $PUB_DCIMG, $PUB_DCDESC, $PUB_DCTIPO, $PUB_DCLINK)
        {                            
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try {

                $sql = "UPDATE PUB_PUBLICIDADE 
                        SET
                        PUB_DTINI = :PUB_DTINI,
                        PUB_DTFIM = :PUB_DTFIM,
                        PUB_DCCLIENTEORIG = :PUB_DCCLIENTEORIG,
                        PUB_STSTATUS = :PUB_STSTATUS,
                        PUB_DCIMG = :PUB_DCIMG,
                        PUB_DCDESC = :PUB_DCDESC,
                        PUB_DCTIPO = :PUB_DCTIPO,
                        PUB_DCLINK = :PUB_DCLINK
                        WHERE MKT_IDMKTPUBLICIDADE = :MKT_IDMKTPUBLICIDADE";                       

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PUB_DTINI', $PUB_DTINI, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DTFIM', $PUB_DTFIM, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCCLIENTEORIG', $PUB_DCCLIENTEORIG, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_STSTATUS', $PUB_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':MKT_IDMKTPUBLICIDADE', $MKT_IDMKTPUBLICIDADE, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCIMG', $PUB_DCIMG, PDO::PARAM_STR);
                $stmt->bindParam(':PUB_DCDESC', $PUB_DCDESC, PDO::PARAM_STR); 
                $stmt->bindParam(':PUB_DCTIPO', $PUB_DCTIPO, PDO::PARAM_STR); 
                $stmt->bindParam(':PUB_DCLINK', $PUB_DCLINK, PDO::PARAM_STR);

            
                $stmt->execute();
           

                if($PUB_STSTATUS == "ATIVA")
                {
                    return "PUBLICADO";
                } 
                else
                    {
                        return "PENDENTE";
                    }
                    
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return "ERRO: Não foi possível atualizar a publicidade.";
            }
        }

        public function updateUserInfo($USU_DCEMAIL, $USU_DCNOME, $USU_DCBLOCO, $USU_DCAPARTAMENTO, $USU_DCNIVEL, $USU_DCSENHA, $USU_IDUSUARIO)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try {

                if($USU_DCSENHA != "IGNORE")
                {
                    $sql = "UPDATE USU_USUARIO 
                            SET
                            USU_DCEMAIL = :USU_DCEMAIL,
                            USU_DCNOME = :USU_DCNOME,
                            USU_DCBLOCO = :USU_DCBLOCO,
                            USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO,
                            USU_DCNIVEL = :USU_DCNIVEL,
                            USU_DCSENHA = :USU_DCSENHA
                            WHERE USU_IDUSUARIO = :USU_IDUSUARIO";

                    $stmt = $this->pdo->prepare($sql);
                    $stmt->bindParam(':USU_DCSENHA', $USU_DCSENHA, PDO::PARAM_STR);
                }
                if($USU_DCSENHA == "IGNORE")
                {
                    $sql = "UPDATE USU_USUARIO 
                            SET
                            USU_DCEMAIL = :USU_DCEMAIL,
                            USU_DCNOME = :USU_DCNOME,
                            USU_DCBLOCO = :USU_DCBLOCO,
                            USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO,
                            USU_DCNIVEL = :USU_DCNIVEL
                            WHERE USU_IDUSUARIO = :USU_IDUSUARIO";

                    $stmt = $this->pdo->prepare($sql);
                }                
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':USU_DCEMAIL', $USU_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNOME', $USU_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCBLOCO', $USU_DCBLOCO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $USU_DCAPARTAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNIVEL', $USU_DCNIVEL, PDO::PARAM_STR);
                
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_INT);

            
                $stmt->execute();
           
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Morador atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function insertVisitListaInfo($LIS_DCNOME, $USU_IDUSUARIO, $LIS_DCDOCUMENTO, $LIS_STSTATUS)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO LIS_LISTACONVIDADOS 
                        (LIS_DCNOME, USU_IDUSUARIO, LIS_DCDOCUMENTO, LIS_DTCADASTRO, LIS_STSTATUS) 
                        VALUES (:LIS_DCNOME, :USU_IDUSUARIO, :LIS_DCDOCUMENTO, :LIS_DTCADASTRO, :LIS_STSTATUS)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DCNOME', $LIS_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DCDOCUMENTO', $LIS_DCDOCUMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DTCADASTRO', $DATA, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_STSTATUS', $LIS_STSTATUS, PDO::PARAM_STR);
                
            
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Visitante cadastrado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }
                                       
        public function notifyEmail($SUBJECT, $MSG)
        {
            $this->getParameterInfo();

            foreach($this->ARRAY_PARAMETERINFO as $value)
            {
                if($value["CFG_DCPARAMETRO"] == "EMAIL_ALERTAS")
                {
                    $emailTo = $value["CFG_DCVALOR"];
                }
            } 

            // Configurações do e-mail
            $to = $emailTo; 
            $subject = "ATENÇÃO: $SUBJECT";
            $body = "$MSG\n";

            // Adiciona cabeçalhos para o e-mail
            $headers = "From: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Reply-To: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Define a codificação como UTF-8
            $headers .= "MIME-Version: 1.0\r\n";
            
            mail($to, $subject, $body, $headers);        
        }

        public function notifyUsuarioEmail($SUBJECT, $MSG, $EMAIL)
        {
            $this->getParameterInfo();

            // Configurações do e-mail
            $to = $EMAIL; 
            $subject = "$SUBJECT";
            $body = "$MSG\n";

            // Adiciona cabeçalhos para o e-mail
            $headers = "From: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Reply-To: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Define a codificação como UTF-8
            $headers .= "MIME-Version: 1.0\r\n";
            
            mail($to, $subject, $body, $headers);        
        }

        public function insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO LOG_LOGSISTEMA 
                        (LOG_DCTIPO, LOG_DCMSG, LOG_DCUSUARIO, LOG_DCAPARTAMENTO, LOG_DTLOG) 
                        VALUES (:LOG_DCTIPO, :LOG_DCMSG, :LOG_DCUSUARIO, :LOG_DCAPARTAMENTO, :LOG_DTLOG)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LOG_DCTIPO', $LOG_DCTIPO, PDO::PARAM_STR);
                $stmt->bindParam(':LOG_DCMSG', $LOG_DCMSG, PDO::PARAM_STR);
                $stmt->bindParam(':LOG_DCUSUARIO', $LOG_DCUSUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':LOG_DCAPARTAMENTO', $LOG_DCAPARTAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LOG_DTLOG', $DATA, PDO::PARAM_STR);
            
                $stmt->execute();
           
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function bdLogClear()
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try 
            {
                $sql = "DELETE FROM LOG_LOGSISTEMA WHERE LOG_DTLOG < CURDATE() - INTERVAL 90 DAY";

                $stmt = $this->pdo->prepare($sql);           
                $stmt->execute();

                return "Limpeza dos logs realizada com sucesso.";
           
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return "Erro ao executar a limpeza dos Logs: ".$e->getMessage();
            }
        }


    }