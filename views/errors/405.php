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
	<img src="<?=ROOT.?>/public/img/405.jpg">
</div>
<script>
	setTimeout(function() {
		location.pathname = <?=ROOT_URI?> + '/home';
	}, 8000);
</script>
</body>
</html>