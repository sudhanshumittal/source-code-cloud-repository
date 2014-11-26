<!DOCTYPE html>
<?php
include './include.php';
session_start();
if(!in_session()) destroy_session();
$con = mysql_connect("localhost","root","");
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	else{
		mysql_select_db("repo", $con);
	
if(isset($_GET['project_id'])&&!isset($_GET['file_id'])) download_project($_GET['project_id']);
else if(isset($_GET['file_id'])) download_file($_GET['file_id']);
}
function download_project($pid){
echo "project download starts now... please wait..."; 
$query = "select code_id,url,extension,title from code where code_id in (select code_id from contains where project_id = ".$pid.");";
$files= Array();
$temp_files=Array();
$results = mysql_query($query);
			if (!$results) {
				die('Invalid query: ' . mysql_error());
			}
		   $count=0;
		   while($i=mysql_fetch_array($results)){
				$files[$count]=$i["url"].$i["code_id"];
				$temp_files[$count]=$i["title"];
				copy($files[$count],$temp_files[$count]);
				echo $files[$count]."<br>";
				$count++;
				
			}
echo "<br><br>";
$zip = create_zip($temp_files,$pid.".zip",true);
for($i = 0; $i<count($temp_files);$i++) unlink($temp_files[$i]);
if($zip == false) echo "false";
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$pid.'.zip');
header('Content-Length: '.filesize($zipfilename));
readfile($pid.'.zip');
//unlink($pid.'.zip');

}

function download_file($fid){
echo " file download starts now... please wait...";
$query = "select url,extension,title from code where code_id = ".$fid.";";
$results = mysql_query($query);
			if (!$results) {
				die('Invalid query: ' . mysql_error());
			}
		  
		   $addr ="";
		   $temp_addr=Array();
		   while($i=mysql_fetch_array($results)){
				$addr=$i["url"].$fid;
				echo "<br>".$addr;
				$temp_addr[0]=$i["title"];
				echo " ".$temp_addr;
				copy($addr,$temp_addr[0]);
			}
$name =$temp_addr[0];
$zip = create_zip($temp_addr,$name.".zip");
unlink($temp_addr[0]);
header('Content-type: Application/zip');
header('Content-Disposition: attachment; filename="'.$name.'.zip"');
readfile($name.'.zip');

}
mysql_close($con);


function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { 
		echo $destination."<br>";
		return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	
	echo "count(valid files) = ".count($valid_files)."<br>";
	
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			echo "here";
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		echo "hi";
		return false;
	}
}
?>