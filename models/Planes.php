<?php

class Planes extends Model{
        private $panelHead_1;//String: used by the view
        private $stringPanel_1;//String: used by the view
        private $panelHead_2;
        private $stringPanel_2;
        
        private $pageID;//String: used by the view
        private $planeID; //String : aircraft ID.
        private $db; //MySQLi Class object - connection to MySQL database
        private $sql;
      
        
	//constructor
	function __construct($pageID,$loggedin,$db) 
	{   
            //class properties based on constructor arguments
            parent::__construct($loggedin);
           // $this->planeID=$planeID;
            $this->db=$db;
            $this->pageID=$pageID;
            //get the panel 1 content
            $this->setPanelHead_1();
            $this->setStringPanel_1();
            //get the panel 2 content
            $this->setPanelHead_2();
            $this->setStringPanel_2();
        
	}
        //setters panel 1
        public function setPanelHead_1(){
            //get the panel HEAD content
            switch ($this->pageID){
                case "planes":
                    $this->panelHead_1='<h3>Manage Planes</h3>';
                    break;
                case "list_all_planes":
                    $this->panelHead_1='<h3>List of Planes</h3>';
                    break;
                case "new_plane":
                    $this->panelHead_1='<h3>Add a New Plane Form</h3>';
                    break;
                case "process_new_plane":
                    $this->panelHead_1='<h3>New Plane Added - Result</h3>';
                    break;
                case "plane_query":
                    $this->panelHead_1='<h3>Plane Query</h3>';
                    break;
                default:
                    $this->panelHead_1='View Planes';
                    break;
            }
            
            
        }     
        public function setPanelHead_2(){
           // if($this->loggedin){
                switch ($this->pageID){
                 /* case "plane":
                     $this->panelHead_2='<h3>View Planes</h3>';
                        break;*/
                    case "plane_query":
                        $this->panelHead_2='<h3>Plane Query Result</h3>';
                        break;
                    case "plane_query_result":
                        $this->panelHead_2='<h3>Query Result for '.$this->planeID.'</h3>';
                        break;
                    case "plane_transcript_result":
                        $this->panelHead_2='<h3>Results Transcript for '.$this->planeID.'</h3>';
                        break;  
                    default:
                        $this->panelHead_2='<h3>Plane Query Result</h3>';
                        break;
                }
           // }
        }
                
