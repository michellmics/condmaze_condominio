<?php

    //include_once 'db.php'; 

	class SITE_CHARTS
	{
        //declaração de variaveis 
        public $pdo;
        public $ARRAY_DESPESAFULLINFO;
        public $ARRAY_INADIMPLENCIAFULLINFO;
        public $ARRAY_RECEITAFULLINFO;
        public $ARRAY_PENDENCIAMESFULLINFO;
        public $ARRAY_DESPESATABLEINFO;
        public $configPath;

        function conexao()
        {
            $host = $_ENV['ENV_BD_HOST'];
            $dbname = $_ENV['ENV_BD_DATABASE'];
            $user = $_ENV['ENV_BD_USER'];
            $pass = $_ENV['ENV_BD_PASS'];

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

        public function getDespesaTableValor($CON_DCMES_COMPETENCIA_USUARIO,$CON_DCANO_COMPETENCIA_USUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}

            $TIPO = "DESPESA%";

            try{           
                $sql = "SELECT CON_NMTITULO, CON_NMVALOR FROM CON_CONCILIACAO   
                        WHERE CON_DCTIPO LIKE :DESPESA
                        AND CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                        ORDER BY CON_NMVALOR DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':DESPESA', $TIPO, PDO::PARAM_STR);
                $stmt->execute();

                $this->ARRAY_DESPESATABLEINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                /*        
                $sql = "SELECT ROUND(SUM(CON_NMVALOR),2) AS TOTAL
                        FROM CON_CONCILIACAO CON
                        WHERE 
                        CON.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CON.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO
                        AND (CON.CON_DCMES_COMPETENCIA = :CON_DCMES_COMPETENCIA OR CON.CON_DCMES_COMPETENCIA = 'Acordo')";
                */
                $sql = "SELECT CON.CON_NMVALOR AS TOTAL
                        FROM CON_CONCILIACAO CON
                        WHERE CON.CON_NMTITULO = 'Receita Total' AND
                        CON.CON_DCMES_COMPETENCIA_USUARIO = :CON_DCMES_COMPETENCIA_USUARIO
                        AND CON.CON_DCANO_COMPETENCIA_USUARIO = :CON_DCANO_COMPETENCIA_USUARIO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA_USUARIO', $CON_DCMES_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                //$stmt->bindParam(':CON_DCMES_COMPETENCIA', $competencia, PDO::PARAM_STR);
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

        public function getPendenciaByMesFull()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT 
                        CONCAT(
                            LPAD(
                                CASE PagamentosMensais.CON_DCMES_COMPETENCIA
                                    WHEN 'Jan' THEN 1 WHEN 'Feb' THEN 2 WHEN 'Mar' THEN 3 WHEN 'Apr' THEN 4
                                    WHEN 'May' THEN 5 WHEN 'Jun' THEN 6 WHEN 'Jul' THEN 7 WHEN 'Aug' THEN 8
                                    WHEN 'Sep' THEN 9 WHEN 'Oct' THEN 10 WHEN 'Nov' THEN 11 WHEN 'Dec' THEN 12
                                END, 
                                2, '0'
                            ), 
                            '/', PagamentosMensais.CON_DCANO_COMPETENCIA
                        ) AS Mes,
                        ROUND(
                            ((Config.TotalApartamentos - COALESCE(PagamentosMensais.TotalPagantes, 0)) / Config.TotalApartamentos) * 100,
                            2
                        ) AS TaxaInadimplencia
                    FROM 
                        (SELECT 
                             CAST(Valor.CFG_DCVALOR AS UNSIGNED) AS TotalApartamentos
                         FROM 
                             CFG_CONFIGURACAO Valor
                         WHERE 
                             Valor.CFG_DCPARAMETRO = 'QTDE_APARTAMENTOS'
                         LIMIT 1) AS Config
                    LEFT JOIN 
                        (SELECT 
                             SUM(CAST(REGEXP_REPLACE(CONC.CON_DCDESC, '[^0-9]', '') AS UNSIGNED)) AS TotalPagantes,
                             CONC.CON_DCMES_COMPETENCIA,
                             CONC.CON_DCANO_COMPETENCIA
                         FROM 
                             CON_CONCILIACAO CONC
                         WHERE 
                             CONC.CON_DCTIPO = 'RECEITA' 
                             AND CONC.CON_NMTITULO = 'Taxa Condominal'
                         GROUP BY 
                             CONC.CON_DCMES_COMPETENCIA, CONC.CON_DCANO_COMPETENCIA) AS PagamentosMensais
                    ON 
                        TRUE
                    ORDER BY 
                        PagamentosMensais.CON_DCANO_COMPETENCIA ASC, 
                        CASE PagamentosMensais.CON_DCMES_COMPETENCIA
                            WHEN 'Jan' THEN 1 WHEN 'Feb' THEN 2 WHEN 'Mar' THEN 3 WHEN 'Apr' THEN 4
                            WHEN 'May' THEN 5 WHEN 'Jun' THEN 6 WHEN 'Jul' THEN 7 WHEN 'Aug' THEN 8
                            WHEN 'Sep' THEN 9 WHEN 'Oct' THEN 10 WHEN 'Nov' THEN 11 WHEN 'Dec' THEN 12
                        END ASC -- Ordenação crescente do mês e do ano
                    LIMIT 12;
                    ";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PENDENCIAMESFULLINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    ((TotalApartamentos - COALESCE(TotalPagantes, 0)) / TotalApartamentos) * 100 AS Total
                FROM 
                    (
                        SELECT 
                            (SELECT CAST(CFG.CFG_DCVALOR AS UNSIGNED)
                             FROM CFG_CONFIGURACAO CFG
                             WHERE CFG.CFG_DCPARAMETRO = 'QTDE_APARTAMENTOS') AS TotalApartamentos,

                            (SELECT 
                                SUM(CAST(REGEXP_REPLACE(CONC.CON_DCDESC, '[^0-9]', '') AS UNSIGNED))
                             FROM 
                                CON_CONCILIACAO CONC
                             WHERE 
                                CONC.CON_DCTIPO = 'RECEITA' 
                                AND CONC.CON_NMTITULO = 'Taxa Condominal'
                                AND CONC.CON_DCMES_COMPETENCIA = :CON_DCMES_COMPETENCIA
                                AND CONC.CON_DCANO_COMPETENCIA = :CON_DCANO_COMPETENCIA_USUARIO) AS TotalPagantes
                    ) AS Subquery;";


                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':CON_DCANO_COMPETENCIA_USUARIO', $CON_DCANO_COMPETENCIA_USUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':CON_DCMES_COMPETENCIA', $competencia, PDO::PARAM_STR);
                $stmt->execute();
                $PERCINADIMPLENTES = $stmt->fetchColumn();

                return $PERCINADIMPLENTES ;

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  

        public function getFundoReservaFull()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
           
            try{   
                
                $sql = "SELECT * FROM FUR_FUNDO_RESERVA
                        ORDER BY FUR_DCANO DESC,
                                 FIELD(FUR_DCMES, 
                                       'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 
                                       'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro') ASC 
                                       LIMIT 12;";


                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
               // $ARRAY_FUNDORESERVA = $stmt->fetchColumn();
                $ARRAY_FUNDORESERVA = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $ARRAY_FUNDORESERVA;

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  


    }
