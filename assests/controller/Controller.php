<?php

require_once("assests/model/installModel.php");
require_once("assests/model/database.php");
require_once("assests/model/image_compression.php");
require_once("assests/model/image_scraper.php");
require_once("assests/model/link_scrapper.php");
require_once("assests/model/twitter/twitter.php");



class Controller {
    
    
    var $install;
      var $twitter;
    var $link_Scrapper;
    var $filename = 'assests/settings/finished.ch';
    var $home = 'assests/view/home/index.html';
    
    
    
    
    
    
    public
    function __construct()      {
                
        session_start();

        $this->install = new installModel();
        $this->twitter = new twitter();
    
    }
    
    
    
    
    
    
    
    

    public
    function invoke(){

        if(file_exists($this->filename)){ //If the install file  is here welcome to home page.
      // $this->link_Scrapper = new linkscrapper('term');

            
               if(isset($_GET['search'])){
                   
                   $term = $_POST["search"];
                             $this->link_Scrapper = new linkscrapper($term);
                         echo $this->link_Scrapper->google($term);
                                echo $this->link_Scrapper->bing($term);
                             echo $this->twitter->postTweet($term);
                          
                              include('assests/view/result/index.php');
                            }else{
            
            include($this->home);
               }

        } else {

            if(isset($_GET['second'])){

                include('assests/view/install/2.html');

                }else if(isset($_GET['third'])){

                    $this->install->cookies();

                    include('assests/view/install/3.html');
                    }
                        else if(isset($_GET['finished'])){

                             $this->install->createDatabase();
                        }
                            else{
                                include('assests/view/install/1.html');
                            }
        }

    }
    
    
    
    public
        function uninstall(){
        
     unlink($this->filename);   
    }
    
    
    
    
    public
    function image_Scraper(){
        
        $link = "http://imgur.com/r/buffy";
        
//        $link = $_GET['website'];

            $strip = new image_Scraper();        // Starts new crab instance
            $strip->load($link);        // Saves the link from user
            $strip->stripUrl();         // Starts to strip the url
            $strip->getHTML_Contents(); //Gets the html contents of the requested url
            $strip->stripSrc();         // Gets all images from the url
            $strip->imageTypes();       // saves the images types 
            $strip->saveImage();        // Saves the images locally to the folder
        
}   
        
        
    
    public 
    function image_Compression(){ //Function for resizing the images to user screen
        
        
    
    $ImagesDirectory= 'assests/img/';   //Orgallioal img location
    $DestImagesDirectory = 'assests/finished/'; //Finished image location

    //$clientWidth = htmlspecialchars($_GET["w"]);  //  gets user width of screen
    //$clientHeight = htmlspecialchars($_GET["h"]); // gets user height or screen

    if($dir = opendir($ImagesDirectory)){   //Checks if the file is there in the folder
    while(($file = readdir($dir))!== false){    //Loop though the folder for each image
        
        $imagePath = $ImagesDirectory.$file;        //Gets file orginal location
        $destPath = $DestImagesDirectory.$file;     //Gets the file to save to
        $checkValidImage = @getimagesize($imagePath); // Checks the image patch is there and gets size
        
        if(file_exists($imagePath) && $checkValidImage) //Continue only if 2 given parameters are true
        {
  
            $image = new SimpleImage();             //Starts new yeti Image
            $image->load( $ImagesDirectory.$file);  // Loads the image location
            $image->scale(80);                      // Scales it to 80 percent
       // $image->resize($clientWidth,$clientHeight);  //Resizes the images to the users screen size.
            $image->save($DestImagesDirectory.$file); // Saves the file 
         
        }
    }    
}
}    
        
        
        
        

    
    

}

?>