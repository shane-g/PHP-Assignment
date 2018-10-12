<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MainController extends Controller{
    
        //properties
        private $pageID;  //String : containing the name of the requested page
        private $db; //MySQLi connection object
        private $data; //Array containing content data for the view
        private $session; //Session class object
        private $userAuthorisation; //Integer - 0=not authorised 1=administrator 2=lecturer 3=student
    
	//constructor
	function __construct($db, $session){  
           //initialise the class properties
           $this->data=[]; //initialise an empty array  [this is only accessed in debug mode] 
           $this->session=$session; 
           parent::__construct($this->session->getLoggedIn());
           $this->db=$db;
           
           //call the the main app methods 
           $this->processView();  //get the requested next page
           $this->updateView(); //a switch to load the model and update the view
           $this->debugInfo(); //if debug is turned on display the debug info
           
	}//construct the main controller object
          
        //methods
        public function processView(){
            //This main controller handles all page requests vis the URL - GET Methos
            //$_GET will contain the selected pageID 
            //If the page is loaded for the first time then the $_GET array is empty
            //so a default value is set for $this->pageID
            if (isset($_GET['pageID'])){  //get the value of pageID from $_GET array
                $this->pageID=$_GET['pageID'];
            }
            else{  //no value passed through URL to $_GET array
                $this->pageID='noPageSelected';  //this will execute the default
            }
        }  //get the page ID
        public function updateView(){
            //this SWITCH is the main selector of the next page to load
           if($this->loggedin){  //these page options are only available to logged in users      
            $this->userAuthorisation=$this->session->getUserAuthorisation();   
            if($this->userAuthorisation==1){
                //user is logged in as administrator
               switch ($this->pageID) {           
                case "home":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page                    
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2(); 
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    //
                    //display the view
                    include_once 'views/view_Panel_3.php';  //load the view
                    break;
                case "messages":
                    //get the model
                    $message=new Message($this->pageID,NULL,$this->db,$this->session);
                    $home=new Home($this->pageID,$this->session);    
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$message->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$message->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                   // $data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$message->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$message->getPanelHead_2();// A string containing the ~MIDDLE panel heading/title  
                   // $data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                       
                    //display the view
                    include_once 'views/view_Panel_3.php'; //load the view
                    break;
                /*case "planes":
                    //get the model
                    $home=new Home($this->pageID,$this->session);                   
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] ='under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] ='ACCOUNT Page under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']='<h3>under construction</h3>';// A string containing the LHS panel heading/title
                    $data['panelHead_2']='<h3>under construction</h3>';// A string containing the ~MIDDLE panel heading/title 
                    $data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                    
                    
                    //display the view
                    include_once 'views/view_3_panel.php'; //load the view
                    break;
                case "students":
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                    $student=new Student($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break;
                case "student_query":
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                    $student=new Student($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break;
                case "student_query_result":
                    //get the selected student ID from the transcript query form
                    $studentID=$_POST['studentID'];

                    //get the models
                    $home=new Home($this->pageID,$this->session);
                    $student=new Student($this->pageID,$studentID,$this->db,$this->session); 
                    $data=[];  //initialise an empty data array
                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break;             
                case "student_transcript_result":
                    //get the selected student ID from the transcript query form
                    $studentID=$_POST['studentID'];
                    
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                    $student=new Student($this->pageID,$studentID,$this->db,$this->session); 
                    
                    //get the content from the models - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                     
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break;                                      
                case "modules":
                    //get the model
                    $home=new Home($this->pageID,$this->session);  
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] ='Use the links above to manage Modules';     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']='<h3>Module Management</h3>';// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                    

                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break;
                case "list_all_modules":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               

                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break; 
                case "new_module":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break; 
                case "edit_module":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break; 
                case "edit_module_form":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break; 
                case "process_edit_module":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break; 
                case "process_new_module":
                    //get the model
                    $home=new Home($this->pageID,$this->session); 
                    $modules=new Modules($this->pageID,$this->loggedin,$this->db); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$modules->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$modules->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode               
                    //display the view
                    include_once 'views/view_1_panel.php'; //load the view
                    break;                  
                case "grades":
                    //get the model
                    $home=new Home($this->pageID,$this->session); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] ='under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] ='GRADES Page under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']='<h3>under construction</h3>';// A string containing the LHS panel heading/title
                    $data['panelHead_2']='<h3>under construction</h3>';// A string containing the ~MIDDLE panel heading/title
                    $data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                     

                    //display the view
                    include_once 'views/view_3_panel.php'; //load the view
                    break;             */
                case "logout":
                    //get the models
                   // $lecturer = new Lecturer($this->pageID, NULL, $this->db,$this->session);
                   // $this->loggedin=$lecturer->getLoggedin(); //update the status of the login variable
                    $admin = new admin($this->pageID, NULL, $this->db,$this->session);
                    $home=new Home($this->pageID,$this->session);    
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$admin->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$admin->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php'; //load the view
                    break;
                default:
                    //get the model
                    $home=new Home($this->pageID,$this->session);

                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2();
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php';  
                    break;
            }  
            }
            else if($this->userAuthorisation==2){
                //user is logged in as enthusiast
               switch ($this->pageID) {           
                case "home":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page                    
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2(); 
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    //
                    //display the view
                    include_once 'views/view_Panel_3.php';  //load the view
                    break;
                /*case "account":
                    //get the model
                    $home=new Home($this->pageID,$this->session);                   
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] ='under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] ='ACCOUNT Page under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']='<h3>under construction</h3>';// A string containing the LHS panel heading/title
                    $data['panelHead_2']='<h3>under construction</h3>';// A string containing the ~MIDDLE panel heading/title 
                    $data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                    
                    
                    //display the view
                    include_once 'views/view_3_panel.php'; //load the view
                    break;*/
                case "messages":
                    //get the model
                    $home=new Home($this->pageID,$this->session);        
                    $message=new Message($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$message->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$message->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$message->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$message->getPanelHead_2(); ;// A string containing the ~MIDDLE panel heading/title 
                    //$data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                    
                    
                    //display the view
                    include_once 'views/view_Panel_2.php'; //load the view
                    break;     
                case "message_submit":
                    //get the model
                    $home=new Home($this->pageID,$this->session);        
                    $message=new Message($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$message->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$message->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$message->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$message->getPanelHead_2(); ;// A string containing the ~MIDDLE panel heading/title 
                    //$data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode         
                    //display the view
                    include_once 'views/view_Panel_2.php'; //load the view
                    break;    
                case "planes":
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                   // $student=new Student($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;
               /* case "student_query":
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                    $student=new Student($this->pageID,NULL,$this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break;
                case "student_query_result":
                    //get the selected student ID from the transcript query form
                    $studentID=$_POST['studentID'];

                    //get the models
                    $home=new Home($this->pageID,$this->session);
                    $student=new Student($this->pageID,$studentID,$this->db,$this->session); 
                    $data=[];  //initialise an empty data array
                    
                    //get the content from the model - put into the $data array for the view:
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break;             
                case "student_transcript_result":
                    //get the selected student ID from the transcript query form
                    $studentID=$_POST['studentID'];
                    
                    //get the models
                    $home=new Home($this->pageID,$this->session); 
                    $student=new Student($this->pageID,$studentID,$this->db,$this->session); 
                    
                    //get the content from the models - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$student->getPanelHead_1(); 
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_2']=$student->getPanelHead_2();// A string containing the RHS panel heading/title
                    $data['stringPanel_2'] =$student->getStringPanel_2();     // A string intended of the Right Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                     
                    //display the view
                    include_once 'views/view_2_panel.php'; //load the view
                    break; */                                                
               /* case "grades":
                    //get the model
                    $home=new Home($this->pageID,$this->session); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] ='under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] ='GRADES Page under construction';     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] ='under construction';     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']='<h3>under construction</h3>';// A string containing the LHS panel heading/title
                    $data['panelHead_2']='<h3>under construction</h3>';// A string containing the ~MIDDLE panel heading/title
                    $data['panelHead_3']='<h3>under construction</h3>';// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                                     

                    //display the view
                    include_once 'views/view_3_panel.php'; //load the view
                    break;    */        
                case "logout":
                    //get the models
                  //  $admin = new admin($this->pageID, NULL, $this->db,$this->session);
                    $enthusiast= new registeredUser($this->pageID, NULL, $this->db,$this->session);
                    $this->loggedin=$enthusiast->getLoggedin(); //update the status of the login variable
                    $home=new Home($this->pageID,$this->session);    
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$enthusiast->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$enthusiast->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php'; //load the view
                    break;
                default:
                    //get the model
                    $home=new Home($this->pageID,$this->session);

                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2();
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php';  
                    break;
            }  
            }
            else {
                //user has no privileges
                    //get the model
                    $home=new Home($this->pageID,$this->session);

                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2();
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php';  
            }        
           }
           else{//user is not logged in
            switch ($this->pageID) {
                case 'login':
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                   // $enthusiast = new registeredUser($this->pageID, NULL, $this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_2'] =$lecturer->getStringPanel_2();     // A string intended of the Left Hand Side of the page

                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    //$data['panelHead_2']=$lecturer->getPanelHead_2();// A string containing the ~MIDDLE panel heading/title 

                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;               
                /*case 'login_student':
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                   // $student = new Student($this->pageID, NULL, $this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$student->getStringPanel_1();     // A string intended of the Left Hand Side of the page


                    $data['panelHead_1']=$student->getPanelHead_1();// A string containing the LHS panel heading/title


                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;   */
                case 'login_enthusiast':
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $enthusiast = new registeredUser($this->pageID, NULL, $this->db,$this->session);
                   // $enthusiast = new registeredUser($pageID, NULL, $db, $session);
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$enthusiast->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_2'] =$lecturer->getStringPanel_2();     // A string intended of the Left Hand Side of the page

                    $data['panelHead_1']=$enthusiast->getPanelHead_1();// A string containing the LHS panel heading/title
                    //$data['panelHead_2']=$lecturer->getPanelHead_2();// A string containing the ~MIDDLE panel heading/title 

                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;   
                case 'login_admin':
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $admin = new admin($this->pageID, NULL, $this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$admin->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_2'] =$lecturer->getStringPanel_2();     // A string intended of the Left Hand Side of the page

                    $data['panelHead_1']=$admin->getPanelHead_1();// A string containing the LHS panel heading/title
                    //$data['panelHead_2']=$lecturer->getPanelHead_2();// A string containing the ~MIDDLE panel heading/title 

                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;   
                case 'process_login':
                    //get the models
                   // $admin = new admin($this->pageID, NULL, $this->db,$this->session);
                    $enthusiast = new registeredUser($this->pageID, NULL, $this->db,$this->session);
                    $this->loggedin=$enthusiast->getLoggedin(); //update the status of the login variable
                    $this->userAuthorisation=$this->session->getUserAuthorisation();
                    $home=new Home($this->pageID,$this->session); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$enthusiast->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$enthusiast->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;
                case 'process_login_admin':
                    //get the models
                    $admin = new admin($this->pageID, NULL, $this->db,$this->session);
                    $this->loggedin=$admin->getLoggedin(); //update the status of the login variable
                    $this->userAuthorisation=$this->session->getUserAuthorisation();
                    $home=new Home($this->pageID,$this->session); 
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$admin->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['panelHead_1']=$admin->getPanelHead_1();// A string containing the LHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;
                case "register":
                    //get the model
                    $home=new Home($this->pageID,$this->session); 
                    $enthusiast = new registeredUser($this->pageID, NULL, $this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$enthusiast->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    //$data['stringPanel_2'] =$lecturer->getStringPanel_2();     // A string intended of the Left Hand Side of the page

                    $data['panelHead_1']=$enthusiast->getPanelHead_1();// A string containing the LHS panel heading/title
                    //$data['panelHead_2']=$lecturer->getPanelHead_2();// A string containing the ~MIDDLE panel heading/title 

                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode

                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break;    
                case "process_registration":
                    //get the model
                    $home=new Home($this->pageID,$this->session);
                    $enthusiast = new registeredUser($this->pageID, NULL, $this->db,$this->session);
                    
                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['panelHead_1']=$enthusiast->getPanelHead_1(); 
                    $data['stringPanel_1'] =$enthusiast->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_1.php'; //load the view
                    break; 
                default:
                    //get the model
                    $home=new Home($this->pageID,$this->session);

                    //get the content from the model - put into the $data array for the view:
                    $data=[];  //initialise an empty data array
                    $data['pageTitle']=$home->getPageTitle(); 
                    $data['menuNav']   =$home->getMenuNav();       // an array of menu items and associated URLS
                    $data['stringPanel_1'] =$home->getStringPanel_1();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_2'] =$home->getStringPanel_2();     // A string intended of the Left Hand Side of the page
                    $data['stringPanel_3'] =$home->getStringPanel_3();     // A string intended of the Right Hand Side of the page
                    $data['panelHead_1']=$home->getPanelHead_1();// A string containing the LHS panel heading/title
                    $data['panelHead_2']=$home->getPanelHead_2();
                    $data['panelHead_3']=$home->getPanelHead_3();// A string containing the RHS panel heading/title
                    $this->data=$data; //put the $data array into the class property do it can be accedded in DEBUG mode
                    
                    //display the view
                    include_once 'views/view_Panel_3.php';  
                    break;
                
            }            
           }      
        }  //update the $data array and load the view
        private function debugInfo(){
            if(__DEBUG){
                echo '<!-- The Debug SECTION -->';
                echo '<section style="background-color: #BBBBBB">';
                echo '<div class="container">';
                echo '<h2>Web Application Debug information</h2><br>';
                echo '<h3>Controller (CLASS) properties</h3>';
                echo '$loggedin ='.$this->loggedin.'<br>';
                echo '$pageID   ='.$this->pageID.'<br>';
                echo '$userAuthorisation = '.$this->userAuthorisation.'<br>';
                echo '<h3>Super Global Array</h3>';
                echo '<h4>$_GET Arrays</h4>';
                echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
                foreach($_GET as $key=>$value){echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';}
                echo '</table>';

                echo '<h4>$_POST Array</h4>';
                echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
                foreach($_POST as $key=>$value){echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';}
                echo '</table>';
                
                echo '<h4>$_COOKIE Array</h4>';
                echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
                foreach($_COOKIE as $key=>$value){echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';}
                echo '</table>';
                
                echo '<h4>$_SESSION Array</h4>';
                echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
                foreach($_SESSION as $key=>$value){echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';}
                echo '</table>';
 
                echo '<h4>$data Array (data passed to VIEW)</h4>';
                echo '<table class="table table-bordered"><thead><tr><th>KEY</th><th>VALUE</th></tr></thead>';
                foreach($this->data as $key=>$value){echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';}
                echo '</table>';
                
                
                echo '</div>';
                echo '</section>';
            }
        }   //if enabled in config.php - display the debug information 
}
