<!DOCTYPE html>
<?php
if(isset($_GET['searchText'])) $searchText =  $_GET['searchText'];
else //redirect
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<title>IITG Code Repository</title>
</head>
<body onload="prettyPrint()">
	<div class="navbar navbar-inverse">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand" href="#">Code Repo</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li class="active"><a href="#"> Home</a></li>
				  <li><a href="#about">Profile</a></li>
				  <li><a href="#about">About</a></li>
				  <li><a href="#contact">Contact</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
				<form class="navbar-search pull-right" method ="GET" action = "search.php">
					<div class="input-prepend">					  
					  <input class="search-query span4" id="inputIcon" type="text" name ="searchText" placeholder="Search someone or something…" value="<?php
					  echo $searchText?>">
					</div>				  
				</form>
			</div>
		  </div>
		</div>

	<div class="container-fluid">
	   <?php
	    search($searchText);
	   echo '<div class="row-fluid">		
	   <hr>
	   </div>';
	   ?>
	</div>
	<script src="assets/js/jquery-1.9.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	function download(){
		alert("hi");
	};
	$(document).ready(function() { 
	//alert('hi');
    $('#pageContent').load('input.cpp');
	}); 
	</script>
</body>
</html>
<?php
	function search($searchText){
		//return $i;
	}
?>