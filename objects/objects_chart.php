<?php

    //include_once 'db.php'; 

	class SITE_CHARTS
	{
        //declaração de variaveis 
        public $pdo;
        public $configPath = '/home/hortensias/config.cfg';
        public $ARRAY_DESPESAFULLINFO;
        public $ARRAY_INADIMPLENCIAFULLINFO;
        public $ARRAY_RECEITAFULLINFO;


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

        public function getDespesasFull()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM REP_REPORT WHERE REP_DCTIPO LIKE 'DESPESA%'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_DESPESAFULLINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  

        public function getFundoReservaValor($FUR_DCMES,$FUR_DCANO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT FUR_DCVALUE
                        FROM FUR_FUNDO_RESERVA FUR
                        WHERE 
                        FUR.FUR_DCMES = :FUR_DCMES
                        AND FUR.FUR_DCANO = :FUR_DCANO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':FUR_DCMES', $FUR_DCMES, PDO::PARAM_STR);
                $stmt->bindParam(':FUR_DCANO', $FUR_DCANO, PDO::PARAM_STR);
               
                $stmt->execute();

                $total = $stmt->fetchColumn();
                return $total; 

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  

        public function getDespesaValor($CON_DCMES_COMPETENCIA_USUARIO,$CON_DCANO_COMPETENCIA_USUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}

            $TIPO = "DESPESA";

            try{           
                $sql = "SELECT ROUND(SUM(CON_NMVALOR),2) AS TOTAL
                        FROM CON_CONCILIACAO CON
                        WHERE 
                        CON.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CON.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                        AND CON.CON_DCTIPO = :DESPESA";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':DESPESA', $TIPO, PDO::PARAM_STR);
                $stmt->execute();

                $total = $stmt->fetchColumn();
                return $total; 

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  
        
        public function getReceitasValor($CON_DCMES_COMPETENCIA_USUARIO,$CON_DCANO_COMPETENCIA_USUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}

                if($CON_DCMES_COMPETENCIA_USUARIO  == "janeiro"){$competencia = "Jan";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "fevereiro"){$competencia = "Feb";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "março"){$competencia = "Mar";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "abril"){$competencia = "Apr";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "maio"){$competencia = "May";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "junho"){$competencia = "Jun";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "julho"){$competencia = "Jul";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "agosto"){$competencia = "Aug";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "setembro"){$competencia = "Sep";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "outubro"){$competencia = "Oct";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "novembro"){$competencia = "Nov";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "dezembro"){$competencia = "Dec";}
            
            try{           
                $sql = "SELECT ROUND(SUM(CON_NMVALOR),2) AS TOTAL
                        FROM CON_CONCILIACAO CON
                        WHERE 
                        CON.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CON.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                        AND CON.CON_DCMES_COMPETENCIA = :CON_DCMES_COMPETENCIA";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA', $competencia, PDO::PARAM_STR);
                $stmt->execute();

                $total = $stmt->fetchColumn();
                return $total; 

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  
        
        
        public function getReceitasFull($CON_DCMES_COMPETENCIA_USUARIO,$CON_DCANO_COMPETENCIA_USUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}

                if($CON_DCMES_COMPETENCIA_USUARIO  == "janeiro"){$competencia = "Jan";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "fevereiro"){$competencia = "Feb";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "março"){$competencia = "Mar";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "abril"){$competencia = "Apr";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "maio"){$competencia = "May";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "junho"){$competencia = "Jun";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "julho"){$competencia = "Jul";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "agosto"){$competencia = "Aug";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "setembro"){$competencia = "Sep";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "outubro"){$competencia = "Oct";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "novembro"){$competencia = "Nov";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "dezembro"){$competencia = "Dec";}
            
            try{           
                $sql = "SELECT 
                        CONC.CON_NMTITULO AS TITULO, 
                        ROUND(SUM(CONC.CON_NMVALOR), 2) AS TOTAL
                        FROM 
                        CON_CONCILIACAO CONC
                        WHERE 
                        CONC.CON_DCTIPO = 'RECEITA' 
                        AND CONC.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CONC.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                        AND CONC.CON_DCMES_COMPETENCIA = :CON_DCMES_COMPETENCIA
                        GROUP BY 
                        CONC.CON_NMTITULO
                        ORDER BY TOTAL DESC
                        LIMIT 10";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA', $competencia, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_RECEITAFULLINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  

        public function getInadimplenciaFull($CON_DCMES_COMPETENCIA_USUARIO,$CON_DCANO_COMPETENCIA_USUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}

                //acerto de variaveis
                if($CON_DCMES_COMPETENCIA_USUARIO  == "janeiro"){$competencia = "Jan";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "fevereiro"){$competencia = "Feb";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "março"){$competencia = "Mar";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "abril"){$competencia = "Apr";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "maio"){$competencia = "May";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "junho"){$competencia = "Jun";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "julho"){$competencia = "Jul";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "agosto"){$competencia = "Aug";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "setembro"){$competencia = "Sep";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "outubro"){$competencia = "Oct";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "novembro"){$competencia = "Nov";}
                if($CON_DCMES_COMPETENCIA_USUARIO  == "dezembro"){$competencia = "Dec";}
            
            try{           
                $sql = "SELECT 
                            SUM(CAST(REGEXP_REPLACE(CONC.CON_DCDESC, '[^0-9]', '') AS UNSIGNED)) AS Total
                        FROM 
                            CON_CONCILIACAO CONC
                        WHERE 
                            CONC.CON_DCTIPO = 'RECEITA' 
                            AND CONC.CON_NMTITULO = 'Taxa Condominial'
                            AND CONC.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                            AND CONC.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                            AND CONC.CON_DCMES_COMPETENCIA = :CON_DCMES_COMPETENCIA;";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA', $competencia, PDO::PARAM_STR);
                $stmt->execute();
                $ADIMPLENTES = $stmt->fetch(PDO::FETCH_ASSOC);

                $sql = "SELECT CFG.CFG_DCVALOR AS Total
                        FROM CFG_CONFIGURACAO CFG
                        WHERE CFG.CFG_DCPARAMETRO = 'QTDE_APARTAMENTOS'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $TOTAL_APARTAMENTOS = $stmt->fetch(PDO::FETCH_ASSOC);

                $adimplentes = $ADIMPLENTES['Total']; 
                $totalApartamentos = $TOTAL_APARTAMENTOS['Total']; 
    
                // Calcula a porcentagem de inadimplentes
                $inadimplentes = $totalApartamentos - $adimplentes;
                $percentualInadimplentes = round(($inadimplentes / $totalApartamentos) * 100,2);

                return $percentualInadimplentes;

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  


    }