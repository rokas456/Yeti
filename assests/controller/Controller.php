<?php

require_once("assests/model/installModel.php");



class Controller {
    
    
    
    
    
 var $install;
  var $filename = 'assests/settings/finished.ch';
    var $home = 'assests/view/home/index.html';
    
    public
    function __construct()      {
                
        session_start();
        
        




        $this->install = new installModel();
    
    
    
        
        
        
        
        
        
        
        
        
        


    }
    
    
    
    
    
    
    
    

    public
    function invoke(){

        if(file_exists($this->filename)){
            
            include($this->home);

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

}

?>