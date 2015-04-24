<?php

	// Include twitteroauth
    require_once('twitteroauth.php');

// -- Class Name : twitter
// -- Purpose : 
// -- Created On : 
    class twitter{
        // Set keys
        var $consumerKey = 'vvdRfcES0cpVCvYk87NIZMsGA';
        var $consumerSecret = '6lzLTwTCPXxvTRpSGyVN98sdd6HSky1u9bnL7cdWxAld0G3PQF';
        var $accessToken = '2920146003-9ooOcZwkLh36iSBkmk6l5yzwflBmqegNZDkeTxV';
        var $accessTokenSecret = 'Hejl9KaRSZJOLUpmWfvSDjgNqIQp9CwA5ImmlZZNzHN4W';
        var $message = '';


// -- Function Name : __construct
// -- Params : 
// -- Purpose : 
        public
        function __construct() {
        }



// -- Function Name : postTweet
// -- Params : $message
// -- Purpose :  Posts to twitter
        public
        function postTweet($message){
            // Create object
            $tweet = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
            // Set status message
            $tweetMessage = '"' . $message . '" was just searched using Yeti #yetisearch';
            // Check for 140 characters
            
            if(strlen($tweetMessage) <= 140)                {
                // Post the status message
                $tweet->post('statuses/update', array('status' => $tweetMessage));
            }

        }

    }

    ?>