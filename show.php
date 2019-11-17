<?php
/**
 * @Author: longxun
 * @Date:   2019-11-3  16:58:31
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:55
 * @Purpose: 
 */
include 'connect.php';
// require 'authentication.php';
session_start();

$postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);

$_SESSION['postid']=$postid;

$query = "SELECT * FROM post WHERE postid = :postid";   
$statement = $db->prepare($query);
$statement->bindValue(':postid', $postid , PDO::PARAM_INT);
$statement->execute(); 
$menu= $statement->fetch();

$comment_query="SELECT * FROM comment WHERE postid = :postid";
$comment_statement = $db->prepare($comment_query);
$comment_statement->bindValue(':postid', $postid , PDO::PARAM_INT);
$comment_statement->execute(); 
$comment_menus= $comment_statement->fetch();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - <?=$menu['title']?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php?sort=home" >Home</a></li>
    <?php if(isset($_SESSION['username'])):?>
        <li><a href="create.php" >New Post</a></li>
    <?php endif ?>
</ul> <!-- END div id="menu" -->
  <div id="all_blogs">
    <div class="blog_post">
      <h2><?=$menu['title']?><a href="comment.html">Comment</a></h2>
      <p>
        <small>
          <?= date ('F d, Y h:i ', strtotime($menu['postdate'])) ?>
          <?php if(isset($_SESSION['username'])):?>          
              <a href="edit.php?postid=<?=$menu['postid']?>">edit</a>
          <?php endif ?>
        </small>
      </p>
      <p>
        
      </p>      
      <div class='blog_content'>
        <img src="uploads\<?=$menu['picturename']?>" alt="picture" >
        <?=$menu['content']?> 
        <ul><div>Rigistered User Comments</div>
          <?php foreach($comment_menus as $comment_menu):?>
            <?= $comment_menu['content'] ?>
            <?php if($comment_menu['userid']===$_SESSION['userid']):?>

        <!-- <input type="hidden" name="postid" value="<?= $postid ?>" /> -->
        <!-- <input type="submit" name="command" value="Update" /> -->
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
            <?php endif?>
      
          <?php endforeach?>

        </ul>     
      </div>
    </div>
  </div>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>