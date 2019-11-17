<?php

/**
 * @Author: longxun jin
 * @Date:   2019-11-3  16:33:44
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:28
 * @Purpose: 
 */
  // require 'authentication.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL- New Post</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php?sort=home">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - New Post</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="manager_users.php" >User Lists</a></li>
    <li><a href="createuser.php" class='active'>Create New User</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_user.php" enctype="multipart/form-data" method="post">
    <fieldset>
      <legend>New User</legend>
            <p>user name:<input type="text" name="username"></p>
            <p>password: <input type="password" name="password"></p>
            <p>re-enter password: <input type="password" name="repeatpassword"></p>
            <P>
                user type:
                <select name="usertype">
                  <option value="admin">admin</option> 
                  <option value="user">user</option> 
                </select>
            </P>
           
      <p>
        <input type="submit" name="command" value="Create" />
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