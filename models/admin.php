<?php
class admin extends Model{
    
        //CLASS PROPERTIES
        private $userID; //String : users' ID.
        private $firstName;//String : name
        //private $account;
        private $password; //String : password    
        
        //properties used by view
        private $panelHead_1;//String: used by the view
        private $stringPanel_1;//String: used by the view

        //properties usd by class to manage view content and database interaction
        private $db;
        private $sql;
        private $loginError;
        private $session;
        private $pageID;
    
    
	function __construct($pageID,$UserID,$db,$session){   
            //class properties based on constructor arguments
            $this->session=$session;
            parent::__construct($this->session->getLoggedIn());
            //parent::__construct($session);
            $this->userID=$UserID;
            $this->db=$db;
            $this->pageID=$pageID;
            
            //get the panel 1 content
            $this->setStringPanel_1();
            $this->setPanelHead_1();
	}//constructor
    
        //setters panel 1
        public function setPanelHead_1(){
            switch ($this->pageID) {
                //LOGIN/OUT
                case "login":
                    $this->panelHead_1='<h3>Staff Login</h3>';
                    break;
                case "login_admin":
                    $this->panelHead_1='<h3>Staff Login</h3>';
                    break;
                case "logout":
                    $this->panelHead_1='<h3>Logged out</h3>';
                    break;
                case "process_login":
                    $this->panelHead_1 = '<h3>Home Page of '.$this->firstName.'</h3>';  
                    break;               
/*/*                //REGISTRATION -- not allowed to register as staff
//                case "register_admin":
//                   $this->panelHead_1='<h3>Moderator Register</h3>';
//                   break;
//                case "process_admin_registration":
//                    //TODO
//                    $this->panelHead_1 = 'Moderator Registration Result';  
                   break; */ 

                default:
                    $this->panelHead_1='<h3>Staff User</h3>';
                    break;
            }
        }        
        public function setStringPanel_1(){
            //get the panel content               
            switch ($this->pageID) {
                case "login":
                    $this->stringPanel_1 = file_get_contents('forms/loginAdmin.html');  //this reads an external form file into the string
                    break;
                case "process_mlogin":
                    $this->userID=$this->db->real_escape_string($_POST['adminID']);
                    $this->password=$this->db->real_escape_string($_POST['password']);
                    
                    //call the login method
                    //if ($this->login()){ //passwords not encrypted
                    if ($this->loginEncryptPW()){ //passwords encrypted
                        $this->session->setLoggedin(TRUE);
                        $this->session->setUserAuthorisation(2);
                        $this->session->setUserID($this->userID);
                        $this->stringPanel_1='Welcome, '.$this->firstName.', to your Plane Fan System.';
                    }
                    else{
                        $this->session->setLoggedin(FALSE);  //user is not logged on
                        $this->session->setUserAuthorisation(0); //privileges set to none
                        $this->stringPanel_1='Login NOT Successful'.$this->loginError;
                    }
                    break; 
/*                case "register_admin": -- not allowed to register as staff
                   $this->stringPanel_1 = file_get_contents('forms/adminregisterForm.html');
                   break;
                case "process_admin_registration":    //new admin can't register             
                    $this->userID=$this->db->real_escape_string($_POST['UserName']);
                    $this->firstName=$this->db->real_escape_string($_POST['Name']);
                    $this->account=$this->db->real_escape_string($_POST['user']);
                    $AdminPass1=$this->db->real_escape_string($_POST['userPass1']);
                    $AdminPass2=$this->db->real_escape_string($_POST['userPass2']);
                    
                    if ($AdminPass1===$AdminPass2){//make sure the passwords match
                        $this->password=$AdminPass1;
              
                         //register, no password encryption
                        if($this->registerEncryptPW()){  //register - password encryption
                            $this->stringPanel_1 = 'Registration successful - please log in using the link above.';
                            }
                        else{//registration not successful
                            $this->stringPanel_1 = file_get_contents('forms/adminregisterForm.html');
                            $this->stringPanel_1.= 'Unable to complete registration Possible duplicate Moderator ID';
                            }                        
                    }
                    else{//passwords dont match  show the registration form 
                        $this->stringPanel_1 = file_get_contents('forms/adminregisterForm.html');
                        $this->stringPanel_1.= '<br>Passwords you have entered don\'t match - please try again. '; 
                   }                 
                   break; */
                case "logout":
                    $this->logout();
                    $this->stringPanel_1 ='Logged out of your account successfully.<br>Please use the links above to login again.';
                    break;
                default:
                    $this->stringPanel_1 = file_get_contents('forms/loginAdmin.html');  //this reads an external form file into the string
                    break;
            }                                     
        } 
        
        //private functions database interaction
        private function logout(){
            $this->loggedin=FALSE;
            $this->session->setLoggedin(FALSE);  //user is not logged on
            $this->session->setUserAuthorisation(0); //privileges set to none            
        }

        private function loginEncryptPW(){
            $this->password=hash('ripemd160', $this->password);
            $sql='SELECT  * FROM `plane`.`registereduser` WHERE userID="'.$this->userID.'"AND password="'.$this->password.'"';
            $this->sql=$sql;
            if($rs= $this->db->query($sql)){
                if($rs->num_rows<>1){
                    $this->loginError='Login Fail - '.$rs->num_rows;
                    $rs->free();
                    return FALSE;
                }
                else{
                    $this->loginError='Login Successful - no error';
                    $row=$rs->fetch_assoc();
                    $this->userName=$row['userID'];
                    $this->firstName=$row['firstName'];
                    
                        $rs->free();
                        $this->loggedin=TRUE;
                        return TRUE;
                }
            }
            else{
                $this->loggedin=FALSE;
                return FALSE;
            }
        }      

        
        //public accessible getter functions
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getStringPanel_1(){return $this->stringPanel_1;}
        public function getUserID(){return $this->userID;}
        public function getSQL(){return $this->sql;}       
        
}


