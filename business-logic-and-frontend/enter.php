<!DOCTYPE html>
<?php
	if(isset($_REQUEST['loginEmail'])) {
		//login
		//echo 'hi ';
		$con = mysql_connect("localhost","root","");
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}
		else{
			mysql_select_db("repo", $con);
			$password = hash("sha512", $_REQUEST['loginPassword']); 
			$query = 'select * from user where email = "'.$_REQUEST['loginEmail'].'" and  password = "'.$_REQUEST['loginPassword'].'"';
			$result = mysql_query($query);
			echo $query ;
			//echo $result;
			if(!$result) {
				echo "invalid username or password"; //alert 
				header("Location : ./login.php");
			}
			else 
			{
			/*user found*/
				session_start();
				$query = "select user_id,first_name, last_name, email from user where email='".$_REQUEST['loginEmail']."';";
				echo $query;
				$result = mysql_query($query);
				while($i = mysql_fetch_assoc($result)){
					$_SESSION['user_id'] = $i['user_id'];
					$_SESSION['first_name'] = $i['first_name'];
					$_SESSION['last_name'] = $i['last_name'];
					$_SESSION['designation'] ="";
					$_SESSION['email'] =$_REQUEST['loginEmail'];
					
				}				
				mysql_close($con);
				header("Location: ./index.php");
			}
				
			
		}
	}
	else if(isset($_REQUEST['inputEmail'])){
	//sign into  a new account
		$con = mysql_connect("localhost","root","");
		echo 'hi ';
		if (!$con){
			die('Could not connect: ' . mysql_error());
		}
		else{
			mysql_select_db("repo", $con);
			$password = hash("sha512", $_REQUEST['inputPassword']);
				
			$query = 'insert into user (`first_name`,`last_name`,`designation`,`email`,`password`) values ("'
			.$_REQUEST['inputFirstName'].'","'
			.$_REQUEST['inputLastName'].'",'
			.$_REQUEST['designation'].',"'
			.$_REQUEST['inputEmail'].'","'
			.$password.'")';
			//	echo $query."<br>";
			$result = mysql_query($query);
			if($result==1){
				session_start();
				$query = 'select user_id,first_name, last_name from user where email="'.$_REQUEST['inputEmail'].'";';
				//echo $query;
				$result = mysql_query($query);
				while($i = mysql_fetch_assoc($result)){
					$_SESSION['user_id'] = $i['user_id'];
					$_SESSION['first_name'] = $i['first_name'];
					$_SESSION['last_name'] = $i['last_name'];
					$_SESSION['designation'] ="";
					$_SESSION['email'] =$_REQUEST['inputEmail'];
					
				}				
				mysql_close($con);
				/*create a folder for the user */
				mkdir('data/'.$_SESSION['user_id']);
				header("Location: ./index.php");
			}
			else{
				echo "inalid email id";
				header("Location : ./login.php");
			}
		}	
	}
	else{
		//do nothing 
		header("Location : ./login.php");
		
	}
?>