<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Method Not Allowed</title>
    <link href="<?=ROOT_URI?>/public/css/errors.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="error-image">
		<img src="<?=ROOT_URI?>/public/img/400.jpg">
	</div>
	<script>
		setTimeout(function() {
			window.location.replace('<?=ROOT_URI?>' + '/home');
		}, 998000);
	</script>
</body>
</html>