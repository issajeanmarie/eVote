<?php

	error_reporting(0);
	session_start();

	//Logging the admin in
	$uName = "issa";
	$password = "xyz";

	$message = '';
	$passError = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		//Get data
		$name = $_POST['uName'];
		$pass = $_POST['password'];

		$_SESSION['online_vote'] = $name;
		
		if ($name == $uName) {
			//Then check password
			if ($pass == $password) {
				header("location: home.php?logged");
			} else{
				$passError = "Incorrect password!";
			}
		} else{
			$message = "User not exists!";
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
		<!--
		<nav>
			<ul>
				<li id="vote" class="current"><a href="#">Vote</a></li>
				<li><a href="../#candidates">Candidates</a></li>
				<li><a href="#">Home</a></li>
			</ul>
		</nav>
		-->
	</header>

	<div class="container">

		<!--Login section -->
		<form action="" method="post" class="loginForm">
			<p>Login</p>
			<label>User name</label>
			<br />
			<input type="text" name="uName" placeholder="User name..." required="required" value="<?php echo $name ?>">
			<br />
			<?php echo "<lable style='color: maroon; font-weight: bold; font-style: italic;'>". $message. "</label>"; ?>
			<br />
			<label style="font-style: normal;">Password</label>
			<br />
			<input type="password" name="password" placeholder="User password..." required="required">
			<br />
			<?php echo "<label style='color: maroon; font-weight: bold; font-style: italic;'>". $passError. "</label>"; ?>
			<br /><br />

			<input type="submit" name="loginBtn" class="loginBtn" value="Login">
		</form>

		
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