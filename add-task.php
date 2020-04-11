<?php
  // Error and Database variables
  $errors = "";
  
  $db = mysqli_connect("localhost", "root", "", "todo") or die ("Couldn't connect to MySQL server.<br>");

  if(isset($_POST['submit'])) {
      if (empty($_POST['task'])) {
        $errors = "You must fill in the task.";
      }
      else {
        $task = $_POST['task'];
        $query = "INSERT INTO tasks (task, member_id) VALUES ('$task', '$user_id')";
        mysqli_query($db, $query);
        header('location: index.php');
      }
  }
?>