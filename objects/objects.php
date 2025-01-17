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
        public $configPath;


        function __construct() {
            // Usando __DIR__ para obter o diretório atual e construir o caminho relativo
            $this->configPath = __DIR__ . '/../../config.cfg';
        }

        function conexao()
        {
            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }

            $configContent = parse_ini_file($this->configPath, true);  // true para usar seções

            if (!$configContent) {
                die("Erro: Não foi possível ler o arquivo de configuração.");
            }

            $cpanelUser = $configContent['CPANEL']['usuario'];
            $host = $configContent['DATA DB']['host'];
            $dbname = $cpanelUser . "_" . $configContent['DATA DB']['dbname'];
            $user = $cpanelUser . "_" . $configContent['DATA DB']['user'];
            $pass = $configContent['DATA DB']['pass'];

            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
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

        public function getListaMoradoresInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                ORDER BY USU_DCAPARTAMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAMORADORESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
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







    }
?>