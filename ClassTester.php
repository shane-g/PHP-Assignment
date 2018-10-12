<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start(); //join/start a session between thhebrowser client and Apache web server


//include class libraries
include_once 'classlib/Session.php';
include_once 'classlib/SessionTest.php';


//===============SESSION CLASS TESTER===================
//session_destroy();
$session=new Session();
$sessionTest=new SessionTest($session);
echo '<br>';
print_r($_SESSION);
echo '<hr>';
echo '<br>$session object setLoggedIn :     '.$session->setLoggedin(FALSE);
echo '<br>';
print_r($_SESSION);
echo '<hr>';
echo '<br>$sessionTest object set LoggedIn : '.$sessionTest->setSession(FALSE);
echo '<br>';
print_r($_SESSION);
//session_destroy();
echo '<hr>';
if ($_SESSION['loggedin']){
    echo '$_session loggedin TRUE<br>';
}
else
{
    echo '$_session logged FALSE<br>';
}

if ($session->getLoggedin()){
    echo '$session loggedin<br>';
}
else
{
    echo '$session logged off<br>';
}

if ($sessionTest->getSession()){
    echo '$sessionTest TRUE<br>';
}
else
{
    echo '$sessionTest FALSE<br>';
}

print_r($_SESSION);

//===============SESSION CLASS TESTER===================
