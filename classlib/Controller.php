<?php
//generic controller class

class Controller {
	//class properties
        protected $loggedin;
	
	//constructor
	function __construct($loggedin) 
	{  
            //initialise the model
            $this->loggedin=$loggedin;
	}
        

}
