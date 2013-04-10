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
$query = "select code_id,url,extension from code where code_id in (select code_id from contains where project_id = ".$pid.");";
$files= Array();
$results = mysql_query($query);
			if (!$results) {
				die('Invalid query: ' . mysql_error());
			}
		   $count=0;
		   while($i=mysql_fetch_array($results)){
				$files[$count]=$i["url"].$i["code_id"].".".$i["extension"];
				//echo $files[$count]."<br>";
				$count++;
				
			}
$zip = create_zip($files,$pid.".zip");

header('Content-type: Application/zip');
header('Content-Disposition: attachment; filename="'.$pid.'.zip"');
readfile($pid.'.zip');

}

function download_file($fid){
echo " file download starts now... please wait...";
$query = "select url,extension from code where code_id = ".$fid.";";
$results = mysql_query($query);
			if (!$results) {
				die('Invalid query: ' . mysql_error());
			}
		  
		   $addr ="";
		   while($i=mysql_fetch_array($results)){
				$addr=$i["url"].$fid.".".$i["extension"];
			
			}
//$zip = create_zip($addr,$fid.".zip");

//echo $addr;
//echo "****".$fid;
header('Content-type: Application/zip');
header('Content-Disposition: attachment; filename="'.$fid.'.zip"');
readfile($fid.'.zip');
}
mysql_close($con);


function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
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
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
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
		return false;
	}
}
?>