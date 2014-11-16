<?php

//-------------Details---------------\\
// @Author : Robert Gabriel
// @Version : 1.0
// @Code Name : Robin Search Engine
// @Date : 8/13/2013
//-----------------------------------\\



//Needs to rebuilt


class linkscrapper{




    // -- Function Name : __construct
    // -- Params : None
    // -- Purpose : Starts Database Connection
    public
    function __construct() {
            
            $searchTerm = $_GET["search"];
            $_SESSION['views'] = $searchTerm;
                
                if (empty($searchTerm)) {
				    $searchTerm = "Projectbird";
				    $this-> Yahoo($searchTerm);
                    } else {
				        $searchTerm = str_replace(" ", "+", $searchTerm);
			             $this->Yahoo($searchTerm);
                    }   
    }


    



    
public
function getYahoo($searchTerm)
{

    

				$yahooAddress = "http://m.yahoo.com/search?q=" . $searchTerm;
				$yahoo_HTML   = file_get_contents($yahooAddress);
				//Title------------------
				preg_match('/<title>(.*)<\/title>/i', $yahoo_HTML, $title);
				$title_out = $title[1];
				// Results----------------
			preg_match('/<li><a href="(.*)">(.*)<\/a><\/li>/i', $yahoo_HTML, $links);
		
// 			$yahooResultse = str_replace('href="', 'href="http://www.google.com', $links[0]);
    


$yahooResults = "";//explode('<h3 class="r">',$yahooResultse);
			 Google($searchTerm,$yahooResults);
}

public
function Google($searchTerm,$yahooResults)
{
				$google_HTML = file_get_contents('http://www.google.ie/search?q=' . $searchTerm);
				preg_match('/<title>(.*)<\/title>/i', $google_HTML, $title4);
				$title_out4 = $title4[1];
				preg_match('/<a href="(.*)">(.*)<\/a>/i', $google_HTML, $links4);
   
				$bodytag = str_replace('href="', 'href="http://www.google.com', $links4[0]);
			
				$pieces4 = explode('<h3 class="r">', $bodytag);
 bing($searchTerm,$yahooResults,$pieces4);
		

				
}


public
function bing($searchTerm,$yahooResults,$pieces4)
{
		$bing_HTML = file_get_contents('http://m.bing.com/search?q='. $searchTerm);
		
		//<a href=
	
	//Title------------------
		preg_match('/<title>(.*)<\/title>/i', $bing_HTML, $title3);
		$title_out3 = $title3[1];
		
		preg_match('/<a href="(.*)">(.*)<\/a>/i' , $bing_HTML,$links3);
		$bodytag = str_replace('href="', 'href="http://m.bing.com', $links3[0]);
		$bodytag =  str_replace('class="ansDesc"',"",$bodytag );	
	  $bodytag = str_replace('</a>', "", $bodytag);
     
    $bodytag = str_replace('<p >', "</a><p>", $bodytag);
     $bodytag = str_replace('</p>', "</p><h4>", $bodytag);
         $bodytag = str_replace('</li>', "</h4></li>", $bodytag);
		$pieces3 = explode('<li class="ansMrgnB">', $bodytag);

    include 'Results.html';
    

    
}

    
    
    
    
    
    
    
    
    
    
    

}


?>



