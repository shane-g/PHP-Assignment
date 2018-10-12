<?php
class admin extends Model{
    
        //CLASS PROPERTIES
        
        //lecturer properties
        private $userName; //String : users' ID.
        private $Name;//String : name
        //private $favouriteCompany;
       // private $country;
        private $password; //String : password    
        
        //properties used by view
        private $panelHead_1;//String: used by the view
        private $stringPanel_1;//String: used by the view
        private $panelHead_2;//String: used by the view
        private $stringPanel_2;//String: used by the view

        //properties usd by class to manage view content and database interaction
        private $db; //MySQLi Class object - connection to MySQL database
        private $sql; //String : SQL querry
        private $loginError; //String : contains error message from login 
        private $session; //Session class object
        private $pageID;//String: used to select the view content
    
    
	function __construct($pageID,$UserName,$db,$session){   
            //class properties based on constructor arguments
            $this->session=$session;
            parent::__construct($this->session->getLoggedIn());
            //parent::__construct($session);
            $this->userName=$UserName;
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
                    $this->panelHead_1='<h3>Administrator Login</h3>';
                    break;
                case "login_admin":
                    $this->panelHead_1='<h3>Administrator Login</h3>';
                    break;
                case "logout":
                    $this->panelHead_1='<h3>Logged out</h3>';
                    break;
                case "process_login_admin":
                    //TODO
                    $this->panelHead_1 = '<h3>Home Page of '.$this->userName.' '.$this->Name.'</h3>';  
                    break;
                
                //REGISTRATION
              //  case "register":
                //    $this->panelHead_1='<h3>User Register</h3>';
                  //  break;
               // case "process_registration":
                    //TODO
                  //  $this->panelHead_1 = 'User Registration Result';  
                   // break; 

                default:
                    $this->panelHead_1='<h3>Administration User</h3>';
                    break;
            }
        }        
        public function setStringPanel_1(){
            //get the panel content
                
            switch ($this->pageID) {
                case "login":
                    $this->stringPanel_1 = file_get_contents('forms/loginAdmin.html');  //this reads an external form file into the string
                    break;
               // case "register":
                //    $this->stringPanel_1 = file_get_contents('forms/registerForm.html');  //this reads an external form file into the string
                 //   break;
                case "process_login_admin":
                    $this->userName=$this->db->real_escape_string($_POST['userName']);
                    $this->password=$this->db->real_escape_string($_POST['pass']);
                    
                    //call the login method
                    //if ($this->login()){ //passwords not encrypted
                    if ($this->loginEncryptPW()){ //passwords encrypted
                        $this->session->setLoggedin(TRUE);
                        $this->session->setUserAuthorisation(1);
                        $this->session->setUserID($this->userName);
                        $this->stringPanel_1='Welcome, '.$this->Name.', to your Plane Fan System.';
                    }
                    else{
                        $this->session->setLoggedin(FALSE);  //user is not logged on
                        $this->session->setUserAuthorisation(0); //privileges set to none
                        $this->stringPanel_1='Login NOT Successful'.$this->loginError;
                    }

                    break; 
               /* case "process_registration":    //new admin can't register             
                    $this->userName=$this->db->real_escape_string($_POST['userName']);
                    $this->Name=$this->db->real_escape_string($_POST['Name']);
                    $favouriteCompany=$this->db->real_escape_string($_POST['country']);
                    $country=$this->db->real_escape_string($_POST['country']);
                    $Pass1=$this->db->real_escape_string($_POST['pass1']);
                    $Pass2=$this->db->real_escape_string($_POST['pass2']);
                    
                    if ($Pass1===$Pass2){//make sure the passwords match
                        $this->password=$Pass1;
              
                         //register, no password encryption
                        if($this->registerEncryptPW()){  //register - password encryption
                            $this->stringPanel_1 = 'Registration successful - please log in using the link above.';
                            }
                        else{//registration not successful
                            $this->stringPanel_1 = file_get_contents('forms/registerForm.html');
                            $this->stringPanel_1.= 'Unable to complete registration Possible duplicate Lecturer ID';
                            }                        
                    }
                    else{//passwords dont match  show the registration form 
                        //$this->stringPanel_1 = file_get_contents('forms/registerForm.html');
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
            //password is encrypted
            $this->password=hash('ripemd160', $this->password);   
            //query the database
            $sql='SELECT  * FROM adminUser WHERE userName="'.$this->userName.'" AND password="'.$this->password.'"';
            $this->sql=$sql; //for diagnostic purposes
            
            //check if any rows returned from query
            if($rs=$this->db->query($sql)){   
                if ($rs->num_rows<>1){  //username and password is not valid
                    $this->loginError= 'Login Fail - '.$rs->num_rows;
                    //free result set memory
                    $rs->free();
                    return FALSE;                    
                }
                else{                    
                $this->loginError= 'Login Successful - no error';
                $row=$rs->fetch_assoc();
                $this->userName=$row['userName'];
                $this->Name=$row['Name'];
                
                    $rs->free();
                    $this->loggedin=TRUE;
                    return TRUE;
                } 
            } 
            else{  //resultset is empty or something else went wrong with the query
                $this->loggedin=FALSE;
                return FALSE;
            }           
        }
      /*  private function register(){
                        //create the SQL insert statement for the new record
                       // $sql='INSERT INTO `plane`.`registereduser`(`userName`,`name`,`favouriteCompany`,`country`, `password`)VALUES("'.$this->userName.'","'.$this->Name.'","'.$this->favouriteCompany.'","'.$this->country.'","'.$this->password.'")';
                        //execute the insert query
                        if(@$this->db->query($sql)){  //execute the query and check it worked    
                            return TRUE;
                        } 
                        else{  //insert query has not succeeded
                            return FALSE;
                        }                        
        }
        private function registerEncryptPW(){
                        $this->password=hash('ripemd160', $this->password);
            
                        //create the SQL insert statement for the new record
                       // $sql='INSERT INTO `plane`.`registereduser`(`userName`,`name`,`favouriteCompany`,`country`, `password`)VALUES("'.$this->userName.'","'.$this->Name.'","'.$this->favouriteCompany.'","'.$this->country.'","'.$this->password.'")';
                        //execute the insert query
                        if(@$this->db->query($sql)){  //execute the query and check it worked    
                            return TRUE;
                        } 
                        else{  //insert query has not succeeded
                            return FALSE;
                        }                        
        }*/
        
        //public accessible getter functions
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getStringPanel_1(){return $this->stringPanel_1;}
        public function getuserName(){return $this->userName;}
        public function getSQL(){return $this->sql;}       
        
}

