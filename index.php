<?php require "session.php" ?>
<?php require "add-task.php" ?>
<?php 
  if (isset($_GET['del_task'])) {
    $id = $_GET['del_task'];

    mysqli_query($db, "DELETE FROM tasks WHERE task_id=".$id); 
    header('location: index.php');
  }

  if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM tasks WHERE task_id=".$id);

    if ($record) {
      $result = mysqli_fetch_array($record);
      $task = $result['task'];
    }
  }

  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];

    mysqli_query($db, "UPDATE tasks SET task='$task' WHERE task_id='$id'");
    header('location: index.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>
  <nav>
    <div class="container">
      <div class="row">
        <div class="login-section">
          <p><?php if ($user_check) { echo "<a href='logout.php'>Log out</a>"; } else { echo "<a href='login.php'>Log in</a>"; } ?></p>
          <p><a href="register.php">Register</a></p>
        </div>
      </div>
    </div>
</nav>

  <main>
    <div class="container">
      <div class="row">
        <div class="to-do-list-container">
          <h1>To Do List - <?php echo $user_id; ?></h1>
          <?php if (isset($errors)) { ?>
            <p><?php echo $errors; ?></p>
          <?php } ?>
          <div class="tasks">
          <?php 
            $tasks = mysqli_query($db, "SELECT * FROM tasks WHERE member_id = '$user_id'");
            while ($row = mysqli_fetch_array($tasks)) { ?>
            <p class="task">
              <?php echo $row['task']; ?>
              <span class="delete">
                <a class="btn btn-primary" href="index.php?edit=<?php echo $row['task_id'] ?>">Edit</a>
                <a href="index.php?del_task=<?php echo $row['task_id'] ?>">x</a>
              </span>
            </p>
            <?php } ?>
            <form class="add-task" method="post" action="">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php if (isset($_GET['edit'])) { ?>
              <input type="text" name="task" id="task" value="<?php echo $task ?>">
            <?php } else { ?>
              <input type="text" name="task" id="task" placeholder="Add a task...">
            <?php } ?>
            <?php if (isset($_GET['edit'])) { ?>
              <button class="btn btn-primary" type="submit" name="update" id="update">Update</button>
            <?php } else { ?>
              <button class="btn btn-primary" type="submit" name="submit" id="submit">Add</button>
            <?php } ?>
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