<?php

include_once("assests/model/user.php");
include_once("assests/model/database.php");
include_once("assests/model/search.php");
include_once("assests/model/states.php");

class Controller {

    var $user;
    var $databae;
    var $search;
   
    var $pasturl ;
    

    public
    function __construct() {
     
        session_start();
        $this->user = new user();
        $this->search = new search();
        $this->database = new database();
         $this->states = new states();
   //  $this->showErrors();
    }


    public 
    function pastUrl(){
        if(isset($_SERVER['HTTP_REFERER']))
        {
            $this->pasturl =$_SERVER['HTTP_REFERER'];
            return $this->pasturl;
        }
    }



    public
    function showErrors(){

        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
    
    }

    public
    function checkifAction(){
        
         $action ;
                if(isset( $_GET['action'])){
              $action =   $_GET['action'];
                } else if(isset( $_GET['search'])){
                      
                    $action =   $_GET['search'];
                    
                }else {
                 $action = 'home';    
                }
        
        return $action;
    }
    

    public
    function invoke(){
        
        $actions = $this->checkifAction();
        
        if(isset( $_SESSION['ID'])){
            
            if ((isset( $_GET['search'])) && ($actions != '')){
             
                  $this->search->add_search();// Adds search to database
                  
                 include_once('assests/view/results.html');
                
            }
    
            else if ($actions == 'home'){
                // echo $_SESSION['ID'];
                include_once('assests/view/results.html');
                
            }
            else if($actions == 'logout')
            {
                
                $this->user->logout();
               $number_of_users =  $this->database->count_amount_of_users();
                $number_of_searches = $this->database->count_amount_of_searches();
                include_once('assests/view/signin.html');
            
            }
               else if($actions == 'settings')
            {
         
                include_once('assests/view/setting.html');
            
            }
            else if ($actions == 'getSearch_Chart'){
                
                
                $this->states->search_chart();
            }
            else if($actions == 'charts')
            {
              
            include_once('assests/view/charts.html');

            }
            else if ($actions == 'delete_account'){
                
            } 
            else if($actions == 'update_account'){

            }  else if($actions == 'search'){
                
         $this->search->add_search();
                include_once('assests/view/results.html'); 
            } 
           
                else {
           include_once('assests/view/results.html');
            }
            
        } else if ($actions == 'signin') {

            $this->user->sign_in();

        } else if($actions == 'signup'){
    
            include_once('assests/view/signup.html');
        
        }
        else if($actions == 'signinview'){
                
                  $number_of_searches = $this->database->count_amount_of_searches();
            $number_of_users =  $this->database->count_amount_of_users();
                include_once('assests/view/signin.html');
        
        } 
             else if($actions == 'search'){
                
         
                include_once('assests/view/results.html'); 
        } 
        
        
           else if($actions == 'register'){
           
              echo  $this->user->register_account();
            
            }
     
        else{
                  $number_of_searches = $this->database->count_amount_of_searches();
              $number_of_users =  $this->database->count_amount_of_users();
         
                include_once('assests/view/signin.html');
            
        }
    }
}

?>