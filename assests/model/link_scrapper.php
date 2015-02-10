<?php
	
	//-------------Details---------------\\
	// @Author : Robert Gabriel
	// @Version : 1.0
	// @Code Name : Robin Search Engine
	// @Date : 8/13/2013
	//-----------------------------------\\

	class linkscrapper{
        
        var $searchTerm = null;
        

		// -- Function Name : __construct
		// -- Params : None
		// -- Purpose : Starts Database Connection
		public
		function __construct($term) {
			
			$this->searchTerm = $term; 

		}

        
        // -- Function Name : strip_Results
		// -- Params : Search Term Url of the website
		// -- Purpose : Strips urls to get links

		public
		function strip_Results($search_url){

			$links = array();
			$linksTitles = array();

			$html = file_get_contents( $search_url . '/search?q='. $this->buildString($this->searchTerm));
			$dom = new DOMDocument();
			@$dom->loadHTML($html); // grab all the on the page
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");

			$countReults = 0;

			for ($i = 0; $i < $hrefs->length; $i++) {

				$href = $hrefs->item($i);
				$url = $href->getAttribute('href');
				$link_title = $href->nodeValue;

				//	if ($this->fliter($link_title) == 'false')
				//	{
						$links[$countReults] = $search_url . $url;
						$linksTitles[$countReults] = $link_title;
						$countReults++;
				//	}
				$i++;
			}
			return array_combine($linksTitles,$links);
		}
  
        
        // -- Function Name : google
		// -- Params : Search Term 
		// -- Purpose : Search and strips the links from google

		public
		function google(){

			$search_url = 'http://www.google.com';
			$results = 	$this->strip_Results($search_url);
			$this->displayResults($results);

		}
        
        

        public
        function fliter($result){

			$removedTerms = array("","Web","Bing","Images","Videos","More","Sign in","Bing","Next","Narrow by language","Narrow by region","Similar","Cached" ,"1","2","3","4","5",
									"Privacy and Cookies","Advertise","Help","Legal","Feedback","European Data Protection","Only English","Only from Ireland","Learn More","Only English"
									,"Narrow by language","Search","Maps","YouTube","Gmail","Translate","Blogger","Web History","Terms");

			foreach ($removedTerms  as &$value) {
				if ($result == $value ){
					echo $result . '<br>';
				} else {
				}
			}
		}
			
			


		
			

			

        
        
        
        // -- Function Name : bing
		// -- Params : Search Term 
		// -- Purpose : Search and strips the links from bing

		public
		function bing() {
            
            $search_url = 'http://www.bing.com';
			$results =  $this->strip_Results($search_url);
			$this->displayResults($results);

		}



		public 
		function displayResults($arrayResults){

			foreach($arrayResults as $linksTitles=>$links) {
     			echo "<a href='" . $links . "'>" .$linksTitles .  "</a>";
    			echo "<br>";
			}
		}



        public
        function buildString($term){
            
           return str_replace(" ","+",$term);
            
        }
     
	}

	?>