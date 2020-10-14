<?php

	session_start();

	$db = new mysqli("localhost", "root", "", "online_vote");
	$query = " SELECT * FROM candidates ";
	$result = mysqli_query($db, $query);
	$count = mysqli_num_rows($result);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$voter = $_SESSION['voterId'];
		//Get the voters' database id
		$query2 = " SELECT * FROM people WHERE identity = $voter ";
		$result2 = mysqli_query($db, $query2);

		while ($row = mysqli_fetch_array($result2)) {
			$voterId = $row['p_id'];
			$age = $row['age'];
		}

		//Vote now if never votted!
		$query3 = " SELECT * FROM vote WHERE p_id = $voterId ";
		$result3 = mysqli_query($db, $query3);
		$count2 = mysqli_num_rows($result3);

		//Check the age
		if ((date("Y") - $age) >= 18 ) {
			
			if ($count2 <= 0) {

				//Then vote
				$candidateId = $_GET['id'];
				$query4 = " INSERT INTO vote(`c_id`, `p_id`) VALUES ('$candidateId', '$voterId') ";
				$result4 = mysqli_query($db, $query4);
				if ($result4) {
					echo '
						<script>
							alert("Successfuly voted!");
						</script>
					';
				} else{
					echo '
						<script>
							alert("Failed to vote!");
						</script>
					';
				}

		} else{
			echo '
				<script>
					alert("You have already voted! You can not vote twice!");
				</script>
			';
			
		}

		} else{
			echo '
				<script>
					alert("You are too young!");
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
				<li><a href="../">Leave</a></li>
				<li><a href="#" class="current">Candidates</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">

		<!--Candidates section -->
		<section class="candidates" id="candidates">
			<p class="candidate-p">
				<?php echo $count; ?> Candidates
			</p>
			<br />
				<?php

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

				<div class="single-candidate">
					<div class="pro-cont">
						<img src="../assets/images/profiles/<?php echo $row['image'] ?>">
					</div>

					<div class="desc">
						<div class="candidate-name">
							<?php echo $row['fname']. " ". $row['lname']; ?></b>
						</div>

						<div class="candidate-desc">
							<div class="candidate-party">
								<?php echo $row['party']; ?>
							</div>
							<div class="candidate-votes" style="background: rgb(220,220,220); color: #666;">
									Votes: 
										<?php echo round($percent, 2); ?>%
									
							</div>
						</div>

						<form action="candidates.php?id=<?php echo $row['c_id'] ?>" method="post">
							<button type="submit" class="vote-btn" name="vote">VOTE</button>
						</form>
					</div>

				</div>

				<?php } ?>
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