     
        
<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $webmailUrl = $baseUrl . "/webmail";
?>
        
        <!-- ========== Horizontal Menu Start ========== -->
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="../inicial/index.php" id="topnav-components" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-home-alt"></i>Início <div class="dropdown-item"></div>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-location-point"></i>Condomínio <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">

                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../listaMoradores/index.php" class="dropdown-item">Lista de Moradores</a>                                                           
                                    <?php endif; ?>      
                                    
                                    <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../petControle/index.php" class="dropdown-item">Meus Pets</a>  
                                    <?php endif; ?>                                                         
                                    
                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../fornecedorAvaliacao/index.php" class="dropdown-item">Aval. Prestadores</a>
                                    <?php endif; ?>    
                                                                        
                                </div>
                            </li>     
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-box"></i>Salão de Festas <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../listaConvidados/index.php" class="dropdown-item">Minha lista de convidados</a>
                                    <?php endif; ?> 
                                    <?php if ($nivelAcesso == 'DEV'): ?>
                                    <a href="../churrascometro/index.php" class="dropdown-item">Churrascômetro</a>
                                    <?php endif; ?> 
                                </div>
                            </li>    
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil uil-building"></i>Portaria <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">

                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../encomendas/index.php" class="dropdown-item">Encomendas</a>
                                    <?php endif; ?> 

                                    <a href="../ctrlVagasVisitante/index.php" class="dropdown-item">Vagas Estac. Visitantes</a>

                                </div>
                            </li>                   
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil uil-tachometer-fast"></i>Administração <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../dashboard/index.php" class="dropdown-item">Indicadores</a>
                                    <?php endif; ?> 

                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../auditoria/index.php" class="dropdown-item">Auditoria</a>
                                    <?php endif; ?> 

                                    <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../agenda/index.php" class="dropdown-item">Agenda</a>
                                    <?php endif; ?>

                                    <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../informacoesUteis/index.php" class="dropdown-item">Informações Úteis</a>
                                    <?php endif; ?>

                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../pendenciasAndamento/index.php" class="dropdown-item">Evolução / Pendências</a>
                                    <?php endif; ?>                                    
                                    
                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                    <a href="../configuracoes/index.php" class="dropdown-item">Configurações</a>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="../logoff/index.php" id="topnav-components" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="ri-logout-box-r-line"></i>Sair <div class="dropdown-item"></div> 
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ========== Horizontal Menu End ========== -->