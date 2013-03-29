<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();

if(isset($_GET['searchText'])) $searchText =  $_GET['searchText'];
else header("Location: ./index.php");
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link rel = "stylesheet" href="assets/css/bootstrap.min.css">
	<title>IITG Code Repository</title>
	 <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
		padding-left: 60px;
		padding-right: 60px;
	  }
    </style>
</head>
<body onload="prettyPrint()">
	<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="brand" href="#">Code Repo</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">
				  <li class="active"><a href="#"> Home</a></li>
				  <li><a href="#about">Profile</a></li>
				  <li><a href="#about">About</a></li>
				  <li><a href="#contact">Contact</a></li>
				  <li class="pull right"><a href ="./signout.php">Sign out</a></li>
				</ul>
			  </div><!--/.nav-collapse -->
				<form class="navbar-search pull-right" method ="GET" action = "search.php">
					<div class="input-prepend">					  
					  <input class="search-query span4" id="inputIcon" type="text" name ="searchText" placeholder="Search someone or something…" value="<?php
					  echo $searchText;?>">
					</div>				  
				</form>
			</div>
		  </div>
		</div>

	<div class="container-fluid span12 offset3">
	   <?php
	   $results =  search($searchText);
	   //var_dump($results);
	   foreach( $results as $i){
		   echo '<div class="row-fluid " style = "background-color:#E8EFFD;">
				<div class="row-fluid ">
				<h5><span class="badge">1 </span><a href="project.php?user=sudhanshumittal" > username </a>/ <a href ="#">projectname</a></h5>
				</div>
				<div class="row-fluid ">
				<dl class="dl-horizontal"></d>
				<dt>Rating</dt>
				<dd>7/10</dd>
				<dt>Description</dt>
				<dd>blabblablabl</dd>
				</div>
		   </div><hr>';
	   }
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
		$i= Array(1,2,3);
		return $i;
	}
?>