        public function setStringPanel_1(){
            //get the panel content
           // if($this->loggedin){
                switch ($this->pageID){
                    case "planes":
                        $this->stringPanel_1='Use the links above to manage planes.';
                        break;
                    case "list_all_planes":
                        $this->listAllPlanes();
                        break;
                    case "new_plane":
                        $this->stringPanel_1 = file_get_contents('forms/planeAddForm.html');  //this reads an external form file into the string
                        break;
                    case "plane_query":
                        $this->stringPanel_1 = file_get_contents('forms/planeQueryForm.html');
                        break;   
                    case "plane_query_result":
                        $this->stringPanel_1 = file_get_contents('forms/planeQueryForm.html');  //this reads an external form file into the string  
                        break;
                    case "plane_transcript_result":
                        $this->stringPanel_1 = file_get_contents('forms/planeQueryForm.html');  //this reads an external form file into the string  
                        break;
                    case "process_new_plane":
                        //get the form data
                        $this->planeID=$this->db->real_escape_string($_POST['planeID']);             
                        $this->manufactuer=$this->db->real_escape_string($_POST['Manufacturer']);
                        $this->enteredServ=$this->db->real_escape_string($_POST['enteredService']);
                        $this->Wingspan=$this->db->real_escape_string($_POST['Wingspan']);
                        $this->topSpeed=$this->db->real_escape_string($_POST['topSpeed']);
                        $this->maxRange=$this->db->real_escape_string($_POST['maxRange']);
                        $this->usage=$this->db->real_escape_string($_POST['usage']);
                        //$this->userID=$this->db->real_escape_string($_POST['userID']);
                    
                        //add the new module to the database
                        if($this->newPlane()){
                            $this->stringPanel_1='New plane added successfully. '.$this->planeID;
                        }
                        else{
                            $this->stringPanel_1='Unable to add new plane - possible duplicate plane identifier code ('.$this->planeID.') already exists';
                        }
                        break;
                    default:
                        $this->stringPanel_1='View Planes - choose from menu options above';
                        break;
                }   
            //}
        }
        public function setStringPanel_2(){
            //if($this->loggedin){  //these page options are only available to logged in users
                switch ($this->pageID) {
                    case "plane_query":
                        $this->stringPanel_2='';
                        $this->stringPanel_2.='<p>View planes from here</p>'; 
                        break;
                    case "plane_query":
                        $this->stringPanel_2='';
                        $this->stringPanel_2.='<p>Enter a planeID in the form. Results will appear here</p>'; 
                        break;
                    case "plane_query_result":
                        $this->getPlaneByID();
                        break;
                    case "plane_transcript_result":
                        $this->getPlaneTranscriptByID();
                        break;  
                    default:
                        $this->stringPanel_2='<p>Plane Query result will appear here</p';
                        break; 
                }
            //}
        }
        private function getPlaneByID(){ //not used
            $sql='SELECT aircraftID, Manufacturer FROM aircraft WHERE aircraftID="'.$this->planeID.'"';
            $this->stringPanel_2.='';
            //check if any rows returned from query
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and check it worked and returned data    
                //iterate through the resultset to create a HTML table
                $this->stringPanel_2.= '<table class="table table-bordered">';
                $this->stringPanel_2.='<tr><th>Model</th><th>Manufacturer</th><th>Specification</th></tr>';//table headings
                while ($row = $rs->fetch_assoc()) { //fetch associative array from resultset
                        $this->stringPanel_2.='<tr>';//--start table row
                           foreach($row as $key=>$value){
                                    $this->stringPanel_2.= "<td>$value</td>";
                            }
                            //Transcript button
                            $this->stringPanel_2.= '<td>';
                            $this->stringPanel_2.= '<form action="'.$_SERVER["PHP_SELF"].'?pageID=plane_transcript_result" method="post">';
                            $this->stringPanel_2.= '<input type="submit" type="button" value="Get Specs" name="plane_transcript_result">';
                            $this->stringPanel_2.= '<input type="hidden" value="'.$this->planeID.'" name="planeID">';
                                //when the button is pressed the 
                                //aircrafttID 'hidden' value is inserted 
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
        private function getPlaneTranscriptByID(){//not used
            $sql='SELECT * FROM aircraft a WHERE a.aircraftID="'.$this->planeID.'"';
            $this->stringPanel_2='';           
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and iterate through the resultset
                    //iterate through the resultset to create a HTML table
                    $this->stringPanel_2.= '<table class="table table-bordered">';
                    $this->stringPanel_2.='<tr><th>Model</th><th>Manufacturer</th><th>Serviced</th><th>Wingspan</th><th>MaxSpeed</th><th>MaxRange</th><th>Type</th></tr>';
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
        //database interaction methods
        private function newPlane(){
            //create the SQL insert statement for the new record
            $sql='INSERT INTO `plane`.`aircraft`(`aircraftID`,`Manufacturer`,`enteredService`,`wingspan`,`topSpeed`,`maxRange`,`planeUsage`) VALUES ("'.$this->planeID.'","'.$this->manufactuer.'","'.$this->enteredServ.'","'.$this->Wingspan.'","'.$this->topSpeed.'","'.$this->maxRange.'","'.$this->usage.'")';
            $this->sql=$sql; //for diagnostic purposes
            

            //execute the insert query
            if(@$this->db->query($sql)){  //execute the query and check it worked    
                return TRUE;
            } 
            else{  //insert query has not succeeded
                    return FALSE;
            }                        
        }            
        private function listAllPlanes(){
            //this method creates a string containing a HTML table of all planes
			
            //query the database
            $sql='SELECT a.aircraftID AS Model, a.Manufacturer, a.enteredService AS Serviced, a.wingspan AS Wingspan,
                  a.topSpeed AS MaxSpeed, a.maxRange AS MaxRange, a.planeUsage AS Type FROM aircraft a ORDER BY Manufacturer';         
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){  //execute the query and iterate through the resultset
                    //iterate through the resultset to create a HTML table
                    $this->stringPanel_1= '<table class="table table-bordered">';
                    //fetch associative array from resultset
                    $i=0;
                    while ($row = $rs->fetch_assoc()) {
                        //----------HEADINGS
                        while ($i<1)
                        {   $this->stringPanel_1.= '<tr>';
                            foreach($row as $key=>$value){
                                $this->stringPanel_1.= "<th>".$key."</th>";
                            }
                            $this->stringPanel_1.= '</tr>';
                            $i++;
                        }                     
                        //----------DATA
                        $this->stringPanel_1.='<tr>';//--start table row
                           foreach($row as $key=>$value){
                                    $this->stringPanel_1.= "<td>$value</td>";
                            }
                            $this->stringPanel_1.= '</tr>';  //end table row
                        }
                    $this->stringPanel_1.= '</table>';
            }  
            else{  //resultset is empty or something else went wrong with the query
                 if (!$rs->num_rows){
                    $this->stringPanel_1.= '<br>No records have been returned - resultset is empty - Nr Rows = '.$rs->num_rows. '<br>';
                    }
                    else{
                    $this->stringPanel_1.= '<br>SQL Query has FAILED - possible problem in the SQL - check for syntax errors<br>';
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
        public function getplaneID(){return $this->planeID;}
        
}
