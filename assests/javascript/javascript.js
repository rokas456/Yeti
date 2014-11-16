



window.onload = function() {
    //var title = document.getElementsByTagName("title")[0].innerHTML;
    document.getElementById("menuButton").addEventListener('click', menuStyle,
        false);
  //  searchBox(title);

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

function searchBox(title) {
    if (title == "YourSear.ch") {
        var menuDiv = "s";
    } else if (title == "YourSear.ch : Images") {
        var menuDiv = document.getElementById('search');
    }
    else if (title == "YourSear.ch : Videos") {
        var menuDiv = document.getElementById('search');
    }
    var searchTerm = document.createElement('input');
    searchTerm.setAttribute('class', 'searchinput');
    searchTerm.setAttribute('id', 'searchinput');
    searchTerm.setAttribute('placeholder', 'What will you search');
    searchTerm.setAttribute('name', 'searchinput');
    menuDiv.appendChild(searchTerm);

    if (title == "YourSear.ch") {
//document.getElementById("searchinput").addEventListener('click', search,false);
    } else if (title == "YourSear.ch : Images") {
        document.getElementById("searchinput").addEventListener('click', flicker,false);
    }   else if (title == "YourSear.ch : Videos") {
        document.getElementById("searchinput").addEventListener('click', youtube,false);
    }



}





function screenSizes(){
     
    var w = window.innerWidth;  //gets users inner width of window
    var h = window.innerHeight; //gets users inner height of window
     
    // window.location.href = "assests/index.php?w=" + w +"&h=" + h; // Passes them onto the index file.
     
        


    
}
