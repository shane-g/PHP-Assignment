<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class SessionTest {
    //put your code here
    private $session;
    
    public function __construct($session){
        $this->session=&$session;
        echo '<br>SessionTest CLASS CONSTRUCTOR<br>';
    }
    
    public function setSession($loggedin){
        return '<br>SessionTest Class call to SESSION class: '.$this->session->setLoggedIn($loggedin);
    }
    
   public function getSession(){
       return $this->session->getLoggedIn();
   }
}