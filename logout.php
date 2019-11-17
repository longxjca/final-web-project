<?php

include('connect.php');//connect database
session_start();
// session_destroy();
session_destroy();
header('Location:index.php?sort=home');
exit;





?>