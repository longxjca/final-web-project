<?php

/**
 * @Author: longxun
 * @Date:   2019-11-3 16:58:31
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  01:01:43
 * @Purpose: web project
 */
include 'connect.php';
session_start();

if ($_GET['sort']=='home') {
  # code...
  $query = "SELECT * FROM post ORDER BY postid DESC LIMIT 10";
}

if ($_GET['sort']=='title') {
  # code...
  $query = "SELECT * FROM post ORDER BY title DESC LIMIT 10";
}
if ($_GET['sort']=='postdate') {
  # code...
  $query = "SELECT * FROM post ORDER BY postdate DESC LIMIT 10";
}
if ($_GET['sort']=='update_date') {
  # code...
   $query = "SELECT * FROM post ORDER BY update_date DESC LIMIT 10";
}
 
$statement = $db->prepare($query);
$statement->execute();
$menus = $statement->fetchAll();

//function to cut content to 200 if it is over 200
$context;
$length=200;
function truncate($context, $length){
  if (strlen($context)>$length) {
   $context=substr($context, 0, $length )."...";
  }
  return $context;
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL-Index</title>
    <link rel="stylesheet" href="style.css" type="text/css">

</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php?sort=home">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - Index</a></h1>
        </div> <!-- END div id="header" -->

        <?php if(isset($_SESSION['username'])) :?>
            <p>SUCCESSFULLY LOGIN !!WELCOME BACK!! <?=$_SESSION['usertype']?> <?= $_SESSION['username']?>!!!!</p>
            <a href="logout.php" >LOG OUT</a> 
            <?php if($_SESSION['usertype']=="admin") :?>
                  <P><a href="manager_users.php">MANAGE USERS</a></P>
            <?php endif ?>

        <?php else :?>
          <p><a href="login.html">LOG IN </a> </p>       
          <p> <a href="signup.html">SIGN UP</a> </p>

<!--             <form name="login" action="login.php" method="post">
                <p>user name<input type="text" name="username"></p>
                <p>password<input type="password" name="password"></p>
                <p><input type="submit" name="submit" value="log in"></p>
                <a href="signup.html" >SIGN UP</a>
            </form>
            <?php if(isset($_SESSION['error'])) :?>
              <p><?=$_SESSION['error']?></p>
            <?php endif?> -->
        <?php endif ?>  
<ul id="menu">
    <li><a href="index.php?sort=home" class='active'>Home</a></li>
    <?php if(isset($_SESSION['username'])):?>
        <li><a href="create.php" >New Post</a></li>
        <li><a href="index.php?sort=title" class='active'>Sort by Title</a></li>
        <li><a href="index.php?sort=postdate" class='active'>Sort by Post Date</a></li>
        <li><a href="index.php?sort=update_date" class='active'>Sort by Update Date</a></li>
    <?php endif ?>



</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <?php if(!$menus): ?>
    <p>no posts existing, create new posts</p>
  <?php endif?>
  <h3>We are sorting the menu lists by <?=$_GET['sort']?> Now</h3>
  <?php foreach($menus as $menu): ?>
    <div class="blog_post">
      <h2><a href="show.php?postid=<?= $menu['postid'] ?>"><?= $menu['title'] ?></a></h2>
       <p>Created Date:
        <small>
           <?= date ('F d, Y h:i ', strtotime($menu['postdate'])) ?>
          <!-- <a href="edit.php?postid=<?= $menu['postid'] ?>">edit</a> -->

        </small>
      </p>
      <p>
                  Updated Date:
        <small>
           <?= date ('F d, Y h:i ', strtotime($menu['update_date'])) ?>
          <!-- <a href="edit.php?postid=<?= $menu['postid'] ?>">edit</a> -->
        </small>
      </p> 
      <p>
        Posted By: <?=$menu['username']?>;
        <small></small>
      </p>

       
<!--       <div class="menu_picture">
        <img src="uploads\<?=$menu['picturename']?>" alt="picture" >
        
      </div> -->
<!--       <div class='blog_content'>
        <?php if (strlen($menu['content'])>200) :?>
          <?= truncate($menu['content'],$length) ?><a href="show.php?postid=<?= $menu['postid'] ?>">Ream More</a>
        <?php else:?>
        <?= $menu['content'] ?> 
        <?php endif?>            
      </div> -->
    </div>
  <?php endforeach?>  
  </div>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
</div> <!-- END div id="wrapper" -->
</body>
</html>
