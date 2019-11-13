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
$error=false;


if ($is_Create) {


	// Sanitize user input 
	$title=filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$content=filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$postid= filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
    $userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

    // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
       $current_folder = dirname(__FILE__);
       
       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }
    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);



	//validate the input
	if ($title===""||$content===""||$upload_error_detected>0) {
		$error=true;
	}
	else {
        if ($image_upload_detected) { 
            $image_filename        = $_FILES['image']['name'];
            $temporary_image_path  = $_FILES['image']['tmp_name'];
            $new_image_path        = file_upload_path($image_filename);
            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                move_uploaded_file($temporary_image_path, $new_image_path);
            }
        }
        $picturename=$_FILES['image']['name'];
		//insert the input
		$query="INSERT INTO post (title, content, picturename) values (:title, :content, :picturename) ";
		$statement=$db->prepare($query);
		$statement->bindValue(':title',$title);
		$statement->bindValue(':content',$content);
        $statement->bindValue(':picturename',$picturename);
		$statement->execute();
		$insert_id=$db->lastInsertId();
		header('Location:index.php');
		exit;		
	}
}
if ($is_Update) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $postid      = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
    $userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

        // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
    // Default upload path is an 'uploads' sub-folder in the current folder.
    function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
       $current_folder = dirname(__FILE__);
       
       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       
       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }
    // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);


    if ($title===""||$content===""||$upload_error_detected>0) {
    	$error=true;
    }
    else{
        if ($image_upload_detected) { 
            $image_filename        = $_FILES['image']['name'];
            $temporary_image_path  = $_FILES['image']['tmp_name'];
            $new_image_path        = file_upload_path($image_filename);
            if (file_is_an_image($temporary_image_path, $new_image_path)) {
                move_uploaded_file($temporary_image_path, $new_image_path);
            }
        }
        $picturename=$_FILES['image']['name'];
    	// Build the parameterized SQL query and bind the sanitized values to the parameters
    	$query = "UPDATE post SET title = :title, content = :content, picturename= :picturename, userid=:userid WHERE postid = :postid";
    	$statement = $db->prepare($query);
    	$statement->bindValue(':title', $title);        
    	$statement->bindValue(':content', $content);
        $statement->bindValue(':picturename',$picturename);
    	$statement->bindValue(':postid', $postid, PDO::PARAM_INT);
        $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
    	 // Execute the INSERT.
    	$statement->execute();
    	header('Location:index.php');
    	exit;
    }
}
if ($is_Delete) {
	$postid = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM post WHERE postid = :postid";
    $statement = $db->prepare($query);
    $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
    $statement->execute();
	header('Location:index.php');
	exit;
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> LongxunBLOG</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php"></a></h1>
        </div> <!-- END div id="header" -->
<?php if ($error) : ?>
<h1>An error occured while processing your post.</h1>
  <p>
    Both the title and content must be at least one character.  </p>
<a href="index.php">Return Home</a>
<?php endif?>
        <div id="footer">
            Copywrong 2019 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
