<?php
session_start();

// initializing variables
$first_name = "";
$last_name = "";
$email = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'todo');

// REGISTER USER
if (isset($_POST['register'])) {
  // receive all input values from the form
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required."); }
  if (empty($password)) { array_push($errors, "Password is required."); }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['email'] == $email) {
      array_push($errors, "Email already exists.");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (first_name, last_name, email, password) 
  			  VALUES('$first_name', '$last_name', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>Register</title>
</head>
<body>
  <main>
    <div class="container">
      <div class="row">
        <div class="to-do-list-container">
          <h1>Register</h1>
          <div class="tasks">
            <form class="register-form" method="post" action="">
              <label for="first_name">First Name</label>
              <input type="text" name="first_name" id="first_name">
              <label for="last_name">Last Name</label>
              <input type="text" name="last_name" id="last_name">
              <label for="email">Email</label>
              <input type="email" name="email" id="email">
              <label for="password">Password</label>
              <input type="password" name="password" id="password">
              <button class="btn btn-primary" type="submit" name="register" id="register">Register</button>
              <div><p style="color: red;"><?php if ($errors) { echo $errors[0]; } ?></p></div>
              <div><a href="login.php">Have an account? Log in</a></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>