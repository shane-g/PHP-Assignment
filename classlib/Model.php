<?php
//generic model class

class Model {
	//class properties
        protected $loggedin;
	
	//constructor
	function __construct($loggedin) 
	{  
            //initialise the model
            $this->loggedin=$loggedin;
	}

        public function getLoggedin(){return $this->loggedin;} 
}

