<?php


class database{


    var $username = "root";
    var $password= "";
    var $host = "localhost";
    var $database = "yeti";
    var $con;



    public
    function __construct()   {
      
        $this->con=mysqli_connect($this->host,$this->username,$this->password,$this->database);

        if (mysqli_connect_errno()) {
           
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }


    public
    function __destruct(){

        mysqli_close($this->con);
    
    }


    public
    function sign_in($email,$password){

        $sql_query = "SELECT `id`,`name`,`email`,`password` FROM `users` WHERE email ='" . $email . "' AND password ='" . $password ."'";

        return $this->runSQL($sql_query);

    }

    public
    function register_account($username,$email,$password){

       
       $sql_query = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (
       '" . $username  ."','" . $email  ."','" . $password  ."')";

           $this->runSQL($sql_query);

    }


    public
    function delete_account($username,$email){

         $sql_query = "DELETE FROM users WHERE name='" . $username . "' AND email='" . $email ."'";

         $this->runSQL($sql_query);

    }

    public
    function update_account($username,$email,$password,$id){

        $sql_query = "UPDATE users SET name='" . $username ."' AND email='" . $email ."' AND password='" . $password   ."' WHERE id='" . $id . "'";$sql_query = "UPDATE users SET name='" . $username ."' AND email='" . $email ."' AND password='" . $password   ."' WHERE id='" . $id . "'";
        $this->runSQL($sql_query);

    }


    public
    function count_amount_of_users(){
 
        $sql_query = "SELECT count(id) as count FROM `users`";
        
        $result =$this->runSQL($sql_query);
        $count = mysqli_fetch_array($result);
        return  $count[0];
    }

    public 
    function check_if_account_exists($email){
        
         $sql_query = "SELECT count(id)  FROM `users` where email='" . $email ."'";
        $result =   $this->runSQL($sql_query);
        
        $count = mysqli_fetch_array($result);
        return  $count[0];
    }

    
    
    public 
        function add_search($searchterm, $id){
  $sql_query = " INSERT INTO `searches`(`search_term`, `userID`, `date`, `time`) VALUES ('" .$searchterm ."','". $id ."','" . date("d-m-y") . "','" .   date("h:i:sa")."')";

         $this->runSQL($sql_query);

        
       
        
    }
    
    
    public 
        function amount_of_searches(){

          $sql_query = "SELECT Distinct count(date) as Number , date 
                            FROM searches 
                            GROUP BY date";
        return  $this->runSQL($sql_query);
    }

        public
    function count_amount_of_searches(){
 
        $sql_query = "SELECT count(id) as count FROM `searches`";
        
        $result =$this->runSQL($sql_query);
        $count = mysqli_fetch_array($result);
        return  $count[0];
    }
    
    
    public
    function runSQL($sql_query){

       return  mysqli_query($this->con,$sql_query);


    }

}

?>