<?php

	$db = new mysqli("localhost", "root", "", "online_vote");

	$query = " DELETE FROM candidates WHERE c_id = $_GET[id] ";
	$query2 = " DELETE FROM vote WHERE c_id = $_GET[id] ";

	$result = mysqli_query($db, $query);
	$result2 = mysqli_query($db, $query2);

	if ($result && $result2) {
		header("location: candidates.php?deleted");
	} else{
		echo "Problem while deleting!";
	}

?>