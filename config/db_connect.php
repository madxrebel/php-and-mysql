<?php 

	// connect to database
	$conn = mysqli_connect('localhost', 'Jano', 'maniwatan', 'ninja_pizza'); 

	// check the connection
	if (!$conn) {
		echo "Connection error: " . mysqli_connect_error();
	}

 ?>