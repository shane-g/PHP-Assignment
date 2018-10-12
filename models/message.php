<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Message extends Model{
        //properties used by view
        private $panelHead_1;//String: used by the view
        private $stringPanel_1;//String: used by the view
        private $panelHead_2;//String: used by the view
        private $stringPanel_2;//String: used by the view
               
        private $pageID;//String: used by the view
        private $session;
        private $db; //MySQLi Class object - connection to MySQL database
        private $sql;
        private $msgText; //String - message text
      
        
	//constructor
	function __construct($pageID,$loggedin,$db, $session) 
	{   
            //class properties based on constructor arguments
            parent::__construct($loggedin);

            $this->db=$db;
            $this->session=$session;
            $this->pageID=$pageID;
            $this->msgText=NULL;
           
            //set the panel 1 content                        
            $this->setPanelHead_1();
            $this->setStringPanel_1();
            //set the panel 2 content
            $this->setPanelHead_2();
            $this->setStringPanel_2();
        
	}
        //setters panel 1
        public function setPanelHead_1(){
            //get the panel content                
            switch ($this->pageID) {
                case "messages":
                    $this->panelHead_1 = '<h3>Enter Message</h3>';  
                    break;
                default:
                    $this->panelHead_1 = '<h3>Enter Message</h3>';  
                    break;
            }
         }
        public function setStringPanel_1(){
            //get the panel content                
            switch ($this->pageID) {
                case "message_submit":
                    $this->stringPanel_1 = file_get_contents('forms/enterMessageForm.html');  //this reads an external form file into the string
                    if($this->newMessage()){
                        $this->stringPanel_1.='Message Submitted successfully';
                    }
                    else{
                        $this->stringPanel_1.='Message failed to submit';
                    }
                    break;
                default:
                    $this->stringPanel_1 = file_get_contents('forms/enterMessageForm.html');  //this reads an external form file into the string
                    break;
            }
         }
            
        
        //setters panel 1
        public function setPanelHead_2(){
            //get the panel HEAD content
            switch ($this->pageID){
                case "messages":
                    $this->panelHead_2='<h3>Messages</h3>';
                    break;
                default:
                    $this->panelHead_2='<h3>Messages</h3>';
                    break;
            }
            
            
        }        
        public function setStringPanel_2(){
            //get the panel content
            switch ($this->pageID){
                case "messages":
                    $this->listRecentMessages();
                    break;
                case "message_submit":
                    $this->listRecentMessages();
                    break;
                default:
                    $this->stringPanel_2='No messages to display';
                    break;
                }                
            }

        //database interaction methods
        private function newMessage(){
            //get the message from the form
           $this->msgText=$this->db->real_escape_string($_POST['msgArea']);
            
            //create the SQL insert statement for the new record
            $sql='INSERT INTO messages (sender,message) VALUES ("'.$this->session->getUserID().'","'.$this->msgText.'")';
            
            $this->sql=$sql; //for diagnostic purposes

            //execute the insert query
            if(@$this->db->query($sql)){  //execute the query and check it worked    
                return TRUE;
            } 
            else{  //insert query has not succeeded
                    return FALSE;
            }                        

        }            
        private function listRecentMessages(){
            //this method creates a string containing a HTML table of all modules
            
            //query the database
            $sql='SELECT m.datetimestamp, r.firstName, r.accountType, m.message FROM messages m,'
                    . 'registereduser r WHERE m.sender=r.userID ORDER BY msgID DESC LIMIT 0,6;';
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and iterate through the resultset
                    //iterate through the resultset to create a HTML table
                    $this->stringPanel_2= '<textarea rows="15" cols="75">';
                         
                    while ($row = $rs->fetch_assoc()) {
                        $this->stringPanel_2.='From:'.$row['firstName'].', Account:'.$row['accountType'].' ';
                        $this->stringPanel_2.=' '.$row['datetimestamp'].'&#13;&#10';
                        $this->stringPanel_2.= $row['message'].'&#13;&#10';  
                        $this->stringPanel_2.= '&#13;&#10';   //&#10; Line Feed and &#13; Carriage Return
                        }

                        $this->stringPanel_2.= '</textarea>';                   
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
           
        //public accessible getter functions
        public function getPanelHead_1(){return $this->panelHead_1;}
        public function getStringPanel_1(){return $this->stringPanel_1;}
        public function getPanelHead_2(){return $this->panelHead_2;}
        public function getStringPanel_2(){return $this->stringPanel_2;}                  
}

