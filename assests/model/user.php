<?php


	include_once("database.php");

// -- Class Name : user
// -- Purpose : 
// -- Created On : 

    class user{
      
        var $database;
      

// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        public
        function __construct()   {
            $this->database =  new database();
        }

       

// -- Function Name : logout
// -- Params : 
// -- Purpose : 
        public
        function logout(){
            session_unset();
            session_destroy();
        }

        
        
// -- Function Name : register_account
// -- Params : 
// -- Purpose :         
        public
        function register_account(){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $is_it_there =$this->database->check_if_account_exists($email);
            
            if ($is_it_there != '0' ){
                return 'error';
            } else {
                $before = $this->database->count_amount_of_users();
                $this->database->register_account($username,$email,$password);
                $after = $this->database->count_amount_of_users();
                
                if(($before + 1) == $after){
                    return 'true';
                } else {
                    return 'error';
                }

            }

        }

      

// -- Function Name : create_sessions
// -- Params : $results
// -- Purpose : 
        public
        function create_sessions($results){
            // session_start();
            $count = mysqli_num_rows($results);
            
            if($count==1){
                while($row = $results->fetch_assoc()){
                    $_SESSION["ID"] =  $row['id'];
                    $_SESSION["NAME"] =  $row['name'];
                    $_SESSION["email"] =  $row['email'];
                    
                }

            }

        }

        

// -- Function Name : get_amount_of_users
// -- Params : 
// -- Purpose : 
        public
        function get_amount_of_users(){
            return  $this->database->count_amount_of_users();
        }

    

// -- Function Name : sign_in
// -- Params : 
// -- Purpose : 
        public
        function sign_in(){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $results =   $this->database->sign_in($email,$password);
            $count = mysqli_num_rows($results);
            
            if ( $count != '1'){
                echo 'error';
            } else
            if( $count == '1'){
                echo 'true';
                $this->create_sessions($results);
            }

        }

public
        function delete_account(){
            $email = $_SESSION["email"];
              $this->database->delete_account($email);

    }
}
    ?>