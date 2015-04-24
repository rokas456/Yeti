<?php


    include_once("database.php");
    include_once("assests/third-party/twitter/twitter.php");

    // -- Class Name : search
    // -- Purpose : 
    // -- Created On : Api Calls for twitter , google and bing.
    
    class search{

        var $database;
        var $twitter;
        var $acctKey = 'ch5yPPgveyknb+HrsD0Gow1UV5znc7ukV32Kd3WULd4';
        var $rootUri = 'https://api.datamarket.azure.com/Bing/Search';
        var $results = array();
        var $duckduckgoResults;
        var $bingSearchResultsLimit = 5;
        var $images = '';



        // -- Function Name : __construct
        // -- Params : 
        // -- Purpose :  Starts the database and the twiiter class
        public
        function __construct()   {
            $this->database =  new database();
            $this->twitter =  new twitter();
        }


        // -- Function Name : add_search
        // -- Params : 
        // -- Purpose : Creates the search and  calls the apis
        public
        function add_search(){
            $search_Term = $_POST['search_bar_input'];
            $this->bing('Web',$search_Term);
            $this->duckduckgo($search_Term);
            $this->google($search_Term);
            $this->database->add_search($search_Term,$_SESSION['ID']);
            $this->displayResults($this->results);
            
            if ($_SESSION['twitter'] === '1'){
                $this->post_twitter();
            }

        }

        // -- Function Name : post_twitter
        // -- Params : 
        // -- Purpose : Post to twitter
        public
        function post_twitter(){
            $this->twitter->postTweet($_POST['search_bar_input']);
        }



        // -- Function Name : renameKey
        // -- Params : 
        // -- Purpose : Rename the keys in the arry for search
        public
        function renameKey(){
            foreach ($this->duckduckgoResults->RelatedTopics[0] as $arr)            {
                $arr['content'] = $arr['Text'];
                unset($arr['Text']);
            }

        }

        // -- Function Name : duckduckgo
        // -- Params : $search_Term
        // -- Purpose : Search go go duck and return the results.
        public
        function duckduckgo($search_Term){
            $requestUri = "http://api.duckduckgo.com/?q='$search_Term'&format=json";
            $response = file_get_contents($requestUri, 0);
            // Decode the response. 
            $this->duckduckgoResults = json_decode($response);
            $resultStr = '';
            //  $this->renameKey();     
            $title = $this->duckduckgoResults->Heading;
            $url = $this->duckduckgoResults->RelatedTopics[0]->FirstURL;
            $text =$this->duckduckgoResults->RelatedTopics[0]->Text;
            $resultStr .= "<ul class='nav nav-tabs nav-stacked well fadeIn' ><li><h3><a href='".   $url .  "'>" . $title.   "</a></h3></li><li><h5><a href='".   $url .  "'>" .$url.   "</a></h5></li><li><p>" .  $text  .   "</p></li><li><span class='label label-warning'>DuckDuckGo</span></li></ul>" ;
            array_push( $this->results,$resultStr); // Adds the search to the array for sorting later.
            //  echo $resultStr;
        }



        // -- Function Name : google
        // -- Params : $search_Term
        // -- Purpose : Searches google results and returns it from the api
        public
        function google($search_Term){
            $query = $search_Term;
            $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".$query;
            $body = file_get_contents($url,0);
            $json = json_decode($body);
            $resultStr = '';
            for($x=0;$x<count($json->responseData->results);$x++){
                $resultStr = "<ul class='nav nav-tabs nav-stacked well fadeIn' ><li><h3><a href='".   $json->responseData->results[$x]->url .  "'>" . $json->responseData->results[$x]->title.   "</a></h3></li><li><h5><a href='".    $json->responseData->results[$x]->visibleUrl .  "'>" . $json->responseData->results[$x]->visibleUrl.   "</a></h5></li><li><p>" .  $json->responseData->results[$x]->content  .   "</p></li><li><span class='label label-success'>Google</span></li></ul>" ;
                array_push( $this->results, $resultStr );
            }

            //  echo $resultStr;
        }


        // -- Function Name : orderBy
        // -- Params : $data, $field
        // -- Purpose : 
        public
        function orderBy($data, $field)        {
            $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
            usort($data, create_function('$a,$b', $code));
            return $data;
        }


        // -- Function Name : bing
        // -- Params : $type,$search_Term
        // -- Purpose : 
        public
        function bing($type,$search_Term){
         
            // Encode the query and the single quotes that must surround it.
            $query = urlencode("'{$search_Term}'");
            // Get the selected service operation (Web or Image).
            $serviceOp = $type;
            // Construct the full URI for the query.
            $requestUri = "$this->rootUri/$serviceOp?\$format=json&Query='$query'" . "&\$top=" . $this->bingSearchResultsLimit;
            // Encode the credentials and create the stream context.
            $auth = base64_encode("$this->acctKey:$this->acctKey");
            $data = array('http' => array('request_fulluri' => true,'ignore_errors' => true,'header' => "Authorization: Basic $auth"));
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
                        $resultStr = "<ul class='nav nav-tabs nav-stacked well fadeIn' ><li><h3><a href=\"{$value->Url}\">{$value->Title}</a></h3></li><li><h5><a href=\{$value->Url}\">{$value->Title}</a></h5></li><li><p>{$value->Description}</p></li><li><span class='label label-info'>Bing</span></li></ul>" ;
                        array_push( $this->results,$resultStr);
                        break;
                    case 'ImageResult':
                        $resultStr = "<h4>{$value->Title}({$value->Width}x{$value->Height}) " . "{$value->FileSize}bytes)</h4>" . "<li><div class='col-xs-6 col-md-3'><a class='test' href=\"{$value->MediaUrl}\">" . "<img src=\"{$value->Thumbnail->MediaUrl}\"></a></div></li>";
                        array_push( $this->images,$resultStr);
                        break;
                }
            }
            // $contents = str_replace('{RESULTS}', $resultStr, $contents);
        }




        // -- Function Name : displayResults
        // -- Params : $arr
        // -- Purpose : Display the results and search it.
        public
        function displayResults($arr){
            shuffle($arr);
            foreach ($arr as &$value) {
                echo $value;
            }
        }

}

?>