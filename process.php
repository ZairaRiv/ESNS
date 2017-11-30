<?php incude('server.php')

	// get the value that pass from login.php files
	$username = $_POST['user'];
	$password = $_POST['pass'];


	// to prevent mysql injection
	$username = stripcslashes($username);
	$password = stripcslashes($password);
	$username = mysqli_real_escape_string($_POST['user']);
	$password = mysqli_real_escape_string($_POST['pass']);

	// connect to server and select the database
	mysqli_connect("localhost", "root", "");
	mysqli_select_db("login");

	//Query the database for user

	$result = mysqul_query(" select * from user where username = '$username' and password ='$password'") 
					or die("unable to query database".mysql_error());

	$row = mysql_fetch_array($result);
	if($row['username'] == 	$username && $row['password'] == $password){
		echo "Login success !!! Welcome ".$row['username'];
		}else{
			echo "Failed to Login!";
		}		
 ?>