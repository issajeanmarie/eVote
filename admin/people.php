<?php

	error_reporting(0);
	session_start();

	if (!isset($_SESSION['online_vote'])) {
	  	session_destroy();
		header("location: index.php");
	}

	$db = new mysqli("localhost", "root", "", "online_vote");

	//require '../inc/conn.php';
	if (isset($_POST['add'])) {
		
		//Read data
		$fName = $_POST['firstName'];
		$lName = $_POST['lastName'];
		$Cell = $_POST['cell'];
		$Village = $_POST['village'];
		$ID = $_POST['idNo'];
		$age = $_POST['age'];
		

		if (preg_match("/^[0-9]{16}$/", $ID)) {
			//Check if user exists
			$check = mysqli_num_rows(mysqli_query($db, "SELECT * FROM people WHERE identity = $ID"));
			if ($check <= 0) {
				$query = " INSERT INTO people(`fname`,`lname`,`cell`,`village`,`age`,`identity`,`date`) VALUES('$fName', '$lName', '$Cell', '$Village','$age' , '$ID', NOW()) ";
				$result = mysqli_query($db, $query);
				if ($result) {
					echo '
						<script>
							alert("Person added successfuly!");
						</script>
					';
				} else{
					echo '
						<script>
							alert("Problem while inserting!");
						</script>
					';
				}
			} else{
				echo '
					<script>
						alert("User already registered!");
					</script>
				';
			}
		} else{
			echo '
				<script>
					alert("Invalid ID");
				</script>
			';
		}


	}

	//Count all people
	$totalPeople = mysqli_num_rows(mysqli_query($db, " SELECT * FROM people "))

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
				<li><a href="#" class="current"><span class="icon_group"></span> People</a></li>
				<li><a href="candidates.php"><span class="icon_datareport_alt"></span> Candidates</a></li>
				<li><a href="home.php"><span class="icon_house_alt"></span> Home</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">

		<button class="plus-sign" id="add-person">
			+
		</button>

		<?php

			//Viewing candidates
			$query = " SELECT * FROM people ";
			$result = mysqli_query($db, $query);
			$count = mysqli_num_rows($result);
			if ($count > 0) {

		?>
		<br />

		<p class="candidate-p">
			<?php echo $count; ?> People
		</p>
		<br />

		<div class="person-disp"></div>
		
		<table class="table-people">
			
			<tr>
				<th>No</th>
				<th>Names</th>
				<th>ID</th>
				<th>Cell</th>
				<th>Village</th>
				<th>Age</th>
				<th>Manage</th>
			</tr>

		<?php 
			
			}

			$no = 0;

			while ($row = mysqli_fetch_array($result)) {
				$no++;

		?>

			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $row['fname']. " ". $row['lname']; ?>
				<td><?php echo $row['identity']; ?></td>
				<td><?php echo $row['cell']; ?></td>
				<td><?php echo $row['village']; ?></td>
				<td><?php echo $row['age']; ?></td>
				<td>
					<a class="deleteBtn" style="float: none; margin-left: 3px; padding: 4px;" href="delete_person.php?id=<?php echo $row[p_id] ?>"><span class="icon_trash_alt"></span>
					</a>
					<a class="updateBtn" style="float: none; margin-left: 10px; padding: 4px;" href="update_person.php?id=<?php echo $row[p_id] ?>"><span class="icon_pencil-edit"></span></a>
				</td>
			</tr>

		<?php }?>

		</table>

	</div>

	<!-- Vote section -->
	<section class="vote-wrapper">
		<section class="vote newPerson">
			<p>
				Add new person
				<span class="close" id="close">X</span>
			</p>

			<form method="post" action="">

				<label>First name</label>
				<br />
				<input type="text" name="firstName" placeholder="First name..." required="required">
				<br />

				<label>Last name</label>
				<br />
				<input type="text" name="lastName" placeholder="Last name..." required="required">
				<br />

				<label>Cell</label>
				<br />
				<input type="text" name="cell" placeholder="Cell..." required="required">
				<br />

				<label>Village</label>
				<br />
				<input type="text" name="village" placeholder="Village..." required="required">
				<br />

				<label>ID no</label>
				<br />
				<input type="number" name="idNo" placeholder="ID no..." required="required">
				<br />

				<label>Date of birth</label>
				<br />
				<input type="date" name="age" placeholder="Date of birth..." required="required">
				<br />
				<br />

				<input type="submit" name="add" value="Add person">
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
