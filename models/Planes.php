<?php

class Planes extends Model{
        private $panelHead_1;//String: used by the view
        private $stringPanel_1;//String: used by the view
       
        
        private $pageID;//String: used by the view
        //private $moduleID; //String : currently selected student ID nr.
        private $db; //MySQLi Class object - connection to MySQL database
        //private $moduleID;
        //private $moduleTitle;
        //private $credits;
        //private $lecturerID;
        private $sql;
      
        
	//constructor
	function __construct($pageID,$loggedin,$db) 
	{   
            //class properties based on constructor arguments
            parent::__construct($loggedin);
            //$this->moduleID=$moduleID;
            $this->db=$db;
            $this->pageID=$pageID;
            

            //get the panel 1 content
            $this->setPanelHead_1();
            $this->setStringPanel_1();
        
	}
        //setters panel 1
        public function setPanelHead_1(){
            //get the panel HEAD content
            switch ($this->pageID){
                case "list_all_planes":
                    $this->panelHead_1='<h3>List of Planes</h3>';
                    break;
                case "new_plane":
                    $this->panelHead_1='<h3>Add a New Plane Form</h3>';
                    break;
                /*case "edit_module":
                    $this->panelHead_1='<h3>Module Edit Form</h3>';
                    break;
                /*case "process_edit_module":
                    //get values from form
                    $this->moduleID=$_POST['moduleID'];
                    $this->moduleTitle=$_POST['moduleTitle'];
                    $this->lecturerID=$_POST['lecturerID'];
                    $this->credits=(int)$_POST['credits'];
                    $this->panelHead_1='<h3>Editing module '.$this->moduleID.'</h3>';
                    break;
               /* case "edit_module_form":
                    $this->moduleID=$_POST['moduleID'];              
                    $this->panelHead_1='<h3>Editing Module '.$this->moduleID.'</h3>';
                    break;*/
                case "process_new_plane":
                    $this->panelHead_1='<h3>New Plane Added - Result</h3>';
                    break;
                default:
                    //$this->panelHead_1='Manage Modules - choose from menu options above';
                    break;
            }
            
            
        }        
        public function setStringPanel_1(){
            //get the panel content
            switch ($this->pageID){
                case "list_all_planes":
                    $this->listAllPlanes();
                    break;
                case "new_plane":
                     $this->stringPanel_1 = file_get_contents('forms/planeAddForm.html');  //this reads an external form file into the string
                    break;
                /*case "edit_module":
                     $this->listAllModulesForEdit();
                    break;*/
               /* case "edit_module_form":
                    $this->getModuleForEditByID();
                    break;
                /*case "process_edit_module":
                    
                    if(isset($_POST['saveModuleEdits'])){
                        if($this->saveModuleEdits()){
                            $this->stringPanel_1 ='Module edits saved successfully';
                        }
                        else{
                            $this->stringPanel_1 ='Module edits NOT saved - something went wrong!!';
                        }                        
                    }
                    else{
                        $this->stringPanel_1 ='Module edits cancelled';
                    }
                    

                    
                    
                    break;*/
                case "process_new_plane":
                    //get the form data
                    //$this->moduleID=$this->db->real_escape_string($_POST['ModuleID']);             
                    //$this->moduleTitle=$this->db->real_escape_string($_POST['ModuleTitle']);
                    //$this->credits=$this->db->real_escape_string($_POST['Credits']);
                    //$this->lecturerID=$this->db->real_escape_string($_POST['LecturerID']);
                    
                    //add the new module to the database
                    if($this->newPlane()){
                     //   $this->stringPanel_1='New plane added successfully. '.$this->;
                    }
                    else{
                        //$this->stringPanel_1='Unable to add new plane - possible duplicate plane identifier code ('.$this->.') already exists';
                    }
                    break;
                default:
                    //$this->stringPanel_1='Manage Modules - choose from menu options above';
                    break;
                }                
            }

