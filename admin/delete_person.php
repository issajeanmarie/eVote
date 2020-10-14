<?php

	$db = new mysqli("localhost", "root", "", "online_vote");
	$query = " DELETE FROM people WHERE p_id = $_GET[id] ";
	$result = mysqli_query($db, $query);

	if ($result) {
		header("location: people.php?deleted");
	} else{
		echo "Problem while deleting!";
	}

?>