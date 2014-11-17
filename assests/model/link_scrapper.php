<?php

//-------------Details---------------\\
// @Author : Robert Gabriel
// @Version : 1.0
// @Code Name : Robin Search Engine
// @Date : 8/13/2013
//-----------------------------------\\



//Needs to rebuilt


class linkscrapper{



    var $titles = array();
    var $links = array();
    var $linksTitles = array();
    var $searchEngines = array('','','');
    var $searchTerm = '';





    // -- Function Name : __construct
    // -- Params : None
    // -- Purpose : Starts Database Connection
    public
    function __construct($term) {
            
        ///    $searchTerm = $_GET["search"];
     echo   $this->searchTerm = $term;
    }



    public
    function google($term){




        $html = file_get_contents('http://www.google.ie/search?q=' .    $term );

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
            }else{

                $this->links[$r] = 'http://www.google.com' . $url;
                $this->linksTitles[$r] = $link_title;
                $r++;

            }




        }
    }

    public
    function getGoogleLinks(){


        $max = sizeof($this->titles);


        for ($q= 0; $q<= $max-1; $q++){

            echo "<a href='" . $this->links[$q]  . "'>" .$this->linksTitles[$q]  .  "</a>";
            echo '<br>';
        }


    }

    

    
    
    
    
    
    
    
    
    
    
    

}


?>



