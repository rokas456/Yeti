<?php

include_once("assests/model/user.php");
include_once("assests/model/database.php");
include_once("assests/model/search.php");
include_once("assests/model/states.php");
include_once("assests/model/settings.php");

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
                } else if(isset( $_GET['q'])){
                      
                    $action =   $_GET['q'];
                    
                }else {
                 $action = 'home';    
                }
        
        return $action;
    }
    
public
function signinedIn($actions)
{
     switch ($actions) {
            case "home":
                include_once( WEBSITE_PATH . 'assests/view/results.html');
                break;
            case "logout":
                $this->user->logout();
                $number_of_users =  $this->database->count_amount_of_users();
                $number_of_searches = $this->database->count_amount_of_searches();
                include_once(WEBSITE_PATH . 'assests/view/signin.html');
                break;
            case "settings":
                include_once(WEBSITE_PATH . 'assests/view/setting.html');
                break;
            case 'getSearch_Chart':
                $this->states->search_chart();
                break;
            case 'charts':
                include_once(WEBSITE_PATH . 'assests/view/charts.html');
                break;
            case 'delete_account':
                $this->user->delete_account();
                $this->user->logout();
                break;
            case 'update_account':
                $this->user->update_account();
                break;
            case 'search':
                $this->search->add_search();
                include_once(WEBSITE_PATH . 'assests/view/results.html'); 
                break;
            case 'webresults':
                $this->search->bing();
                $this->search->add_search();
                break;
            default:
                $number_of_searches = $this->database->count_amount_of_searches();
                $number_of_users =  $this->database->count_amount_of_users();
                include_once(WEBSITE_PATH .'assests/view/signin.html');
        }
    
}


public 
function NotSignedIn($actions){
    
        switch ($actions) {
            case "signin":
                $this->user->sign_in();
                break;
            case 'signup':
                include_once('assests/view/signup.html');
                break;
            case 'signinview':
                $number_of_searches = $this->database->count_amount_of_searches();
                $number_of_users =  $this->database->count_amount_of_users();
                include_once(WEBSITE_PATH . 'assests/view/signin.html');
                break;
            case 'search':
                include_once('assests/view/results.html'); 
                break;
            case 'register':
                echo  $this->user->register_account();
                break;
            default:
                $number_of_searches = $this->database->count_amount_of_searches();
                $number_of_users =  $this->database->count_amount_of_users();
                include_once(WEBSITE_PATH . 'assests/view/signin.html');
            }
    
}

    public
    function invoke(){
        
        $actions = $this->checkifAction();
        
        if(isset( $_SESSION['ID'])){
       $this->signinedIn($actions);
        }else {
    $this->NotSignedIn($actions);
        }
    }
}

?>
