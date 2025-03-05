        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="index.html" class="logo logo-light">
                <span class="logo-lg">
                    <img src="../../img/logo_128x32_white.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="../../img/logo_128x128.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="../../img/logo_128x32_black.png" alt="dark logo">
                </span>
                <span class="logo-sm">
                    <img src="../../img/logo_41x41_small.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
                <i class="ri-checkbox-blank-circle-line align-middle"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="ri-close-fill align-middle"></i>
            </div>

            <!-- Sidebar -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!-- Leftbar User -->
                <div class="leftbar-user">
                    <a style="cursor: pointer;" onclick="window.location.href='https://parquedashortensias.codemaze.com.br/pages/listaMoradores/insertMorador.php?apartamento=<?= $apartamentoSession; ?>'" class="dropdown-item">
                        <img src="../../img_pwa/logo_icon.png" alt="user-image" height="42" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name mt-2"><?php $nomeSession = ucwords(strtolower($nomeSession)); echo $nomeSession; ?></span>
                        <span class="leftbar-user-name mt-2"><?php $nivelAcessoFormat = ucwords(strtolower($nivelAcesso)); echo $nivelAcessoFormat; ?></span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title"><?php echo $translations['navegacao']; ?></li>

                    <li class="side-nav-item">
                        <a href="../inicial/index.php" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> <?php echo $translations['inicial']; ?> </span>
                        </a>
                    </li>

                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                    <li class="side-nav-item">
                        <a href="../listaMoradores/index.php" class="side-nav-link">
                            <i class="uil-notes"></i>
                            <span><?php echo $translations['lista_moradores']; ?> </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    
                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                    <li class="side-nav-item">
                        <a href="../fornecedorAvaliacao/index.php" class="side-nav-link">
                            <i class="uil-ruler"></i> 
                            <span> <?php echo $translations['avaliacao_prestadores']; ?> </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($nivelAcesso == 'SUPORTE'): ?>
                    <li class="side-nav-item">
                        <a href="../petControle/index.php" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Meus Pets </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                            <i class="uil-store-alt"></i>  
                            <span class="badge text-white float-end" style="background-color: #21feae; color: white;"><?php echo $translations['novo']; ?></span>
                            <span> <?php echo $translations['salao_de_festas']; ?> </span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="side-nav-second-level">
                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../listaConvidados/index.php"><?php echo $translations['lista_convidados']; ?></a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="#">Reserva de Data</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                            <i class="uil-traffic-barrier"></i>
                            <span> <?php echo $translations['portaria']; ?></span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEcommerce">
                            <ul class="side-nav-second-level">
                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../encomendas/index.php"> <?php echo $translations['encomendas']; ?></a>
                                </li>
                                <?php endif; ?>

                                <li>
                                    <a href="../ctrlVagasVisitante/index.php"><?php echo $translations['vagas_estac']; ?></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
                            <i class="uil uil-tachometer-fast"></i> 
                            <span> <?php echo $translations['administracao']; ?></span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="side-nav-second-level">

                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../dashboard/index.php"><?php echo $translations['indicadores']; ?></a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../auditoria/index.php"><?php echo $translations['auditoria']; ?></a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../agenda/index.php">Agenda</a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../instrucoesAdequacoes/index.php"><?php echo $translations['proc_comunic']; ?></a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../pendenciasAndamento/index.php"><?php echo $translations['evolucao_pend']; ?></a>
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../fornecedorAvaliacao/listaPublicacao.php"><?php echo $translations['lista_publicacao']; ?></a> 
                                </li>
                                <?php endif; ?>

                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                <li>
                                    <a href="../configuracoes/index.php"><?php echo $translations['configuracoes']; ?></a> 
                                </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    </li>
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->