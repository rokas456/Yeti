<?php

    // -- Class Name : crab
    // -- Purpose : 
    // -- Created On : 
	class imageScrapper {
        var  $link; //Link from user to search
        var  $matchess;	// not sure
        var $srcs;		//Image srcs
        var $imageTypes;	// Image types

// -- Function Name : load
// -- Params : $links
// -- Purpose : 
        function load($link) {
//       $link = "http://www.reddit.com/";

            $this->link = $link; // Stores the link to the varable above
         
        }

        

// -- Function Name : stripUrl
// -- Params : $url
// -- Purpose : 
        function stripUrl(){
            $host = parse_url( $this->link, PHP_URL_HOST); // Parses the url for use the name : example.com
            echo "http://".$host . "<br>";	// displays it for testing
        }

        

// -- Function Name : getHTML_Contents
// -- Params : $url
// -- Purpose : 
        function getHTML_Contents(){
            
            $contents = file_get_contents( $this->link); // Gets content from the users requested url
            $frst_image = preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $contents, $matches ); // Parises the images from the html content
            $this->matchess = $matches; // Stores all the images to the local varabile.
            
        }

        

// -- Function Name : stripSrc
// -- Params : $matches
// -- Purpose : 
        function stripSrc(){
            $matches = $this->matchess; // Gets the varablies
            $count = count($matches[0]); // Counts the amount of images in the page
            $srcs[] = "";
            for($x = 0; $x<= $count-1; $x++){
                $html5 = $matches[0][$x];
                preg_match( '@src="([^"]+)"@' ,  $html5, $match );
                // Provides: <body text='black'>
				$src = array_pop($match);
                $src= str_replace("//","",$src);
                // will return /images/image.jpg
                echo "<br>" . $x ." : " . $src . "<br>";
                $this->srcs[$x] = $src;
            }
          
        }

        function imageTypes(){
            
             $srcs = $this->srcs; 
            $count2 = count($srcs);
            for($r=0;$r<= $count2-1;$r++ ){
                
                 $this->imageTypes[$r] = substr($this->srcs[$r], -3);
                
            }
            
            
        }
        

// -- Function Name : saveImage
// -- Params : $srcs
// -- Purpose : 
        function saveImage(){
            $srcs = $this->srcs; 
            $count2 = count($srcs);
            for($r=0;$r<= $count2-1;$r++ ){
                echo $srcs[$r];
                $ch = curl_init($srcs[$r]);
                $fp = fopen('assests/img/' . $r ."." . $this->imageTypes[$r], 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fp);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_exec($ch);
                curl_close($ch);
                fclose($fp);
            }

        }

    }

    ?>
