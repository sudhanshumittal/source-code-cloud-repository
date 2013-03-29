<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
require 'core.inc.php';
$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			//echo "damn it";
			die('Could not connect: ' . mysql_error());
		}
		else
		{
		mysql_select_db("events", $con);
		}
?>
<head>

<title>SIGACT</title>

<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<meta name="description" content="Site Description Here" />
<meta name="keywords" content="keywords, here" />
<meta name="robots" content="index, follow, noarchive" />
<meta name="googlebot" content="noarchive" />

<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />

</head>
<body>

	<!-- header starts-->
	<div id="header-wrap"><div id="header" class="container_16">						
		
		<h1 id="logo-text"><a href="index.html" title="">Sigact</a></h1>
		<p id="intro">Special Interest Group in Algorithms
and Computation Theory</p>
		
		<!-- navigation -->
		<div  id="nav">
		
			<ul>
				<li ><a href="index.php">Home</a></li>
				<li id="current"><a href="members.php">Members</a></li>
				<li><a href="profile.php">Profile</a></li>
				<li><a href="index.html">About</a></li>		
			</ul>		
		</div>		
		
		<div id="header-image"></div> 		
		
	<!--	<form id="quick-search" action="index.html" method="get" >
			<p>
			<label for="qsearch">Search:</label>
			<input class="tbox" id="qsearch" type="text" name="qsearch" value="Search..." title="Start typing and hit ENTER" />
			<input class="btn" alt="Search" type="image" name="searchsubmit" title="Search" src="images/search.gif" />
			</p>
		</form>					
	-->
	<!-- header ends here -->
	</div></div>
	
	<!-- content starts -->
		<div id="content-outer"><div id="content-wrapper" class="container_12">
				<!-- sub navigation -->
				<div id="main" class="grid_2">
					<ul>
						<li><a href="members.php?pos=1">Faculty</a></li>
						<li><a href="members.php?pos=2">B.tech</a></li>
						<li><a href="members.php?pos=3">M.tech</a></li>
						<li><a href="members.php?pos=4">PhD</a></li>
					</ul>
				</div>
				<!-- dynamically generated list -->
				<div id="left-columns" class="grid_16">
				
					<?php
						if(isset($_GET['pos'])){
							
							$result = mysql_query( "SELECT * FROM members WHERE position = '".$_GET['pos']."' ");
								{while($row = mysql_fetch_array($result))
								{
									echo "<div style='background-color: #eeeeee; width:500px; '><p><strong>".$row['name']."</strong><br>";
									echo $row['username']."@iitg.ernet.in<br>";
									echo "Interests : ".$row['interests']."</p></div><br>";
								}
								}
						}
					?>
				</div>
		</div></div>	

	<!-- footer starts here -->	
	<div id="footer-wrapper" class="container_16">
		
			
	</div>
	<!-- footer ends here -->
</body>
</html>
