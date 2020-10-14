<?php

	$db = new mysqli("localhost", "root", "", "online_vote");
	$query = " DELETE FROM candidates ";
	$query2 = " DELETE FROM vote ";

	$result = mysqli_query($db, $query);
	$result2 = mysqli_query($db, $query2);

	if ($result && $result2) {
		echo '
			<script>
				alert("This session of election has been removed!");
				window.location.href = "home.php";
			</script>
		';
	} else{
		echo '
			<script>
				alert("Problem while deleting election session!");
				window.location.href = "home.php";
			</script>
		';
	}

?>