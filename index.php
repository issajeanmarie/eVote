<?php

	session_start();

	error_reporting(0);

	$db = new mysqli("localhost", "root", "", "online_vote");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$idNumber = $_POST['idNumber'];

		//Validating input
		if (preg_match("/^[0-9]{16}$/", $idNumber)) {
			
			$query = " SELECT * FROM people WHERE identity = $idNumber ";
			$result = mysqli_query($db, $query);
			$count = mysqli_num_rows($result);

			if ($count <= 0) {
				echo '
					<script>
						alert("You do not belong in this sector!");
					</script>
				';
			} else{
				$_SESSION['voterId'] = $idNumber;
				header("location: pages/candidates.php");
			}

		} else{
			echo '
				<script>
					alert("Ivalid ID");
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
	<link rel="stylesheet" type="text/css" href="assets/style/css.css">
	<link rel="stylesheet" type="text/css" href="assets/icons/icons/style.css">
</head>
<body class="index">

	<header class="main-header">
		<div class="brand">
			<div class="brand-img">
				<img src="assets/images/Mobile voting.jpg">
			</div>
			<span class="brand-word">
				Rugero Sector eVote
			</span>
		</div>
		<nav>
			<ul>
				<li id="vote"><a href="#"><span class="icon_check_alt2"></span> Vote</a></li>
				<li><a href="#candidates"><span class="icon_group"></span> Candidates</a></li>
				<li class="current"><a href="#"><span class="icon_house_alt"></span> Home</a></li>
			</ul>
		</nav>
	</header>

	<div class="container">
		<section class="welcome">

			<h1 class="slog">
				Rugerero Sector Online Voting!
			</h1>

			<div class="welcomWord-1">
				Choose and <a href="#">vote</a> for your future.
				<br />
				The better leader you choose, the better you are going to be ruled!
				<br /> <br />
				<a href="#candidates">
					<button class="vote-btn no-hover">Choose carefully!</button>
				</a>
			</div>
			<div class="welcomWord-2">
				Requirements:
				<ul>
					<li>Being Rwandan</li>
					<li>Being above 18 years old</li>
					<li>Having ID Card</li>
					<li>Willing to bote</li>
				</ul>
			</div>

			<div class="welcomWord-3">
				Benefits:
				<ul class="req-list">
					<li>No transport required, just your phone, tablet, or computer</li>
					<li>It is faster</li>
					<li>Accurate</li>
					<li>Cheching the progress in election</li>
				</ul>
			</div>

			<div class="welcomWord-4">
				For whom:
				<ul class="req-list">
					<li>Everyone lives in Rugerero sector</li>
					<li>Anyone else followed the steps of registeration</li>
					<li>It is for Rwandans</li>
				</ul>
			</div>

			<div class="welcomWord-5">
				Rugerero Registration:
				<ul class="req-list">
					<li>Come to Rugerero sector</li>
					<li>Come with your ID card</li>
					<li>You will be registered to vote like all Rugeroro People</li>
					<li>Vote as you wish</li>
				</ul>
			</div>

			<div class="welcomWord-6">
				It is simple:
				<ul class="req-list">
					<li>Click one <b>Vote</b> button,</li>
					<li>Fill in your ID card number,</li>
					<li>Click <b>Check</b> button,</li>
					<li>Choose your preference candidate and click <b>Vote</b> button,</li>
					<li>Congratulation! You have voted!</li>
				</ul>
			</div>

		</section>

		<!--Candidates section -->
		<section class="candidates" id="candidates">
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
					<img src="assets/images/profiles/<?php echo $row['image'] ?>">
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
			</div>

			<?php 
				}
			?>
		</section>

		
	</div>

	<!-- Vote section -->
	<section class="vote-wrapper">
		<section class="vote">
			<p>
				Your vote counts
				<span class="close" id="close">X</span>
			</p>

			<form accept="" method="post">
				<label>ID Number</label>
				<br />
				<input type="number" name="idNumber" class="idNumber">
				<br /> <br />
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