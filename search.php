<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();

if(isset($_GET['searchText'])) $searchText =  $_GET['searchText'];
else header("Location: ./index.php");

$con=mysqli_connect("localhost","root","","repo");

// Check connection
if (!$con)
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


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
	    $con=mysqli_connect("localhost","root","","repo");
		$results=mysqli_query($con,"select distinct u.user_id,u.first_name,p.project_id,p.title,p,description,r.rating 
							from user u,project p, rates r 
							where u.project_id=p.project_id
							and r.project_id=p.project_id
							and ( p.project_id in (select project_id from tag where tag='.$searchText.')
							or u.first_name=".$searchText."
							or u.last_name=".$searchText."
							or u.email=".$searchText."
							or p.title=".$searchText."
							or p.description=".$searchText.")");
	   
	   
	   $count=0;
	   while($i=mysqli_fetch_array($results)){
	   $count++;
		   echo '<div class="row-fluid " style = "background-color:#E8EFFD;">
				<div class="row-fluid ">
				<h5><span class="badge">'.$count.'</span><a href="project.php?user='.$i[0].'">'.$i[1].'</a> / <a href ="project.php?user='.$i[0].'&project='.$i[2].'">'.$i[3].'</a></h5>
				</div>
				<div class="row-fluid ">
				<dl class="dl-horizontal"></d>
				<dt>Rating</dt>
				<dd>'.$i[4].'</dd>
				<dt>Description</dt>
				<dd>'.$i[5].'</dd>
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
	
		
	
?>