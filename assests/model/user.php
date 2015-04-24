<?php


    include_once("database.php");
    
// -- Class Name : user
// -- Purpose : 
// -- Created On : The user account that has features like log in , create user , sessions cotnrols etc.
    class user{
        var $database;
        public

// -- Function Name : __construct
// -- Params : 
// -- Purpose :  Start the database
        function __construct()   {
            $this->database =  new database();
        }


// -- Function Name : logout
// -- Params : 
// -- Purpose : Destory the user  and log the user out. 
        public
        function logout(){
            session_unset();
            session_destroy();
        }

// -- Function Name : register_account
// -- Params : 
// -- Purpose :  Register the user and valdates the information, tos ee if there there or not.
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
// -- Purpose : Crates the session varables if the login is correct
        public
        function create_sessions($results){
            // session_start();
            $count = mysqli_num_rows($results);
            
            if($count===1){
                while($row = $results->fetch_assoc()){
                    $_SESSION["ID"] =  $row['id'];
                    $_SESSION["NAME"] =  $row['name'];
                    $_SESSION["email"] =  $row['email'];
                    $_SESSION["twitter"] =  $row['twitter'];
                    $_SESSION["password"] =  $row['password'];
                }

            }

        }



// -- Function Name : get_amount_of_users
// -- Params : 
// -- Purpose : Gets the amount of users in the database ( for the home page)
        public
        function get_amount_of_users(){
            return  $this->database->count_amount_of_users();
        }



// -- Function Name : sign_in
// -- Params : 
// -- Purpose : Sign in function to see if there their or not.
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



// -- Function Name : delete_account
// -- Params : 
// -- Purpose : Delete the account if the user requests it.
        public 
        function delete_account(){
            $email = $_SESSION["email"];
            $username = $_SESSION["NAME"];
            $this->database->delete_account($username,$email);
        }


// -- Function Name : update_account
// -- Params : 
// -- Purpose :  Update the user account wwith password etc etc.
        public
        function update_account(){
            $password = $_POST["password"];
            $twitter =  $_POST["shareT"];
            $this->database->update_account($password,$twitter);
            $wasItChanged =  $this->database->check_if_password_changed($password);
            $this->updateTwitter_Session($_POST["shareT"]);
            
            if ($wasItChanged != '1' ){
                echo 'error';
            } else {
                echo 'passwordchanged';
            }

        }

        public

// -- Function Name : updateTwitter_Session
// -- Params : $twitter
// -- Purpose :  If they change there twitter settings it updates the session varables, i e allow them to post results to twitter.
        function updateTwitter_Session($twitter){
            $_SESSION["twitter"] =  $twitter;
        }

    }

    ?>