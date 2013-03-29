<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
require_once 'core.inc.php';
require_once 'connection.php'
$admin = "m.sudhanshu"; /*change the username here to gain admin rights of creating an event*/
if(isset($_GET['retry'])) echo "invalid entry.";
$con = mysql_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		else
		{
		mysql_select_db("events", $con);
		if(isset($_POST['date'])) {
			
			$dateval = (string) $_POST['date'];
			$timeval = (string) $_POST['time'];
			$creator = 'saswata';
			$details = (string) $_POST['details'];
			$venue = (string)$_POST['venue'];
			//$query = ;
			if('2012-11-28' == $dateval) print "yes";
			mysql_query("INSERT INTO eventlist(date, time, creator, details, venue)
VALUES ( '".$dateval."', '".$timeval."', '".$creator."', '".$details."', '".$venue."' )");
			
		}
		/*delete selected events*/
		else if(isset($_GET['event'])){
			$eventlist =  $_GET['event'];
			//echo $eventlist[1];
			for($x =0; $x< count($eventlist); $x++){
				$query = "DELETE FROM `events`.`eventlist` WHERE `eventlist`.`index` =".$eventlist[$x].";";
				$result = mysql_query($query);
			}
		}
	 }
	  //else echo("no");
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
function showall(){
	$box = document.getElementById('allevents');
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
				<li id="current"><a href="index.php">Home</a></li>
				<li><a href="members.php">Members</a></li>
				<li><a href="profile.php">Profile</a></li>
				<li><a href="index.php">About</a></li>		
			</ul>		
		</div>		
		
		<div id="header-image"> </div>	
		
		<form id="quick-search" action="redirect.php" method="post" >
			<div>
			<?php
			if(!isset($_SESSION['username'])){ 
			echo '<p>
			<!--<label for="qsearch">Search:</label>
			<input class="tbox" id="qsearch" type="text" name="qsearch" value="Search..." title="Start typing and hit ENTER" />
			<input class="btn" alt="Search" type="image" name="searchsubmit" title="Search" src="images/search.gif" />
			-->
			<label>webmail id</label><input class ="tbox" type ="text"  name= "username"  title="webmail id"/>
			<label>password</label><input class ="tbox" type="password" name= "password" title="password"/>
			<select class ="tbox" name="loginServer">
				<option value="teesta">Teesta</option>
				<option value="naambor">Naambor</option>
				<option value="disang">Disang</option>
				<option value="tamdil">Tamdil</option>
				<option value="dikrong">Dikrong</option>
			</select>
			<input class ="tbox" type="submit" value="login" style="background-color:#7ba45b; color:white;width:50px;" />
			
			</p>';
			} 
			else
			{ 
			echo '<label style="right: 0px;"><a href="logout.php" >Log out</a></label>';
			}
			?>
			<p>
		
		</form>					
	
	<!-- header ends here -->
	</div></div>
	
	<!-- content starts -->
	<div id="content-outer"><div id="content-wrapper" class="container_16">
	
		<!-- main -->
		<div id="main" class="grid_8">
				
			<a name="TemplateInfo"></a>
			<h2>Objectives</h2>
			
			<p class="post-info">Posted by <a href="index.html">Sudhanshu</a>  
				
            <p><strong>Sigact</strong> is a group comprising of faculty members and
students (B.Tech., M.Tech./M.Sc. and Ph.D.) which aims at
organizing seminar series, problem solving sessions, summer/winter
short-research-courses, inviting talks etc. among other
activities.
            </p>
			
		<!-- main ends -->
		</div>
		
		<!-- left-columns starts -->
		<div id="left-columns" class="grid_8">
			
			<div class="grid_4 alpha">
				
				<div class="sidemenu">	
					<h3>Upcoming Events</h3>
					<ul>
						<?php 
							$datenow = (string) date('Y-m-d', time());
							echo '<form action ="index.php" method= "get" >';
								if (isset($_SESSION['username']) && $_SESSION['username']==$admin){
								echo '<input type="submit" value="Delete selected events" />';
								}								
								
						?>	
						<li>Today(<?php echo $datenow; ?>)</li>
							<ul>
							<?php
								$result = mysql_query( "SELECT * FROM eventlist WHERE date = '".$datenow."' order by time");
								while($row = mysql_fetch_array($result))
								{
									if (isset($_SESSION['username']) && $_SESSION['username']==$admin){
										echo '<li><input type="checkbox" name="event[]" value="'.$row['index'].'" /> <strong>'.$row['time'].' @'.$row['venue'].'</strong><br>';
										echo "". $row['details']."</li>";
									}
									else
									{
										echo '<li><strong>'.$row['time'].' @'.$row['venue'].'</strong><br>';
										echo "". $row['details']."</li>";
									}
								}
							    
							?>

							</ul>
						<li><a href="#" onclick ="showall()" >show all</a>
							<ul id="allevents" style="visibility:hidden;">
							<?php
								$result = mysql_query( "SELECT * FROM eventlist order by time");
								while($row = mysql_fetch_array($result))
								{
									if ( $row['date']> $datenow){
										if (isset($_SESSION['username']) && $_SESSION['username']==$admin ){
										echo '<li><input type="checkbox" name="event[]" value="'.$row['index'].'" /> <strong>'.$row['date'].'</strong><br>';
										echo "<strong>".$row['time']." @".$row['venue']."</strong><br>";
										echo "". $row['details']."</li>";
									
										}	
										else
										{
										echo '<li><strong>'.$row['date'].'</strong><br>';
										echo "<strong>".$row['time']." @".$row['venue']."</strong><br>";
										echo "". $row['details']."</li>";
										}
									}
								}
								
								echo "</form>";
							
							?>
							
							</ul>
						</li>
					</ul>	
				</div>
			
				
				
		
			</div>
		
			<div class="grid_4 omega">
				<?php
					if (isset($_SESSION['username']) && $_SESSION['username']==$admin) 
					{
							echo'
						<h3>Create event</h3>		
						<div class="featured-post">
							<form method ="post" action="index.php" >
								<strong>Date</strong>
								<p><input name="date" type="date" value ='.$datenow.' /></p>
								<strong>Time</strong>
								<p><input name="time"  type="time" value = "12:00:00" ></p>
								<strong>Venue</strong>
								<p><input name="venue"  type="text" value = "CSE seminar hall" ></p>
								<strong>Details</strong>
								<p><textarea rows="4" name ="details" >Short desciption</textarea></p>
								<input type="submit" value="Create"/>
							</form>
							
						</div>';
				    }
				?>
				<h3>Wise Words</h3>
				<p>
				&quot;We are what we repeatedly do. Excellence, therefore, is not an act but a habit.&quot; </p>
			
				<p class="align-right"> - Aristotle</p>
				
			
			</div>	
		
		<!-- end left-columns -->
		</div>		
	
	<!-- contents end here -->	
	</div></div>

	<!-- footer starts here -->	
	<div id="footer-wrapper" class="container_16">
		
		
			
	</div>
	<!-- footer ends here -->

</body>
</html>
<?php
	if(isset($_POST['date'])){
		mysql_close($con);
	}
?>