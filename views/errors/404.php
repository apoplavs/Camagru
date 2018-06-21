<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Method Not Allowed</title>
</head>
<body>
	<style type="text/css">
	#error-image {
	padding-top: 60px;
	text-align: center;
	width: 90%;
	position: fixed;
	}
	</style>

<div id="error-image">
	<img src="<?=ROOT?>/public/img/404.png">
</div>
<script>
	setTimeout(function() {
		window.location.replace(window.location.host.toString() + '<?=ROOT_URI?>' + '/home');
	}, 2000);
</script>
</body>
</html>