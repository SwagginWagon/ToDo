<?php
   // connect to the database
   $db = mysqli_connect('localhost', 'root', '', 'todo');
   
   session_start();
   
   $user_check = $_SESSION['login_user'];
   $user_id = $_SESSION['member_id'];
   
   $ses_sql = mysqli_query($db,"SELECT email FROM users WHERE email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['email'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>