
<style>
/* Estilo básico para o menu */
.nav.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav.menu > li {
    display: inline-block;
    position: relative;
}

.nav.menu a {
    text-decoration: none;
    padding: 10px 15px;
    display: block;
    color: black; /* Texto preto para o menu principal */
}

/* Estilo para o submenu */
.submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    top: -10px; /* Alinha o submenu ao topo do item pai */
    left: 100%; /* Submenu abre imediatamente ao lado */
    display: none; /* Submenu oculto por padrão */
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    width: 100%; /* O submenu ocupa toda a largura do item pai */
    z-index: 1000; /* Certifica-se de que o submenu aparece por cima */
}

.submenu li {
    display: block;
}

.submenu a {
    padding: 20px 15px;
    white-space: nowrap;
    color: black; /* Texto preto para os itens do submenu */
    background-color: #fff; /* Fundo branco para contraste */
}

.submenu a:hover {
    background-color: #f0f0f0; /* Efeito hover no submenu */
}

/* Mostrar submenu ao passar o mouse */
.nav.menu > li:hover .submenu {
    display: block;
}

/* Responsivo: ajuste do submenu em telas menores */
@media (max-width: 768px) {
    .submenu {
        position: absolute;
        top: 100%; /* Alinha o submenu abaixo do item pai */
        left: 0; /* Submenu abre logo abaixo do item pai */
        width: 100%; /* Garante que o submenu se ajuste ao tamanho do item pai */
    }
}




</style>

<nav class="navigation">
    <ul class="nav menu">
        <?php echo $menu; ?>
    </ul>
</nav>