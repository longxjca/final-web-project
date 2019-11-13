<?php
/**
 * @Author: longxun
 * @Date:   2019-11-3  16:58:31
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:38
 * @Purpose: 
 */
// require 'authentication.php';

include 'connect.php';
session_start();
// require 'authentication.php';

$userid = filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM user WHERE userid = :userid";   
$statement = $db->prepare($query);
$statement->bindValue(':userid', $userid , PDO::PARAM_INT);
$statement->execute(); 
$slected_user= $statement->fetch();


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL- Edit Post </title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - Edit User-<?=$slected_user['username']?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="manager_users.php" >User Lists</a></li>
    <li><a href="createuser.php" >Create New User</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_user.php" enctype="multipart/form-data" method="post">
    <fieldset>
      <legend>Edit Menu Post</legend>
            <p>user name:<input type="text" name="username" value="<?=$slected_user['username']?>"></p>
            <p>password: <input type="password" name="password" value="<?=$slected_user['password']?>"></p>
            <p>re-enter password: <input type="password" name="repeatpassword" value="<?=$slected_user['password']?>"></p>
            <P>
                user type:
                <select name="usertype" >
                  <option value="admin">admin</option> 
                  <option value="user">user</option> 
                </select>
            </P>
           

      <p>
        <input type="hidden" name="userid" value="<?= $userid ?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
      </p>
    </fieldset>
  </form>
</div>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>