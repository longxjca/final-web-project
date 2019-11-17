<?php



    include('connect.php');//connect database

    session_start();

    $error_message="";
    $error_flag=false;

    $username = $_POST['username'];//get user name input from Post variable
    $password = $_POST['password'];//get password input from post variable
    //Validate email input format first
    if ($username&&$password&&FILTER_INPUT(INPUT_POST,'username',FILTER_VALIDATE_EMAIL)) {
    	//santinize the input user name and password

    	$username  = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$usertype = filter_input(INPUT_POST, 'usertype', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	$userid      = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

    	//query the username and password matching the database value
        
    	$query = "SELECT * FROM user WHERE username = :username";
    	$statement = $db->prepare($query);
    	$statement->bindValue(':username', $username);        
    	// $statement->bindValue(':password', $password);
    	// $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
    
    	 // Execute the SELECT

    	$statement->execute();

        //fetch the password from database based on the username
        $row=$statement->fetch();
    	
    	//count the number of matched records
    	$row_number=$statement->rowCount();

    	if ($row_number) {
            //using password_verify function to compare the fetched password to the user input passowrd

            if (password_verify($password, $row['password'])) {
                # code...
                $_SESSION['username']=$username;
                $_SESSION['usertype']=$usertype;
                $_SESSION['userid']=$row['userid'];
            
                header('Location:index.php?sort=home');
                exit;
            }


    	}else{
    		$error_flag=true;
    		$error_message= "Error!!!!!!!!!!!!Log in FAILD!!!!!Incorrect user name or password";
   

    	}




    
	}else{//if username or password is null
                $error= "Error!!!!!!!!!!!!Log in FAILD!!!!! Username or Password is not complete";
            



                // echo "
                //       <script>
                //             setTimeout(function(){window.location.href='index.php';},1000);
                //       </script>";

                       
    }


?>

<!DOCTYPE html>
<html>
<head>
	<title>login php page</title>
</head>
<body>
	<p><?php if($error_flag) :?></p>
		<p><?=$error_message?></p>
	<p><?php endif ?></p>
	<p><a href="login.html">return to login page</a></p>



</body>
</html>
