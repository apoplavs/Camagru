<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="utf-8">
	<title>Camagru Sign in</title>
	<meta name="keywords" content="Camagru 42 UNIT Factory">
	<meta name="author" content="apoplavs">
	<meta name="description" content="educational project Camagru in UNIT Factory created by Andrii Poplavskiy">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="<?=ROOT_URI?>/public/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?=ROOT_URI?>/public/css/auth.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include_once (ROOT.'/views/_header.php');?>
<div id="login">
	<form method="post" action="<?=ROOT_URI?>/reset-pass">
		<input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
		<ul class="input-form">
			<li><span class="error-message"><?php echo (isset($error_message) ? $error_message : "");?></span>
				<span class="notice-message"><?php echo (isset($message) ? $message : "");?></span></li>
			<li>
				<label>Введіть email, який був вказаний при реєстрації
					<input type="email" name="email" class="field-long" maxlength="32" minlength="5" required>
				</label>
			</li>
			<li><hr></li>
			<li>
				<input type="submit" value="Надіслати URL для відновленя паролю">
			</li>
		</ul>
	</form>
</div>

<?php include_once (ROOT.'/views/_footer.php');?>
</body>
</html>
