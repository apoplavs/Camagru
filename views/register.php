<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="utf-8">
	<title>Camagru Register</title>
	<meta name="keywords" content="Camagru 42 UNIT Factory">
	<meta name="author" content="apoplavs">
	<meta name="description" content="educational project Camagru in UNIT Factory created by Andrii Poplavskiy">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="<?=ROOT_URI?>/public/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?=ROOT_URI?>/public/css/auth.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include_once (ROOT.'/views/_header.php');?>
    <div id="registration">
        <form method="post" action="<?=ROOT_URI?>/register">
            <input type="hidden" name="csrf" value="<?=$csrf_token?>">
            <ul class="input-form">
                <li><span class="error-message"><?php echo (isset($error_message) ? $error_message : "");?></span></li>
                <li><label>Логін <span class="required">*</span></label><input type="text" name="login" class="field-long" maxlength="16" minlength="3" required></li>
                <li>
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" class="field-long" maxlength="32" minlength="5" required>
                </li>
                <li>
                    <label>Пароль <span class="required">*</span></label>
                    <input type="password" name="password" class="field-long" maxlength="32" minlength="6" required>
                </li>
                <li>
                    <label>Підтвердити пароль <span class="required">*</span></label>
                    <input type="password" name="confirm-password" class="field-long" maxlength="32" minlength="6" required>
                </li>
                <li><hr></li>
                <li>
                    <span id="submit-container"><input type="submit" value="Зареєструватися"></span> <span id="registered"><a href="<?=ROOT_URI?>/login">Вже зареєстрований?</a></span>
                </li>
            </ul>
        </form>
    </div>

	<?php include_once (ROOT.'/views/_footer.php');?>
</body>
<script src="<?=ROOT_URI?>/public/js/auth.js"></script>
</html>