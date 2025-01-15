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










    }
?>