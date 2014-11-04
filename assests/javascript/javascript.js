$(document).ready(function() {

    $( ".orRegister" ).click(function() {
     switchBetween();
    });
    
     $( ".orSign" ).click(function() {
switchBack();
    });
    

    	function switchBetween()
		{
			$("#logIn").slideUp('slow', function(){
			$("#register").slideDown('slow');});
		}
		function switchBack()
		{
			$("#register").slideUp('slow', function(){
			$("#logIn").slideDown('slow');});
		}





});



/*








$(document).ready(function(){
 
  
    // imgReplace();
    //moveOn();
         
});
 
 
function imgReplace(){ // Replaces images with newer ones.
  var oldSrc = 'http://example.com/smith.gif';
var newSrc = 'http://assets2.ignimgs.com/2014/08/01/rszguardians-of-the-galaxy-photos-concept-art-fulljpg-8ddbc1_160w.jpg';
$('img').attr('src', newSrc);
     
}
 
 
function moveOn(){
     
        var w = window.innerWidth;  //gets users inner width of window
        var h = window.innerHeight; //gets users inner height of window
     
    // window.location.href = "assests/index.php?w=" + w +"&h=" + h; // Passes them onto the index file.
     
        
}





*/




