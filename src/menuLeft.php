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
                        <img src="../../assets/images/users/Hall.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name mt-2"><?php $nomeSession = ucwords(strtolower($nomeSession)); echo $nomeSession; ?></span>
                        <span class="leftbar-user-name mt-2"><?php $nivelAcessoFormat = ucwords(strtolower($nivelAcesso)); echo $nivelAcessoFormat; ?></span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Navegação</li>

                    <li class="side-nav-item">
                        <a href="../inicial/index.php" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> Inicial </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="../listaMoradores/index.php" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Lista de Moradores </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="../fornecedorAvaliacao/index.php" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Avaliação de Prestadores </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="../petControle/index.php" class="side-nav-link">
                            <i class="uil-comments-alt"></i>
                            <span> Meus Pets </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm" class="side-nav-link">
                            <i class="uil uil-tachometer-fast"></i>
                            <span class="badge bg-danger text-white float-end">New</span>
                            <span> Salão de Festas </span>
                        </a>
                        <div class="collapse" id="sidebarCrm">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="../listaConvidados/index.php">Lista de Convidados</a>
                                </li>
                                <li>
                                    <a href="#">Reserva de Data</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                            <i class="uil-store"></i>
                            <span> Portaria </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEcommerce">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="../encomendas/index.php">Encomendas</a>
                                </li>
                                <li>
                                    <a href="../ctrlVagasVisitante/index.php">Vagas Estac. Visitantes</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail" class="side-nav-link">
                            <i class="uil-envelope"></i>
                            <span> Administração </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="../dashboard/index.php">Indicadores</a>
                                </li>
                                <li>
                                    <a href="../auditoria/index.php">Auditoria</a>
                                </li>
                                <li>
                                    <a href="../agenda/index.php">Agenda</a>
                                </li>
                                <li>
                                    <a href="../informacoesUteis/index.php">Informações Úteis</a>
                                </li>
                                <li>
                                    <a href="../pendenciasAndamento/index.php">Evolução Pendencias</a>
                                </li>
                                <li>
                                    <a href="../configuracoes/index.php">Configurações</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->