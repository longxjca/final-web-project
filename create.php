<?php

/**
 * @Author: longxun jin
 * @Date:   2019-11-3  16:33:44
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:28
 * @Purpose: 
 */
  // require 'authentication.php';
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
            <h1><a href="index.php">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - New Post</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" class='active'>New Post</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_post.php" enctype="multipart/form-data" method="post">
    <fieldset>
      <legend>New Menu Post</legend>
      <p>
        <label for="title">Title</label>
        <input name="title" id="title" />
      </p>
      <p>
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <input type="submit" name="submit" value="Upload Image">
      </p>
      <p>
        <label for="content">Content</label>
        <textarea name="content" id="content"></textarea>
      </p>
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