        //database interaction methods
        private function newPlane(){
            //create the SQL insert statement for the new record
            //$sql='INSERT INTO `plane`.`planes`(``,``,``,``) VALUES ("'.$this->.'","'.$this->.'","'.$this->.'","'.$this->.'")';
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
           // $sql='SELECT p.,p.,p.,., FROM planes p';         
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
       /* private function listAllModulesForEdit(){
            //this method creates a string containing a HTML table of all modules
            
            //query the database
            $sql='SELECT m.ModuleID,m.ModuleTitle FROM modules m ORDER BY m.ModuleID';         
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
                            $this->stringPanel_1.= "<th>Select</th>";
                            $this->stringPanel_1.= '</tr>';
                            $i++;
                        }
                        
                        
                        $this->stringPanel_1.='<tr>';//--start table row
                           foreach($row as $key=>$value){
                               //----------DATA
                               $this->stringPanel_1.= "<td>$value</td>";
                            }
                            
                            //--------SELECT FOR EDIT BUTTON
                            
                            $this->stringPanel_1.= '<td>';
                            $this->stringPanel_1.= '<form action="'.$_SERVER["PHP_SELF"].'?pageID=edit_module_form" method="post">';
                            $this->stringPanel_1.= '<input type="submit" type="button" value="Edit Module" name="edit_module">';
                            $this->stringPanel_1.= '<input type="hidden" value="'.$row['ModuleID'].'" name="moduleID">';
                                //when the button is pressed the 
                                //studentID 'hidden' value is inserted 
                                //into the $_POST array
                            $this->stringPanel_1.= '</form>';
                            $this->stringPanel_1.= '</td>';

                            
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
            
            
        }*/             
        /*private function getModuleForEditByID(){
            //query the database
            $sql='SELECT m.ModuleTitle,m.Credits,m.LecturerID FROM modules m WHERE m.ModuleID="'.$this->moduleID.'"';  
            $this->stringPanel_1='';
            if(($rs=$this->db->query($sql))&&($rs->num_rows)){//check if any rows returned from query
                //get the form data from the resultset
                $row=$rs->fetch_assoc();
                $this->lecturerID=$row['LecturerID'];
                $this->moduleTitle=$row['ModuleTitle'];
                $this->credits=$row['Credits'];
                
                
                //construct the edit form 
                $this->stringPanel_1.= '<form action="'.$_SERVER["PHP_SELF"].'?pageID=process_edit_module" method="post">';
                $this->stringPanel_1.= '<div class="form-group">';
                $this->stringPanel_1.= '<input type="hidden" value="'.$this->moduleID.'" name="moduleID">';
                $this->stringPanel_1.= '<label for="moduleTitle">Module Title</label><input type="text" class="form-control" value="'.$this->moduleTitle.'" name="moduleTitle" id="moduleTitle"';
                $this->stringPanel_1.= '<label for="lecturerID">Lecturer ID</label><input type="text" class="form-control" value="'.$this->lecturerID.'" name="lecturerID" id="lecturerID">';
                $this->stringPanel_1.= '<label for="credits">Credits</label><input type="text"  class="form-control" value="'.$this->credits.'" name="credits" id="credits">';
                $this->stringPanel_1.= '<input type="submit" type="button" class="btn btn-default" value="Save Edits" name="saveModuleEdits">';
                $this->stringPanel_1.= '<input type="submit" type="button" class="btn btn-default" value="Cancel Edits" name="cancelModuleEdits">';
                $this->stringPanel_1.= '</div></form>';               

            }
            else{
                 if (!$rs->num_rows){
                    $this->stringPanel_1.= '<br>No records have been returned - resultset is empty - Nr Rows = '.$rs->num_rows. '<br>';
                    }
                    else{
                    $this->stringPanel_1.= '<br>SQL Query has FAILED - possible problem in the SQL - check for syntax errors<br>';
                    }
            }
            
            //free result set memory
            $rs->free();
        }  */  
        private function savePlaneEdits(){
                        //create the SQL insert statement for the new record
                       // $sql='UPDATE plane SET  ="'.$this->.'", ='.$this->.',UserName ="'.$this->userName.'" WHERE  = "'.$this->.'"';;
                        //execute the UPDATE query
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
}