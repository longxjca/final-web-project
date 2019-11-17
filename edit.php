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

$postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);
$query = "SELECT * FROM post WHERE postid = :postid";   
$statement = $db->prepare($query);
$statement->bindValue(':postid', $postid , PDO::PARAM_INT);
$statement->execute(); 
$menu= $statement->fetch();


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
            <h1><a href="index.php">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - Edit Post</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php?sort=home" >Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_post.php" enctype="multipart/form-data" method="post">
    <fieldset>
      <legend>Edit Menu Post</legend>
      <p>
        <label for="title">Dish Name</label>
        <input name="title" id="title" value="<?=$menu['title']?>" />
      </p>
      <p>
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <input type="submit" name="submit" value="Upload Image">
      </p>
      <p>
        <label for="content">Menu Instruction</label>
        <textarea name="content" id="content"><?=$menu['content']?></textarea>
      </p>
      <p>
        <input type="hidden" name="postid" value="<?= $postid ?>" />
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