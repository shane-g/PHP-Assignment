<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class Session {
   
    private $sessionID; //String : containing the PHPSESSID cookie value 
    private $loggedin; //Boolean : TRUE is logged in
    private $userAuthorisation; //Integer - 0=not authorised 1=administrator 2=lecturer 3=student
    private $userID; //String - logged on user ID 
    
    public function __construct(){
        //get the sessionid from the cookie array  
        if(!isset($_COOKIE['PHPSESSID'])){ //on first page load the session cookie is empty
            $this->sessionID='New Session';
            $_SESSION['PHPSESSID'] = $this->sessionID;
        }
        else{
            $this->sessionID=$_COOKIE['PHPSESSID'];
            $_SESSION['PHPSESSID'] = $this->sessionID;
        }
        

        
        //initialise session variables
        if (isset($_SESSION['loggedin'])){
            //session is already running
            $this->loggedin=$_SESSION['loggedin'];
        }
        else{
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=$_SESSION['loggedin'];
          }
          
        if (isset($_SESSION['userID'])){
            //session is already running with a logged in user
            $this->userID=$_SESSION['userID'];
        }
        else{
          $_SESSION['userID'] = NULL;
          $this->loggedin=NULL;
          }
          
        //this class can be used to manage other variables besides $_SESSION['loggedin']
        //this one keeps track of the number of times pages are viewed by the user  
        if(isset($_SESSION['views'])){
            $_SESSION['views'] = $_SESSION['views']+ 1;            
        }
        else{
             $_SESSION['views'] = 1;            
        }
        
        if (isset($_SESSION['userAuthorisation'])){
            //session is already running
            $this->userAuthorisation=$_SESSION['userAuthorisation'];
        }
        else{
          $_SESSION['userAuthorisation'] = 0;
          $this->loggedin=$_SESSION['userAuthorisation'];
          }

    }
    public function setLoggedin($loggedin){
        if($loggedin==TRUE){     
          $_SESSION['loggedin'] = TRUE;
          $this->loggedin=TRUE;  
          return '<br>SESSION CLASS Function - Logging IN<br>';  //used for diagnostics only
        }
        else{
          $_SESSION['userAuthorisation']=0; 
          $_SESSION['loggedin'] = FALSE;
          $this->loggedin=FALSE;
          // Unset all of the session variables.
            $_SESSION = array();

            // If it's desired to kill the session, also delete the session cookie.
            // Note: This will destroy the session, and not just the session data!
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
          session_destroy();  //sets all SESSION variables to NULL

          return '<br>SESSION CLASS - Function Logging OUT<br>'; //used for diagnostics only
        }    
    }

    public function setUserAuthorisation($userAuthorisation){
        $this->userAuthorisation=$userAuthorisation;
        $_SESSION['userAuthorisation']=$userAuthorisation;
    }    
    
    public function setUserID($userID){
        $this->userID=$userID;
        $_SESSION['userID']=$userID;
    }
    
    public function getUserID(){
        return $this->userID;
    }    
    
    public function getLoggedin(){
        return $this->loggedin;
    }
    public function getUserAuthorisation(){
        return $this->userAuthorisation;
    }           
}
 
