<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
		require 'core.inc.php';
		if(!isset($_SESSION['username']))
		{
			header( 'Location: index.php' ) ;
		}
		$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		if( isset($_GET['name'] ))
		{
				if(isset($_GET['getmails']))
				$getmail = 1;
				else
				$getmail = 0;
				mysql_select_db("events", $con);
				$username = $_SESSION['username'];
				//mysql_query("INSERT");
				
				mysql_query("UPDATE members SET 
				username = '".$username."', 
				name= '".$_GET['name']."' , 
				interests= '".$_GET['interests']."', 
				position = '".$_GET['position']."',
				getmails = '".$getmail."'
				WHERE username ='".$username."';");
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
<script>
//alert("hi");
function showall(){
	//alert("show all");
	$box = document.getElementById('allevents');
	//alert($box.innerhtml);
	if($box.style.visibility == 'hidden') $box.style.visibility = 'visible';
	else $box.style.visibility = 'hidden';
}
</script>
</head>
<body>

	<!-- header starts-->
	<div id="header-wrap"><div id="header" class="container_16">						
		
		<h1 id="logo-text"><a href="index.php" title="">Sigact</a></h1>
		<p id="intro">Special Interest Group in Algorithms
and Computation Theory</p>
		
		<!-- navigation -->
		<div  id="nav">
			<ul>
				<li ><a href="index.php">Home</a></li>
				<li><a href="members.php">Members</a></li>
				<li id="current"><a href="">Profile</a></li>
				<li><a href="index.php">About</a></li>		
			</ul>		
		</div>		
		
		<div id="header-image"> </div>		
					
	
	<!-- header ends here -->
	</div></div>
	
	<!-- content starts -->
	<div id="content-outer"><div id="content-wrapper" class="container_16">
	
			
		<!-- left-columns starts -->
		<div id="left-columns" class="grid_8">
			
			<div class="grid_8 alpha" style="background-color:#eeeeee;">
				<?php
				mysql_select_db("events", $con);
				$username = $_SESSION['username'];
				$posArray = Array('Faculty', 'B. Tech','M. Tech','PhD');
				
				$result = mysql_query( "SELECT * FROM members WHERE username = '".$username."' ");
				$row = mysql_fetch_array($result);
				
				if (isset($_GET['edit'])){
				echo "
				<form action='profile.php' method = 'get'>
					<table style='width : 400px;'>
					<tr>
						<td>Username: </td>
						<td>".$username."</td>
						
						
					</tr>
					<tr>
						<td>Name: </td>
						<td><input type='text' name='name' value='".$row['name']."'  /></td>
					</tr>
					<tr>
						<td>Position: </td>						
						<td><select name='position'>";
						$str ="asda ";
						for($i= 1; $i <= count($posArray); $i+=1) {
						$str .=  "<option value= '".$i."'";
						if($i == $row['position'] ) $str .= "selected ='selected'"; 
						$str .= "> ".$posArray[ $i-1 ]." </option>";
						}
						echo $str;
		
					echo "</select></td>
					</tr>
					<tr>
						<td>Interests:</td>
						<td><input type='text' name='interests' value='".$row['interests']."' /></td>
					</tr>
					<tr>
							<td><input type='checkbox' name = 'getmails'";
							if($row['getmails']==1) echo "checked";
					echo "/> subscribe to emails</td>
					
							<td><input type='submit'  value='Update' /></td>
					</tr>
					</table>	
				</form>";
				}
				else echo "
					<a href = 'profile.php?&edit=1' style='float:left;'>edit</a><br>
					
					<table style='width : 400px;'>
					<tr>
						<td>Username: </td>
						<td>".$username."</td>
						
						
					</tr>
					<tr>
						<td>Name: </td>
						<td>".$row['name']."</td>
					</tr>
					<tr>
						<td>Position: </td>
						<td>".$posArray[$row['position']-1]."</td>
					</tr>						
						<td>Interests: </td>
						<td>".$row['interests']."</td>
					</tr>
					<tr>
					<td> Subscribed to emails </td>
					<td>";
					if($row['getmails']==1) echo "yes";
					else echo "no";
					echo "</td>
					</tr>	
					</table>	";
					
				?>
			</div>
		
			
		<!-- end left-columns -->
		</div>		
	<!-- contents end here -->	
	</div>
	<!-- footer starts here -->	
	<div id="footer-wrapper" class="container_16">

		
			
	</div>
	<!-- footer ends here -->

</body>
</html>
<?php
		if($con){
		mysql_close($con);
		}
?>