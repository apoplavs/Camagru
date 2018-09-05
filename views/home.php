<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" charset="utf-8">
	<title>Camagru Home</title>
	<meta name="keywords" content="Camagru 42 UNIT Factory">
	<meta name="author" content="apoplavs">
	<meta name="description" content="educational project Camagru in UNIT Factory created by Andrii Poplavskiy">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="<?=ROOT_URI?>/public/css/style.css" rel="stylesheet" type="text/css">
	<link href="<?=ROOT_URI?>/public/css/home.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php include_once (ROOT.'/views/_header.php');?>
<div id="container">
	<div id="camera-frame">
		<div id="camera">
			<video id="video" muted="muted">Камера недоступна</video>
			<img id="draw-object" alt="">
			<button id="photo-button"></button>
		</div>
		<canvas style="display: none" id="canvas">
		</canvas>
		<br>
	</div>
</div>
<div id="objects">
		<div class="frames" id="frames1">
			<img src="<?=ROOT_URI?>/public/img/frames/1.png">
					<!-- <input name="frame" type="radio"  onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/1.gif'"> -->
			<img src="<?=ROOT_URI?>/public/img/frames/2.png">
					<!-- <input name="frame" type="radio" onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/2.png'"> -->
			<img src="<?=ROOT_URI?>/public/img/frames/3.png">
			<img src="<?=ROOT_URI?>/public/img/frames/4.png">
			<img src="<?=ROOT_URI?>/public/img/frames/5.png">
			<img src="<?=ROOT_URI?>/public/img/frames/6.png">
			<img src="<?=ROOT_URI?>/public/img/frames/7.png">
					<!-- <input name="frame" type="radio" onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/3.png'"> -->
		</div>
		<div class="frames" id="frames2">
			
					<!-- <input name="frame" type="radio" onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/4.png'"> -->
			<img src="<?=ROOT_URI?>/public/img/frames/8.gif">
					<!-- <input name="frame" type="radio" onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/5.png'"> -->
			<img src="<?=ROOT_URI?>/public/img/frames/9.png">
			<img src="<?=ROOT_URI?>/public/img/frames/10.png">
			<img src="<?=ROOT_URI?>/public/img/frames/11.png">
			<img src="<?=ROOT_URI?>/public/img/frames/12.png">
			<img src="<?=ROOT_URI?>/public/img/frames/13.png">
			<img src="<?=ROOT_URI?>/public/img/frames/14.png">
					<!-- <input name="frame" type="radio" onclick="document.getElementById('draw-object').src = '<?=ROOT_URI?>/public/img/frames/6.png'"> -->
		</div>
	</div>

	<?php include_once (ROOT.'/views/_footer.php');?>
</body>
<script src="<?=ROOT_URI?>/public/js/home.js"></script>
</html>