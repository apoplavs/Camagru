<header>

<a href="<?=ROOT_URI?>" id="logo"><img src="<?=ROOT_URI?>/public/img/logo.png"></a>

<nav>

<a href="#" id="menu-icon"></a>

<ul>

<li><a href="<?=ROOT_URI?>" class="current">Головна</a></li>
<li><a href="#">Налаштування</a></li>
<li><a href="#">Галерея</a></li>
    <?php
    if ($_SESSION && $_SESSION['login']) {
        echo '<li><a href="#">'.$_SESSION["login"].'</a></li>';
    } else {
        echo '<li><a href="#">Вхід</a></li>
               <li><a href="#">Реєстрація</a></li>';
    }
    ?>
</ul>

</nav>

</header>