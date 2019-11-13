<?php

/**
 * @Author: longxun
 * @Date:   2019-11-3  12:11:59
 * @Last Modified by:   longx
 * @Last Modified time: 2019-11-3  12:19:23
 */
     

//create a new PDO object
    define('DB_DSN','mysql:host=localhost;dbname=serverside');
    define('DB_USER','serveruser');
    define('DB_PASS','gorgonzola7!');     
    
    try {
        $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage();
        die(); 
    } 

?>