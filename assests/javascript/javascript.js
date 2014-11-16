window.onload = function() {

	document.getElementById("menuButton").addEventListener('click', menuStyle,
		false);

};

function menuStyle() {
	var id = $("ul#menu li:first").get(0).id;
	if (id == "menuButton") {
		$("#menuButton").attr('id', 'menuButtona');
		$(".menuItem").attr('class', 'menuItema');
	} else {
		$("#menuButtona").attr('id', 'menuButton');
		$(".menuItema").attr('class', 'menuItem');
	}
}


function screenSizes(){
     
    var w = window.innerWidth;  //gets users inner width of window
    var h = window.innerHeight; //gets users inner height of window
     
    // window.location.href = "assests/index.php?w=" + w +"&h=" + h; // Passes them onto the index file.
     
        


    
}
