<?php

    // -- Class Name : database
    // -- Purpose : 
    // -- Created On : 
    class database{
        var $username = "root";
        var $password= "";
        var $host = "localhost";
        var $database = "yeti";
        var $con;
        

// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        public
        function __construct()   {
            $this->con=mysqli_connect($this->host,$this->username,$this->password,$this->database);
            
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

        }


// -- Function Name : __destruct
// -- Params : 
// -- Purpose : 
        public
        function __destruct(){
            mysqli_close($this->con);
        }


// -- Function Name : sign_in
// -- Params : $email,$password
// -- Purpose : To get if the user is in the database, if it does it signs me in.
        public
        function sign_in($email,$password){
            $sql_query = "SELECT `id`,`name`,`email`,`password`, `twitter` FROM `users` WHERE email ='" . $email . "' AND password ='" . $password ."'";
            return $this->runSQL($sql_query);
        }


// -- Function Name : register_account
// -- Params : $username, $email, $password
// -- Purpose : Register the user to the database
        public
        function register_account($username,$email,$password){
            $sql_query = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (
       '" . $username  ."','" . $email  ."','" . $password  ."')";
            $this->runSQL($sql_query);
        }



// -- Function Name : delete_account
// -- Params : $username,$email
// -- Purpose : Delets the user from the database
        public
        function delete_account($username,$email){
            $sql_query = "DELETE FROM users WHERE name='" . $username . "' AND email='" . $email ."'";
            $this->runSQL($sql_query);
        }


// -- Function Name : update_account
// -- Params : $password,$twitter
// -- Purpose : Update the account 
        public
        function update_account($password,$twitter){
            $sql_query = "UPDATE users SET password='" . $password   ."' ,twitter='".  $twitter .  "' WHERE id='" . $_SESSION["ID"] . "'";
            $this->runSQL($sql_query);
        }


// -- Function Name : count_amount_of_users
// -- Params : none
// -- Purpose : Returns the amount of users in the mysql.
        public
        function count_amount_of_users(){
            $sql_query = "SELECT count(id) as count FROM `users`";
            $result =$this->runSQL($sql_query);
            $count = mysqli_fetch_array($result);
            return  $count[0];
        }


// -- Function Name : check_if_account_exists
// -- Params : $email
// -- Purpose : This is is used in part for the sign in and registor , to see if the user is there or not.
        public
        function check_if_account_exists($email){
            $sql_query = "SELECT count(id)  FROM `users` where email='" . $email ."'";
            $result =   $this->runSQL($sql_query);
            $count = mysqli_fetch_array($result);
            return  $count[0];
        }


// -- Function Name : add_search
// -- Params : $searchterm, $id
// -- Purpose : Adds the serach results to database for data mining.
        public
        function add_search($searchterm, $id){
            $sql_query = " INSERT INTO `searches`(`search_term`, `userID`, `date`, `time`) VALUES ('" .$searchterm ."','". $id ."','" . date("d-m-y") . "','" .   date("h:i:sa")."')";
            $this->runSQL($sql_query);
        }


// -- Function Name : amount_of_searches
// -- Params : None
// -- Purpose : Gets the amount of searches in the database.
        public
        function amount_of_searches(){
            $sql_query = "SELECT Distinct count(date) as Number , date 
                            FROM searches 
                            GROUP BY date";
            return  $this->runSQL($sql_query);
        }


// -- Function Name : count_amount_of_searches
// -- Params : None
// -- Purpose : Count the amount of the searchs in the database form all the users
        public
        function count_amount_of_searches(){
            $sql_query = "SELECT count(id) as count FROM `searches`";
            $result =$this->runSQL($sql_query);
            $count = mysqli_fetch_array($result);
            return  $count[0];
        }


// -- Function Name : check_if_password_changed
// -- Params : $password
// -- Purpose : Valadates the password change in the database
        public
        function check_if_password_changed($password){
            $sql_query = "SELECT count(id) as count FROM `users` where password='" . $password   ."' and id='" . $_SESSION["ID"] . "'";
            $result =$this->runSQL($sql_query);
            $count = mysqli_fetch_array($result);
            return  $count[0];
        }


// -- Function Name : runSQL
// -- Params : $sql_query
// -- Purpose : Runs the mysql, nice and cleanly.
        public
        function runSQL($sql_query){
            return  mysqli_query($this->con,$sql_query);
        }

    }

    ?>