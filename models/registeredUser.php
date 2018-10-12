<?php
class registeredUser extends Model{
    
        //CLASS PROPERTIES
        
        //lecturer properties
        private $userID; //String : users' ID.
        private $firstName;//String : name
        private $favouriteCompany;//String : favourite company
        private $country;//String : country
        private $account;//String : account type
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
            $this->setStringPanel_2();
            $this->setPanelHead_2();
	}//constructor
    
        //setters panel 1
        public function setPanelHead_1(){
            switch ($this->pageID) {
                //LOGIN/OUT
                case "login":
                    $this->panelHead_1='<h3>User Login</h3>';
                    break;
                case "login_enthusiast":
                    $this->panelHead_1='<h3>User Login</h3>';
                    break;
                case "logout":
                    $this->panelHead_1='<h3>Logged out</h3>';
                    break;
                case "enthusiasts":
                    $this->panelHead_1='<h3>View Enthusiast Accounts</h3>';
                    break;
                case "enthusiast_query":
                    $this->panelHead_1='<h3>Enthusiast Query</h3>';
                    break;
                case "process_login":
                    //TODO
                    $this->panelHead_1 = '<h3>Home Page of '.$this->firstName.'</h3>';  
                    break;               
                //REGISTRATION
                case "register":
                    $this->panelHead_1='<h3>User Register</h3>';
                    break;
                case "process_registration":
                    $this->panelHead_1 = 'User Registration Result';  
                    break; 
                default:
                    $this->panelHead_1='<h3>Registered User</h3>';
                    break;
            }
        }        
        public function setStringPanel_1(){
            //get the panel content
            //if($this->loggedin){ 
                switch ($this->pageID) {
                    case "login":
                        $this->stringPanel_1 = file_get_contents('forms/loginUserForm.html');  //this reads an external form file into the string
                        break;
						case "register":
						$this->stringPanel_1=file_get_contents('forms/registerForm.html');
						break;
                    case "enthusiasts":
                        $this->stringPanel_1='Use the links above to view the accounts';
                        break;
                    case "enthusiast_query":
                        $this->stringPanel_1 = file_get_contents('forms/enthusiastQuery.html');
                        break;
                    case "enthusiast_query_result":
                        $this->stringPanel_1 = file_get_contents('forms/enthusiastQuery.html');  //this reads an external form file into the string  
                        break;
                    case "enthusiast_account_result":
                        $this->stringPanel_1 = file_get_contents('forms/enthusiastQuery.html');  //this reads an external form file into the string  
                        break;
                    case "process_login":
                        $this->userID=$this->db->real_escape_string($_POST['userID']);
                        $this->password=$this->db->real_escape_string($_POST['pass']);
                    
                        //call the login method
                        //if ($this->login()){ //passwords not encrypted
                        if ($this->loginEncryptPW()){ //passwords encrypted
                            $this->session->setLoggedin(TRUE);
                            $this->session->setUserAuthorisation(3);
                            $this->session->setUserID($this->userID);
                            $this->stringPanel_1='Welcome, '.$this->firstName.', to your Plane Fan System.';
                        }
                        else{
                            $this->session->setLoggedin(FALSE);  //user is not logged on
                            $this->session->setUserAuthorisation(0); //privileges set to none
                            $this->stringPanel_1='Login NOT Successful'.$this->loginError;
                        }   
                        break; 
                    case "process_registration":                 
                        $this->userID=$this->db->real_escape_string($_POST['UserID']);
                        $this->firstName=$this->db->real_escape_string($_POST['FirstName']);
                        $this->favouriteCompany=$this->db->real_escape_string($_POST['FavouriteCompany']);
                        $this->country=$this->db->real_escape_string($_POST['Country']);
                        $this->account=$this->db->real_escape_string($_POST['actype']);
                        $UserPass1=$this->db->real_escape_string($_POST['userPass1']);
                        $UserPass2=$this->db->real_escape_string($_POST['userPass2']);
                    
                        if ($UserPass1===$UserPass2){//make sure the passwords match
                            $this->password=$UserPass1;           
                             //register, no password encryption
                            if($this->registerEncryptPW())
                                {  //register - password encryption
                                    $this->stringPanel_1 = 'Registration successful - please log in using the link above.';
                                }
                            else{//registration not successful
                                $this->stringPanel_1 = file_get_contents('forms/registerForm.html');
                                $this->stringPanel_1.= 'Unable to complete registration Possible duplicate Enthusiast ID';
                                }                        
                        }
                        else{//passwords dont match  show the registration form 
                            $this->stringPanel_1 = file_get_contents('forms/registerForm.html');
                            $this->stringPanel_1.= '<br>Passwords you have entered don\'t match - please try again. '; 
                        }                 
                        break; 
                    case "logout":
                        $this->logout();
                        $this->stringPanel_1 ='Logged out of your account successfully.<br>Please use the links above to register or login again.';
                        break;
                    default:
                        $this->stringPanel_1 = file_get_contents('forms/loginUserForm.html');
                        //$this->stringPanel_1 = 'Use the links above to view the accounts';  //this reads an external form file into the string
                        break;
                }    
           // }
        } 
        public function setPanelHead_2(){
            //if($this->loggedin){
                switch ($this->pageID) {
					case "login":
                    $this->panelHead_2='';
                    break;
					case "register":
                    $this->panelHead_2='';
                    break;
                    case "enthusiasts":
                        $this->panelHead_2='<h3>View Enthusiast Accounts</h3>';
                        break;
                    case "enthusiast_query":
                        $this->panelHead_2='<h3>Enthusiast Query Result</h3>';
                        break;
                    case "enthusiast_query_result":
                        $this->panelHead_2='<h3>Query Result for '.$this->userID.'</h3>';
                        break;
                    case "enthusiast_account_result":
                        $this->panelHead_2='<h3>Account Results for '.$this->userID.'</h3>';
                        break;  
                     default:
                        $this->panelHead_2='<h3>Enthusiast Query Result</h3>';
                        break; 
                }
                
            //}           
        }
        public function setStringPanel_2(){
           // if($this->loggedin){  //these page options are only available to logged in users
                switch ($this->pageID) {
                    case "enthusiast_query":
                        $this->stringPanel_2='';
                        $this->stringPanel_2.='<p>View Enthusiast Accounts from here</p>'; 
                        break;
                    case "enthusiast_query":
                        $this->stringPanel_2='';
                        $this->stringPanel_2.='<p>Enter a Enthusiast ID in the form. Results will appear here</p>'; 
                        break;
                    case "enthusiast_query_result":
                        $this->getEnthusiastByID();
                        break;
                    case "enthusiast_account_result":
                        $this->getEnthusiastAccountByID();
                        break; 
                     default:
                        $this->stringPanel_2='<p>Enthusiast Query result will appear here</p';
                        break;                   
                }   
           // }
        }
        private function getEnthusiastByID(){
            //query the database
            $sql='SELECT  userID,firstName,accountType FROM registereduser WHERE userID="'.$this->userID.'"';
            $this->stringPanel_2='';
            //check if any rows returned from query
            if((@$rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                //iterate through the resultset to create a HTML table
                $this->stringPanel_2.= '<table class="table table-bordered">';
                $this->stringPanel_2.='<tr><th>UserID</th><th>First Name</th><th>Account type</th><th>View More</th></tr>';//table headings
                while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                        $this->stringPanel_2.='<tr>';//--start table row
                           foreach($row as $key=>$value){
                                    $this->stringPanel_2.= "<td>$value</td>";
                            }
                            //Transcript button
                            $this->stringPanel_2.= '<td>';
                            $this->stringPanel_2.= '<form action="'.$_SERVER["PHP_SELF"].'?pageID=enthusiast_account_result" method="post">';
                            $this->stringPanel_2.= '<input type="submit" type="button" value="Get Account Details" name="enthusiast_account_result">';
                            $this->stringPanel_2.= '<input type="hidden" value="'.$this->userID.'" name="userID">';
                                //when the button is pressed the 
                                //studentID 'hidden' value is inserted 
                                //into the $_POST array
                            $this->stringPanel_2.= '</form>';
                            $this->stringPanel_2.= '</td>';
                            $this->stringPanel_2.= '</tr>';  //end table row
                        }
                $this->stringPanel_2.= '</table>';   
                }  
            else{  //resultset is empty or something else went wrong with the query
                 if (!$rs->num_rows){
                    $this->stringPanel_2.= '<br>No records have been returned - resultset is empty - Nr Rows = '.$rs->num_rows. '<br>';
                    }
                    else{
                    $this->stringPanel_2.= '<br>SQL Query has FAILED - possible problem in the SQL - check for syntax errors<br>';
                    }
            }
            //free result set memory
            $rs->free();
        }
        private function getEnthusiastAccountByID(){
            //query the database
            $sql='SELECT favCompany,Country FROM registereduser r WHERE r.userID="'.$this->userID.'"';
            $this->stringPanel_2='';           
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and iterate through the resultset
                    //iterate through the resultset to create a HTML table
                    $this->stringPanel_2.= '<table class="table table-bordered">';
                    $this->stringPanel_2.='<tr><th>Favourite Company</th><th>Country of Residence</th></tr>';
                    //fetch associative array from resultset
                    while ($row = $rs->fetch_assoc()) {
                        $this->stringPanel_2.='<tr>';//--start table row
                           foreach($row as $key=>$value){
                                    $this->stringPanel_2.= "<td>$value</td>";
                            }
                            $this->stringPanel_2.= '</tr>';  //end table row
                        }
                    $this->stringPanel_2.= '</table>';
            }  
            else{  //resultset is empty or something else went wrong with the query
                 if (!$rs->num_rows){
                    $this->stringPanel_2.= '<br>No records have been returned - resultset is empty - Nr Rows = '.$rs->num_rows. '<br>';
                    }
                    else{
                    $this->stringPanel_2.= '<br>SQL Query has FAILED - possible problem in the SQL - check for syntax errors<br>';
                    }
            }
            //free result set memory
            $rs->free();
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
            $sql='SELECT  * FROM registereduser WHERE userID="'.$this->userID.'" AND password="'.$this->password.'"';
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
                $this->userName=$row['userID'];
                $this->firstName=$row['firstName'];
                
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
        private function register(){ //NOT USED
                        //create the SQL insert statement for the new record
                        $sql='INSERT INTO `plane`.`registereduser`(`userID`,`firstName`,`favCompany`,`Country`, `password`, `accountType`)VALUES("'.$this->userID.'","'.$this->firstName.'","'.$this->favouriteCompany.'","'.$this->country.'","'.$this->password.'","'.$this->account.'")';
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
                        $sql='INSERT INTO `plane`.`registereduser`(`userID`,`firstName`,`favCompany`,`Country`, `password`, `accountType`)VALUES("'.$this->userID.'","'.$this->firstName.'","'.$this->favouriteCompany.'","'.$this->country.'","'.$this->password.'","'.$this->account.'")';
                        //execute the insert query
                        if(@$this->db->query($sql)){  //execute the query and check it worked    
                            return TRUE;
                        } 
                        else{  //insert query has not succeeded
                            return FALSE;
                        }                        
        }
        
        //public accessible getter functions
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getStringPanel_1(){return $this->stringPanel_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getStringPanel_2(){return $this->stringPanel_2;}
        public function getuserID(){return $this->userID;}
        public function getSQL(){return $this->sql;}       
        
}
