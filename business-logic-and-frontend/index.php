<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
		padding-left: 60px;
		padding-right: 60px;
	  }
    </style>
	<title>IITG Code Repository</title>
</head>
<body >
	<?php
		menu('index');
	?>

 <div class="hero-unit">
        <h1>Welcome to IITG Source Code Repository!</h1>
		<p>We provide you a platform to share, discuss and critic source codes with programming enthusiasts in IIT Guwahati. </p>
        <p><a href="./about.php" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
</div>
<div class= "container-fluid">
	<div class="row-fluid">
		<div class="span4">
		<div class="thumbnail">
		<img data-src="holder.js/160x120" alt="" src = "assets/img/upload-2-256.gif">
		
		<h3>Share</h3>
		<p>your code</p>
		</div>
		</div>
		
		<div class="span4">
		<div class="thumbnail">
		<img data-src="holder.js/160x120" alt="" src = "assets/img/download-13-256.gif">
		
		<h3>Share</h3>
		<p>your code</p>
		</div>
		</div>
		
		<div class="span4">
		<div class="thumbnail">
		<img data-src="holder.js/160x120" alt="" src = "assets/img/chat-3-256.gif">
		
		<h3>Share</h3>
		<p>your code</p>
		</div>
		</div>
		
	</div>
</div>	
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	</body>
</html>