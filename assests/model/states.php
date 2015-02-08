<?php



// -- Class Name : states
// -- Purpose : 
// -- Created On :
    
    class states{

        
        var $database;


// -- Function Name : __construct
// -- Params : 
// -- Purpose : 

        public
        function __construct()   {
            
            $this->database =  new database();
        
        }

        
        
        
// -- Function Name : search_chart
// -- Params : 
// -- Purpose : 
        public
        function search_chart(){
            
            $i = 0;
            $result =   $this->database->amount_of_searches();
            while($row = mysqli_fetch_array($result)) {
                echo $row['Number']. "/" . $row['date']. "/" ;
                $i++;
            }

        }

    }

    ?>