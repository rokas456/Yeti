<?php

	include_once("database.php");

// -- Class Name : search
// -- Purpose : 
// -- Created On : 
    class search{
        
        
        var $database;
        
        
        
        
        
// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        
        public
        function __construct()   {
        
            $this->database =  new database();
        
        }

        
        
// -- Function Name : add_search
// -- Params : 
// -- Purpose : 
        public
        function add_search(){
            
            $search_Term = $_POST['search_bar_input'];
            $this->database->add_search($search_Term,$_SESSION['ID']);
        
        }

    }

    ?>