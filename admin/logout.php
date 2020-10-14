<?php

	session_start();
	
	if (isset($_SESSION['online_vote'])) {
	   session_destroy();
		header("location: index.php");
	 }

?>