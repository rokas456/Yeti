<?php

	include_once("database.php");
    include_once("assests/third-party/twitter/twitter.php");
// -- Class Name : search
// -- Purpose : 
// -- Created On : 
    class search{
        
        
        var $database;
        var $twitter;
        var $acctKey = 'ch5yPPgveyknb+HrsD0Gow1UV5znc7ukV32Kd3WULd4';
        var $rootUri = 'https://api.datamarket.azure.com/Bing/Search';

        
        
        
// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        
        public
        function __construct()   {
        
            $this->database =  new database();
            $this->twitter =  new twitter();
        }

        
        
// -- Function Name : add_search
// -- Params : 
// -- Purpose : 
        public
        function add_search(){
            
            $search_Term = $_POST['search_bar_input'];
            $this->bing($search_Term);
            $this->duckduckgo($search_Term);
            $this->google($search_Term);
            $this->database->add_search($search_Term,$_SESSION['ID']);

            if ($_SESSION['twitter'] === '1'){

                    $this->post_twitter();
            }
            
        }


        public
        function post_twitter(){

            $this->twitter->postTweet($_POST['search_bar_input']);

        }


        public 
        function duckduckgo($search_Term){
            $requestUri = "http://api.duckduckgo.com/?q='$search_Term'&format=json";

            $response = file_get_contents($requestUri, 0);

            // Decode the response. 
            $jsonObj = json_decode($response); 
            $resultStr = ''; 
     
                $title = $jsonObj->Heading;
                $url = $jsonObj->RelatedTopics[0]->FirstURL;
               $text =$jsonObj->RelatedTopics[0]->Text;
       
                        $resultStr .= "<ul class='nav nav-tabs nav-stacked well' ><li><h3><a href='".   $url .  "'>" . $title.   "</a></h3></li><li><h5><a href='".   $url .  "'>" .$url.   "</a></h5></li><li><p>" .  $text  .   "</p></li><li><span class='label label-warning'>DuckDuckGo</span></li></ul>" ; 
 
          
            echo $resultStr;

        }



        public
        function google($search_Term){

            $query = $search_Term;
            $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".$query;

            $body = file_get_contents($url,0);
            $json = json_decode($body);
    $resultStr = '';
            for($x=0;$x<count($json->responseData->results);$x++){
            

                $resultStr .= "<ul class='nav nav-tabs nav-stacked well' ><li><h3><a href='".   $json->responseData->results[$x]->url .  "'>" . $json->responseData->results[$x]->title.   "</a></h3></li><li><h5><a href='".    $json->responseData->results[$x]->visibleUrl .  "'>" . $json->responseData->results[$x]->visibleUrl.   "</a></h5></li><li><p>" .  $json->responseData->results[$x]->content  .   "</p></li><li><span class='label label-success'>Google</span></li></ul>" ; 
 
     

            }

            echo $resultStr;

        }






        public
        function bing(){

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
            $jsonObj = json_decode($response); 
            $resultStr = ''; 
            // Parse each result according to its metadata type. 
            foreach($jsonObj->d->results as $value) { 

                switch ($value->__metadata->type) { 
                    case 'WebResult': 
                        $resultStr .= "<ul class='nav nav-tabs nav-stacked well' ><li><h3><a href=\"{$value->Url}\">{$value->Title}</a></h3></li><li><h5><a href=\{$value->Url}\">{$value->Title}</a></h5></li><li><p>{$value->Description} </p></li><li><span class='label label-info'>Bing</span></li></ul>" ; 
                        break; 
                    case 'ImageResult':
                        $resultStr .= "<h4>{$value->Title} ({$value->Width}x{$value->Height}) " . "{$value->FileSize} bytes)</h4>" . "<a href=\"{$value->MediaUrl}\">" . "<img src=\"{$value->Thumbnail->MediaUrl}\"></a><br />"; 
                        break; 
                    } 
                } 

            // Substitute the results placeholder. Ready to go. 
           // $contents = str_replace('{RESULTS}', $resultStr, $contents);

          

         echo $resultStr;

        }


    }

    ?>