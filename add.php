<?php
	
	include('config/db_connect.php');

	$email = $title = $ingredients = '';
	$errors = array('email'=>'', 'title'=>'', 'ingredients'=>'');

	// Start $_POST[]
	if (isset($_POST['submit'])) {
		
		if (empty($_POST['email'])) {
			$errors['email'] = "An Email is required. <br />";
		}
		else {
			$email = $_POST['email'];
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "Email must be valid!";
			}
		}

		if (empty($_POST['title'])) {
			$errors['title'] = "A title is required. <br />";
		}
		else {
			$title = $_POST['title'];
			if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
				$errors['title'] = "Title must be letters and spaces only. <br>";
			}
		}

		if (empty($_POST['ingredients'])) {
			$errors['ingredients'] = "At least one ingredient is required. <br />";
		}
		else {
			$ingredients = $_POST['ingredients'];
			if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
				$errors['ingredients'] = "Ingredients must be a comma seperated list. <br>";
			}
		}

		if (!array_filter($errors)) {

			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

			$sql = "INSERT INTO pizzas(email, title, ingredients) VALUES('$email', '$title', '$ingredients')";

			if (mysqli_query($conn, $sql)) {
				header('Location: index.php');
			}
			else {
				echo 'query error: ' . mysqli_error($conn);
			}
		}
	}
	// End $_POST[]




	

 ?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<label>Your Email:</label>
			<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
			<div class="red-text"><?php echo $errors['email']; ?></div>
			<label>Pizza Title:</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>
			<label>Ingredients (Comma Seperated):</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>
			<div class="center">
				<input type="submit" name="submit" class="btn brand z-depth-0" value="submit">
			</div>
		</form>
	</section>

	<?php include('templates/footer.php'); ?>

</html>