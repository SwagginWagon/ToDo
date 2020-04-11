<?php
session_start();

// Initializing variables
$email = "";
$password = "";
$error = "";

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'todo');

// Login User
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $password = md5($password);

    $sql = "SELECT member_id FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);

    // If matched, table row == 1
    if ($count == 1) {
        $_SESSION["email"];
        $_SESSION["member_id"] = $row['member_id'];
        $_SESSION['login_user'] = $email;

        header("location: index.php");
    }
    else {
        $error = "Your email or password is incorrect.";
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
  <title>Log In</title>
</head>
<body>
  <main>
    <div class="container">
      <div class="row">
        <div class="to-do-list-container">
          <h1>Log In</h1>
          <div class="tasks">
            <form class="login-form" method="post" action="">
              <label for="email">Email</label>
              <input type="text" name="email" id="email">
              <label for="password">Password</label>
              <input type="password" name="password" id="password">
              <button class="btn btn-primary" type="submit" name="login" id="login">Login</button>
              <div><?php if ($error) { echo $error; } ?></div>
              <p><a href="register.php">Don't have an account? Create one</a></p>
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