<?php

include 'connect.php';
session_start();

$query = "SELECT * FROM user ORDER BY userid DESC LIMIT 100"; 
$statement = $db->prepare($query);
$statement->execute();
$userlists = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
	<title>manager users page</title>
	<meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
	<div id="wrapper">
        <div id="header">
            <h1><a href="index.php">EXCHANGE DISTRICT COMMUNITY COOKERY SCHOOL - Index</a></h1>
        </div> <!-- END div id="header" -->
            <p>SUCCESSFULLY LOGIN !!WELCOME BACK!! <?=$_SESSION['usertype']?> <?= $_SESSION['username']?>!!!!</p>
            <a href="logout.php" >LOG OUT</a> 
				<ul id="menu">
   					<li><a href="manager_users.php" class='active'>User Lists</a></li>			
        			<li><a href="createuser.php" >Create New User</a></li>   						
				</ul> <!-- END div id="menu" -->
<div id="all_blogs">

  <?php foreach($userlists as $userlist): ?>
    <div class="blog_post">
      <h2><a href="edituser.php?userid=<?= $userlist['userid'] ?>"><?= $userlist['username'] ?>:  <?= $userlist['password'] ?>  (<?= $userlist['usertype'] ?>)</a></h2>
    </div>
  <?php endforeach?>


  </div>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
</div>

</body>
</html>