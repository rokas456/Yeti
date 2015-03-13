<?php

	include_once("database.php");

// -- Class Name : search
// -- Purpose : 
// -- Created On : 
    class search{
        
        
        var $database;
        var $acctKey = 'ch5yPPgveyknb+HrsD0Gow1UV5znc7ukV32Kd3WULd4';
        var $rootUri = 'https://api.datamarket.azure.com/Bing/Search';

        
        
        
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
            $this->bing($search_Term);
            $this->database->add_search($search_Term,$_SESSION['ID']);
        }


        public
        function bing(){

         //   $contents = file_get_contents('index.html');
            echo $search_Term = $_POST['search_bar_input'];
            // Encode the query and the single quotes that must surround it.
            $query = urlencode("'{$_POST['search_bar_input']}'");

            // Get the selected service operation (Web or Image).
            $serviceOp = 'Web';

            // Construct the full URI for the query.
            $requestUri = "$this->rootUri/$serviceOp?\$format=json&Query='$query'";


            // Encode the credentials and create the stream context.

            $auth = base64_encode("$this->acctKey:$this->acctKey");

            $data = array(

            'http' => array(

            'request_fulluri' => true,

            // ignore_errors can help debug – remove for production. This option added in PHP 5.2.10

            'ignore_errors' => true,

            'header' => "Authorization: Basic $auth")

            );

            $context = stream_context_create($data);

            // Get the response from Bing.

            $response = file_get_contents($requestUri, 0, $context);

            // Decode the response. 
            $jsonObj = json_decode($response); $resultStr = ''; 
            // Parse each result according to its metadata type. 
            foreach($jsonObj->d->results as $value) { switch ($value->__metadata->type) { case 'WebResult': $resultStr .= "<a href=\"{$value->Url}\">{$value->Title}</a><p>{$value->Description}</p>"; break; case 'ImageResult': $resultStr .= "<h4>{$value->Title} ({$value->Width}x{$value->Height}) " . "{$value->FileSize} bytes)</h4>" . "<a href=\"{$value->MediaUrl}\">" . "<img src=\"{$value->Thumbnail->MediaUrl}\"></a><br />"; break; } } 
            // Substitute the results placeholder. Ready to go. 
           // $contents = str_replace('{RESULTS}', $resultStr, $contents);

           echo $response;

          //  echo $resultStr;

        }


    }

    ?>