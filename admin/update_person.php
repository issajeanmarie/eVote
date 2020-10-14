<?php

	error_reporting(0);

	$db = new mysqli("localhost", "root", "", "online_vote");

	//require '../inc/conn.php';
	if (isset($_POST['updatePerson'])) {
		
		//Read data
		$fName = $_POST['firstName'];
		$lName = $_POST['lastName'];
		$Cell = $_POST['cell'];
		$Village = $_POST['village'];
		$age = $_POST['age'];
		$ID = $_POST['id'];
		

		$query = " UPDATE people SET fname = '$fName', lname = '$lName', cell = '$Cell', village = '$Village', age = '$age', identity = '$ID' WHERE p_id = $_GET[id] ";
		$result = mysqli_query($db, $query);
		if ($result) {
			$message = "Candidate updated successfuly!";
			header("location: people.php?updated");
		} else{
			$message = "Problem while updating data!";
		}


	}

	//Getting data to display in inputs
	$query = " SELECT * FROM people WHERE p_id = $_GET[id] ";
	$result = mysqli_query($db, $query);
	$row =mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width = device-width, initial-scale = 1.0">
	<meta name="keywords" content="Online Voting, Vote Online">
	<meta name="description" content="Good system to vote online">
	<title>Online Voting</title>
	<link rel="stylesheet" type="text/css" href="../assets/style/css.css">
	<link rel="stylesheet" type="text/css" href="../assets/icons/icons/style.css">
</head>
<body class="index">

	<header class="main-header">
		<div class="brand">
			<div class="brand-img">
				<img src="../assets/images/Mobile voting.jpg">
			</div>
			<span class="brand-word">
				Rugero Sector eVote
			</span>
		</div>

		<nav>
			<ul>
				<li><a href="logout.php"><span class="icon_lock_alt"></span> Logout</a></li>
				<li><a href="people.php" class="current"><span class="icon_group"></span> People</a></li>
				<li><a href="candidates.php"><span class="icon_datareport_alt"></span> Candidates</a></li>
				<li><a href="../#"><span class="icon_house_alt"></span> Home</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">

		<form method="post" enctype="multipart/form-data" class="form-update">

			<p class="update-owner-names">
				Update <?php echo $row['fname']. " ". $row['lname']; ?>
			</p>

			<label>First name</label>
			<br />
			<input type="text" name="firstName" placeholder="First name..." value="<?php echo$row['fname'] ?>">
			<br />

			<label>Last name</label>
			<br />
			<input type="text" name="lastName" placeholder="Last name..." value="<?php echo$row['lname'] ?>">
			<br />

			<label>Cell</label>
			<br />
			<input type="text" name="cell" placeholder="Cell..." value="<?php echo$row['cell'] ?>">
			<br />

			<label>Village</label>
			<br />
			<input type="text" name="village" placeholder="Village..." value="<?php echo$row['village'] ?>">
			<br />

			<label>Age</label>
			<br />
			<input type="text" name="age" placeholder="Age..." value="<?php echo$row['age'] ?>">
			<br />

			<label>ID Number</label>
			<br />
			<input type="number" name="id" placeholder="ID..." value="<?php echo$row['identity'] ?>">
			<br />
			<br />

			<input type="submit" name="updatePerson" value="Update">
		</form>

	</div>


	<!-- Vote section -->
	<section class="vote-wrapper">
		<section class="vote newPerson">
			<p>
				Add new candidate
				<span class="close" id="close">X</span>
			</p>

			<form method="post" enctype="multipart/form-data">

				<label>First name</label>
				<br />
				<input type="text" name="firstName" placeholder="First name...">
				<br />

				<label>Last name</label>
				<br />
				<input type="text" name="lastName" placeholder="Last name...">
				<br />

				<label>Position</label>
				<br />
				<input type="text" name="position" placeholder="Position...">
				<br />

				<label>Party</label>
				<br />
				<input type="text" name="party" placeholder="Party...">
				<br />

				<label>Description</label>
				<br />
				<input type="text" name="desc" placeholder="Description...">
				<br />

				<label>Profile</label>
				<br />
				<input type="file" name="profile" placeholder="Profile...">
				<br />
				<br />

				<input type="submit" name="addCand" value="Add candidate">
			</form>
		</section>
	</section>

</body>
<script type="text/javascript">
	let wrapper = document.querySelector('.vote-wrapper');
	let opener = document.querySelector('#add-person');
	let close = document.querySelector('.close');

	function runForm(e) {
		e.preventDefault();

		wrapper.style.display = "block";
	}

	function closeForm(e) {
		e.preventDefault();

		wrapper.style.display = "none";
	}

	opener.addEventListener('click', runForm);
	close.addEventListener('click', closeForm);
</script>
</html>