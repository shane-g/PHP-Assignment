<?php

session_start(); //join/start a session between thhebrowser client and Apache web server


//include application configuration settings
include_once 'config/config.php';
include_once 'config/connection.php';

//include class libraries
include_once 'classlib/Model.php';
include_once 'classlib/Controller.php';
include_once 'classlib/Session.php';
include_once 'classlib/SessionTest.php';

//include MVC classes
include_once 'controllers/MainController.php';
include_once 'models/Home.php';
include_once 'models/admin.php';
include_once 'models/registeredUser.php';
include_once 'models/Planes.php';
include_once 'models/Message.php';


//connect to the MySQL Server (with error reporting supression '@')
@$db=new mysqli($DBServer,$DBUser,$DBPass,$DBName);

if($db->connect_errno){  //check if there is an error in the connection
    $msg='Error making connection to MySQL Server using MySQLi- check your server is running and you have the correct host IP address.<br>MySQLi Error message: '.$conn->connect_error.'<br>'; 
    exit($msg);  
}
//session class
$session=new Session();
//start the app
$mainController=new MainController($db,$session);
//tidy up  - end of database operations
$db->close();