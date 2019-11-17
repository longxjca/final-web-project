<?php

/**
 * @Author: Longxun Jin
 * @Date:   2019-11-3  16:55:34
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:50
 * @Purpose: 
 */
include 'connect.php';
// require 'authentication.php';

$is_Create=false;
$is_Update=false;
$is_Delete=false;

if ($_POST['command']==='Update') {

  $is_Update=true;
}
if ($_POST['command']==='Delete') {
  $is_Delete=true;

}
if ($_POST['command']==='Create') {
  $is_Create=true;
}

//creating block 
    $error_message="";
    $error_flag=false;

    $username=$_POST['username'];//get input user name from POST 
    $password=$_POST['password'];//get password from POST
    $repeatpassword=$_POST['repeatpassword'];
    $usertype=$_POST['usertype'];

if ($is_Create) {


  // Sanitize user input 
  if ($username&&$password&&$repeatpassword&&FILTER_INPUT(INPUT_POST,'username',FILTER_VALIDATE_EMAIL)) {
    # code...
      $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $repeatpassword = filter_input(INPUT_POST, 'repeatpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);


      if ($password==$repeatpassword) {
        $password=password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (password, username, usertype, userid) values (:password, :username, :usertype, :userid)";
        $statement = $db->prepare($query);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':usertype', $usertype);        
        $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

      // Execute the SELECT
        $statement->execute();
        $_SESSION['username']=$username;
        $_SESSION['usertype']=$usertype;
        $_SESSION['userid']=$userid;
        header('Location:manager_users.php');
        exit;
        # code...
      }
      else{
        $error_flag=true;
        $error_message="Warning!!!!!!!!!!!!!!the entered passwords do not match!!!please return to try again.";

      }




  }

  

    


  //validate the input

}
if ($is_Update) {


  if ($username&&$password&&$repeatpassword&&FILTER_INPUT(INPUT_POST,'username',FILTER_VALIDATE_EMAIL)) {



      $username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $repeatpassword = filter_input(INPUT_POST, 'repeatpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
    # code...
      if ($password==$repeatpassword) {
        # code...
            $password=password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE user SET username = :username, password = :password, usertype= :usertype WHERE userid = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);        
            $statement->bindValue(':password', $password);
            $statement->bindValue(':usertype',$usertype);
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);

                  // Execute the INSERT.
            $statement->execute();
            $_SESSION['username']=$username;
            $_SESSION['usertype']=$usertype;
            $_SESSION['userid']=$userid;
            header('Location:manager_users.php');
            exit;


      }
            else{
        $error_flag=true;
        $error_message="Warning!!!!!!!!!!!!!!the entered passwords do not match!!!please return to try again.";

      }

  }
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
         // Build the parameterized SQL query and bind the sanitized values to the parameter 
    
}
if ($is_Delete) {
  $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM user WHERE userid = :userid";
    $statement = $db->prepare($query);
    $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
    $statement->execute();
  header('Location:manager_users.php');
  exit;
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>  Exchange District Cookery school</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php?sort=home"></a></h1>
        </div> <!-- END div id="header" -->
<?php if ($error_flag) : ?>
<h1>An error occured while processing your post.</h1>
  <p>
    <?=$error_message?>  </p>
<a href="manager_users.php">Return Manage users</a>
<?php endif?>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
