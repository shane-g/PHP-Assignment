<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Home extends Model{
	//class properties
        private $pageTitle;
        private $menuNav;
        private $panelHead_1;
        private $stringPanel_1;
        private $panelHead_2;
        private $stringPanel_2;
        private $panelHead_3;
        private $stringPanel_3;
        private $pageID;
        private $session;
	
	//constructor
	function __construct($pageID,$session){ //construct the home object   
            $this->session=$session;
            parent::__construct($this->session->getLoggedin());
            //parent::__construct($session);
            
            $this->pageID=$pageID;

            
            $this->setPageTitle();
            $this->setmenuNav();

            //get the LHS panel content
            $this->setPanelHead_1();
            $this->setStringPanel_1();
            //get the Middle panel content
            $this->setPanelHead_2();
            $this->setStringPanel_2();      
            //get the RHS panel content
            $this->setStringPanel_3();
            $this->setPanelHead_3();
   
	}
        
        //setters
        public function setPageTitle(){
            //get the Middle panel content
            if($this->loggedin){
                $this->pageTitle='Plane Fan';
            }
            else{        
                $this->pageTitle='Plane Fan';
            }
        }  
        public function setmenuNav(){  //navigation menu depends on whether user is logged on and theuser authorisation level
            //set the menu item data
            if($this->loggedin){//these page options are only available to logged in users
                if($this->session->getUserAuthorisation()==1){  //authorisation level = 1 - Administrator
                switch ($this->pageID) {
                    case "home":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';
                       // $this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=gallery">Gallery</a>';           
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    //PLANES MENU ITEMS
                    case "planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "list_all_planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                       // $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';               
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "new_plane":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        //$this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';                         
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    //ENTHUSIAST MENU ITEMS
                    case "enthusiasts":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';  
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_query":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';   
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_query_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';  
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_account_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>'; 
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                   
                    //Default Menu
                    default:
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';
                       // $this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=gallery">Gallery</a>';         
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                
                    }                     
                }
                else if($this->session->getUserAuthorisation()==2){  //authorisation level = 2 - Moderator
                switch ($this->pageID) {                
                    //HOME Menu items
                    case "home":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';
                        //$this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=gallery">Gallery</a>';            
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    //PLANES MENU ITEMS
                    case "planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "list_all_planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';               
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "new_plane":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">List all planes</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add a plane</a>';                         
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    //ENTHUSIAST MENU ITEMS
                    case "enthusiasts":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';  
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_query":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';   
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_query_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiast_query">Enthusiast Query</a>';  
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "enthusiast_account_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>'; 
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                   
                    //Default Menu
                    default:
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=enthusiasts">Enthusiasts</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';
                       // $this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=gallery">Gallery</a>';           
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                 
                }                     
                }
                else if($this->session->getUserAuthorisation()==3){//authorisation level = 3 - registerd user
                switch ($this->pageID) {                    
                    //HOME Menu items
                    case "home":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';
                        //$this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=gallery">Gallery</a>';          
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                   
                    //PLANES menu items
                    case "planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">View Planes</a>';
                        //$this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=plane_query">Plane Query</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add Plane</a>';         
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "new_plane";
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">View Planes</a>';
                        //$this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=plane_query">Plane Query</a>';
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "process_new_plane";
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">View Planes</a>';
                        //$this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=plane_query">Plane Query</a>';
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "list_all_planes":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                       // $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">View Planes</a>';
                        //$this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=plane_query">Plane Query</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add Plane</a>';
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                   /* case "plane_query //not used
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=list_all_planes">View Planes</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=new_plane">Add Plane</a>';
                        //$this->menuNav[5]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=account">My Account</a>';          
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;
                    case "plane_query_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=plane_query">Plane Query</a>';         
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';                        
                        break;
                    case "plane_transcript_result":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';          
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';                     
                        break;  */
                    case "messages":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';        
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                    
                    case "message_submit":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';     
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                                  
                    //Default Menu
                    default:
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=planes">Planes</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=messages">My Messages</a>';          
                        $this->menuNav[6]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=logout">Log Out</a>';
                        break;                   
                }                     
                }
                else{  //no authorisation to view pages
                    $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                    $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                    $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                }                
            }
            else{ //not logged in menu items
                switch ($this->pageID) {
                    //Not logged in Menu items
                    case "home":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                        //$this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register_admin">Moderator Register</a>'; --Not allowed to register as staff
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                        break;
                    case "register":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                        //$this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register_admin">Moderator Register</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                        break;
                    /*case "register_admin":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                       // $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register_admin">Admin Register</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                        break;*/
                    case "login":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[3]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login_enthusiast">Enthusiast Login</a>';
                        $this->menuNav[4]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login_admin">Staff Login</a>';
                        break;
                    case "logout":
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                        break; 
                    default:
                        $this->menuNav[0]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=home">Home</a>';
                        $this->menuNav[1]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=register">Register</a>';
                        $this->menuNav[2]='<a href="'.$_SERVER['PHP_SELF'].'?pageID=login">Login</a>';
                        break;
                }
            }
        }   
        public function setPanelHead_1(){
            //set the LHS panel content
            if($this->loggedin){
                $this->panelHead_1='<h3>Plane Fan System</h3>';
            }
            else{        
                $this->panelHead_1='<h3>Plane Fan System</h3>';
            }           
            
        }        
        public function setStringPanel_1(){
            if($this->loggedin){
                $this->stringPanel_1='<h4>Overview</h4>';
                $this->stringPanel_1.='<p>Plane Fan system is designed for aircraft enthusiasts to view their favourite planes.'; 
                $this->stringPanel_1.='<p>You are currently logged in.';  
            }
            else{        
                $this->stringPanel_1='<h4>Overview</h4>';
                $this->stringPanel_1.='<p>Plane Fan system is designed for aircraft enthusiasts to view their favourite planes.'; 
                $this->stringPanel_1.='<p>You are NOT logged in. Please register or login using the links above.';  
            } 
        }         
        public function setPanelHead_2(){
            //get the Middle panel content
            if($this->loggedin){
                $this->panelHead_2='<h3>Welcome</h3>';
            }
            else{        
                $this->panelHead_2='<h3>Please register or login</h3>';
            }
        }  
        public function setStringPanel_2(){
            //get the Middle panel content
            if($this->loggedin){
                $this->stringPanel_2='Thank you for logging in successfully to the Plane Fan System. <br><br>Don\'t forget to logout when you are done.';
            }
            else{        
                $this->stringPanel_2='Please use the links above to login or register.';
            }
        }          
        public function setPanelHead_3(){
            if($this->loggedin){
                $this->panelHead_3='<h3>Side Notes</h3>';
            }
            else{        
                $this->panelHead_3='<h3>Side Notes</h3>';
            } 
        }        
        public function setStringPanel_3(){
            if($this->loggedin){
                $this->stringPanel_3='';
                $this->stringPanel_3.='<p>Plane Fan System</p>';
            }
            else{        
                $this->stringPanel_3='';
                $this->stringPanel_3.='<p>Plane Fan System</p>';
            } 
        }         
  
        //getters
        public function getPageTitle(){return $this->pageTitle;}
        public function getMenuNav(){return $this->menuNav;}
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getStringPanel_1(){return $this->stringPanel_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getStringPanel_2(){return $this->stringPanel_2;}
        public function getPanelHead_3(){return $this->panelHead_3;}
        public function getStringPanel_3(){return $this->stringPanel_3;}      
}//end class

