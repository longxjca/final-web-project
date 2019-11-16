<?php

    include('connect.php');//connect to database
    session_start();

    $username=$_POST['username'];//get input user name from POST 
    $password=$_POST['password'];//get password from POST
    $repeatpassword=$_POST['repeatpassword'];
    $usertype=$_POST['usertype'];
    $error_message="";
    $error_flag=false;

    //validat the input format for email address using FILTER_INPUT

    if ($username&&$password&&$repeatpassword&&FILTER_INPUT(INPUT_POST,'username',FILTER_VALIDATE_EMAIL)) {

    	//santinize the input user name and password

    	$username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$repeatpassword = filter_input(INPUT_POST, 'repeatpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

        //hash the password using password_hash()


    	//
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
    		header('Location:index.php');
    		exit;
    		# code...
    	}
    	else{
    		$error_flag=true;
    		$error_message="Warning!!!!!!!!!!!!!!the entered passwords do not match!!!please return to try again.";

    	}



    }


?>

<!DOCTYPE html>
<html>
<head>
	<title>sign up page</title>
</head>
<body>
	<p>
		<?php if($error_flag):?>
			<p><?=$error_message?></p>
		<?php endif?>
	</p>
	<p><a href="signup.html">return to sign up page</a></p>

</body>
</html>