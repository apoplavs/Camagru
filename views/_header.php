<header>

<a href="<?=ROOT_URI?>" id="logo"><img src="<?=ROOT_URI?>/public/img/logo.png"></a>

<nav>

<a href="#" id="menu-icon"></a>

<ul>

<li><a href="<?=ROOT_URI?>" class="current">Головна</a></li>
<li><a href="#">Галерея</a></li>
    <?php
    if (Secure::auth()) {
        echo '
<li><a href="#">Налаштування</a></li>
<li><a href="'.ROOT_URI.'/home">'.$_SESSION['user']['login'].'</a></li>
<li><a href="'.ROOT_URI.'/logout">Вийти</a></li>';
    } else {
        echo '
<li><a href="'.ROOT_URI.'/login">Вхід</a></li>
<li><a href="'.ROOT_URI.'/register">Реєстрація</a></li>';
    }
    ?>
</ul>

</nav>

</header>