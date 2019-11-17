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
session_start();

$is_Create=false;
// $is_Update=false;
$is_Delete=false;

// if ($_POST['command']==='Update') {

// 	$is_Update=true;
// }
if ($_POST['command']==='Delete') {
	$is_Delete=true;

}
if ($_POST['command']==='Create') {
	$is_Create=true;
}

//creating block 
    $error_message="";
    $error_flag=false;

    $content=$_POST['content'];

if ($is_Create) {

	if ($content) {
		# code...
		$content=filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$userid=$_SESSION['userid'];
    	$username=$_SESSION['username'];
    	$postid=$_SESSION['postid'];


    	$query="INSERT INTO comment (commentid, content, userid, postid) values (:commentid, :content, :userid, :postid)";
    	$statement = $db->prepare($query);
        $statement->bindValue(':commentid', $commentid, PDO::PARAM_INT);
        $statement->bindValue(':content', $content);
        $statement->bindValue(':userid', $userid, PDO::PARAM_INT);        
        $statement->bindValue(':postid', $postid, PDO::PARAM_INT);

      // Execute the SELECT
        $statement->execute();
        header('Location:show.php');
        exit;
	}
	else{
		$error_flag=true;
        $error_message="Warning!!!!!!!!!!!!!!the comment is empty.";
	}
	# code...
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
<a href="comment.html">Return to create comment</a>
<?php endif?>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>