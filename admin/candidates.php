<?php

	error_reporting(0);

	$db = new mysqli("localhost", "root", "", "online_vote");

	//require '../inc/conn.php';
	if (isset($_POST['addCand'])) {
		
		//Read data
		$fName = $_POST['firstName'];
		$lName = $_POST['lastName'];
		$Position = $_POST['position'];
		$Party = $_POST['party'];
		$description = $_POST['desc'];
		$Profile = $_FILES['profile']['name'];

		$folder = "../assets/images/profiles/".basename($_FILES['profile']['name']);

		

		$query = " INSERT INTO candidates(`fname`,`lname`,`position`,`description`,`image`,`party`,`date`) VALUES('$fName', '$lName', '$Position', '$description','$Profile' , '$Party', NOW()) ";
		//Validate image

		if (preg_match("!image!", $_FILES['profile']['type'])) {
			$result = mysqli_query($db, $query);
			if ($result) {
				
				if (move_uploaded_file($_FILES['profile']['tmp_name'], $folder)) {
					$message = "Candidate added successfuly!";
				} else{
					$message = "Problem while uploading a profile!";
				}

			} else{
				$message = "Problem while inserting data!";
			}
		} else{
			echo '
				<script>
					alert("The chosen file is not an image!");
				</script>
			';
		}


	}

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
				<li><a href="logout.php"><span class="icon_lock"></span> Logout</a></li>
				<li><a href="people.php"><span class="icon_group"></span> People</a></li>
				<li class="current"><a href="#" class="current"><span class="icon_datareport_alt"></span> Candidates</a></li>
				<li><a href="home.php"><span class="icon_house_alt"></span> Home</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">

		<button class="plus-sign" id="add-person">+</button>

		<?php

			//Viewing candidates
			$query = " SELECT * FROM candidates ";
			$result = mysqli_query($db, $query);
			$count = mysqli_num_rows($result);
			if ($count > 0) {

		?>
		<br />
		<p class="candidate-p">
			<?php echo $count; ?> Candidates
		</p>
		<br />
		<br />

			<?php

				}

				//Counting one's votes
				$totalPeople = mysqli_num_rows(mysqli_query($db, " SELECT * FROM people "));
				$percentCount = $totalPeople;

				while ($row = mysqli_fetch_array($result)) {
					$queryB = " SELECT * FROM vote WHERE c_id = $row[c_id] ";
					$resultB = mysqli_query($db, $queryB);
					$countB = mysqli_num_rows($resultB);

					if ($countB <= 0) {
						$percent = 0;
					} else{
						$percent = $countB * 100 / $percentCount;
					}
			 ?>

			 <div class="candidate-disp">
				<div class="candidate-img">
					<img src="../assets/images/profiles/<?php echo $row['image'] ?>">
				</div>
				<div class="candidate-desc">
					<span class="candidate-name">
						<?php echo $row['fname']." ". $row['lname'] ; ?>
					</span>
					<span class="candidate-party">
						Party: <?php echo $row['party']; ?>
					</span>
					<span class="candidate-votes">
						Votes: <?php echo round($percent, 2); ?>%
					</span>
				</div>

				<div class="candidate-manage">
					<a class="deleteBtn" href="delete.php?id=<?php echo $row['c_id']; ?>"><span class="icon_trash_alt"></span> Delete</a>
					<a class="updateBtn" href="update.php?id=<?php echo $row['c_id']; ?>"><span class="icon_pencil-edit"></span> Update</a>
				</div>
			</div>

			<?php 
				}
			?>

	</div>


	<!-- Vote section -->
	<section class="vote-wrapper">
		<section class="vote newPerson">
			<p>
				Add new candidate
				<span class="close" id="close">X</span>
			</p>

			<form method="post" enctype="multipart/form-data" class="newData">

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