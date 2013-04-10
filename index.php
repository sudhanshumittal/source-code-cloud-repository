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
        <h1>Wlcome to IITG Source Code Repository!</h1>
		<p>We provide a platform to share your code with other programming enthusiasts in IIT Guwahati</p>
        <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>
	
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	</body>
</html>