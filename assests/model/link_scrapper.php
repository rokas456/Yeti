<?php
	//-------------Details---------------\\
	// @Author : Robert Gabriel
	// @Version : 1.0
	// @Code Name : Robin Search Engine
	// @Date : 8/13/2013
	//-----------------------------------\\



	class linkscrapper{
        
        
		var     $titles = array();
		var     $links = array();
		var     $linksTitles = array();
		var     $titlesBing2 = array();
		var     $linksBing2 = array();
		var     $linksTitlesBing2 = array();
        
        
        
        
		// -- Function Name : __construct
		// -- Params : None
		// -- Purpose : Starts Database Connection
		public
		function __construct($term) {
			//Add search term to     
			$this->searchTerm = $term;
		}

        
        
        
        
        // -- Function Name : google
		// -- Params : Search Term 
		// -- Purpose : Search and strips the links from google
        
		public
		function google($term){
			$max = sizeof($this->titles);
			$html = file_get_contents('http://www.google.ie/search?q=' . $this->buildString($term));
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			// grab all the on the page
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");
			$r = 0;
			for ($i = 31; $i < $hrefs->length-29;  $i++) {
				$href = $hrefs->item($i);
				$url = $href->getAttribute('href');
				$link_title = $href->nodeValue;
				
				if(($link_title == 'Cached' )|| ($link_title  == 'Similar')){
				} else {
					$this->links[$r] = 'http://www.google.com' . $url;
					$this->linksTitles[$r] = $link_title;
					$r++;
				}

			}

			$max = sizeof($this->linksTitles);
			$max = sizeof($this->links);
			for ($q= 0; $q<= $max-1; $q++){
				echo "<a href='" . $this->links[$q]  . "'>" .$this->linksTitles[$q]  .  "</a>";
				echo '<br>';
			}

		}
        
        
        
        
        // -- Function Name : bing
		// -- Params : Search Term 
		// -- Purpose : Search and strips the links from bing

		public
		function bing($term)        {
            
            
			$html = file_get_contents('http://www.bing.com/search?q=' . $this->buildString($term));
			$dom = new DOMDocument();
			@$dom->loadHTML($html);
			// grab all the on the page
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");
            
            
			$r = 0;
			for ($i = 5; $i < $hrefs->length-11;  $i++) {
				$href = $hrefs->item($i);
				$url = $href->getAttribute('href');
				$link_title = $href->nodeValue;
				
				if(($link_title == '1' ) ||($link_title == '2' ) ||($link_title == '3' ) || ($link_title == '4' ) ||($link_title  == '5')){
				} else {
					$this->linksBing2[$r] = 'http://www.bing.com' . $url;
					$this->linksTitlesBing2[$r] = $link_title;
					$r++;
				}

			}

			$max = sizeof( $this->linksTitlesBing2);
			$max = sizeof( $this->linksBing2);
			for ($q2= 5; $q2<= $max-1; $q2++){
				echo "<a href='" .  $this->linksBing2[$q2]  . "'>" . $this->linksTitlesBing2[$q2]  .  "</a>";
				echo '<br>';
			}

		}
        
        
        public
        function buildString($term){
            
           return str_replace(" ","+",$term);
            
        }
        

	}

	?>