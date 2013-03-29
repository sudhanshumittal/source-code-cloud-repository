<?php
/*all inculded functions */
function in_session(){
	return isset($_SESSION['user_id']);
}
function destroy_session(){
	/*destro session*/
	session_start();
	session_destroy();
	/*redirect to login*/
	header("Location: ./login.php");

}
?>