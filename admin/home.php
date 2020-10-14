<?php
	
	session_start();

	if (!isset($_SESSION['online_vote'])) {
	   session_destroy();
		header("location: index.php");
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
				<li><a href="logout.php"><span class="icon_lock_alt"></span> Logout</a></li>
				<li><a href="people.php"><span class="icon_group"></span> People</a></li>
				<li><a href="candidates.php"><span class="icon_datareport_alt"></span> Candidates</a></li>
				<li><a href="#" class="current"><span class="icon_house_alt"></span> Home</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">

		<!--Candidates section -->
		<section class="candidates" id="candidates">

			<?php

				//Getting the candidates
				$db = new mysqli("localhost", "root", "", "online_vote");

				$query = " SELECT * FROM candidates ";
				$result = mysqli_query($db, $query);
			?>

			<?php

				//Viewing candidates
				$query = " SELECT * FROM candidates ";
				$result = mysqli_query($db, $query);
				$count = mysqli_num_rows($result);
				if ($count > 0) {

			?>

			<fieldset>
				<legend>
					<?php echo $count; ?> Candidates
					<a href="truncate.php"><button class="end-com">End</button></a>
				</legend>

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

					 <div class="candidate-disp candidate-home">
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

						<div class="candidate-manage"></div>
					</div>

					<?php 
						}
					?>

			</fieldset>
		</section>
		
	</div>

	<!-- Vote section -->
	<section class="vote-wrapper">
		<section class="vote">
			<p>
				Your vote counts
				<span class="close" id="close">X</span>
			</p>

			<form accept="" method="">
				<label>ID Number</label>
				<br />
				<input type="number" name="idNumber" class="idNumber">
				<input type="submit" name="check" value="Check">
			</form>
		</section>
	</section>

</body>
<script type="text/javascript">
	let wrapper = document.querySelector('.vote-wrapper');
	let opener = document.querySelector('#vote');
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