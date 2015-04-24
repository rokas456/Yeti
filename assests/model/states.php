<?php
    

// -- Class Name : states
// -- Purpose : 
// -- Created On : Genortate the highcharts information from the database. in a json repsonce
    class states{
        var $database;
        public

// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        function __construct()   {
            $this->database =  new database();
        }


// -- Function Name : search_chart
// -- Params : 
// -- Purpose : Gets the amount of search from the database and displays them in highcharts
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