$(function () {
var url = '';
     
// This is for the personal Settings
$("#signin").submit(function() {

    var url =  "index.php?action=signin"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
        cache    : false,
           url: url,
           data: $("#signin").serialize(), // serializes the form's elements.
           success: function(data)
           { 
                alerts(data,'Logging you in'); //Handles log in
           }
         });
    return false; // avoid to execute the actual submit of the form.
});
    
    
    // This is for the personal Settings
$("#search_bar").submit(function() {

    var url =  "index.php?action=search"; // the script where you handle the form input.
    $.ajax({
           type: "POST",
        cache    : false,
           url: url,
           data: $("#search_bar").serialize(), // serializes the form's elements.
           success: function(data)
           { 
            $.getScript("http://localhost/yeti/assests/third-party/instagram/instagram.js", function(){
                grabImages(jQuery("#search_bar_input").val(), 10, access_parameters);
              });
            $.getScript("http://localhost/yeti/assests/third-party/rottentomatoes/rottenTomatoes.js", function(){
                getMovies(jQuery("#search_bar_input").val(), 5);
              });
           }
         });
    return false; // avoid to execute the actual submit of the form.
});
    

    
   

// This is for the personal Settings
$("#signup").submit(function() {
  var url =  "index.php?action=register"; // the script where you handle the form input.
  
    $.ajax({
           type: "POST",
        cache    : false,
           url: url,
           data: $("#signup").serialize(), // serializes the form's elements.
           success: function(data)
           {
            alerts(data,'Account created'); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
});
 


function alerts(status,message){

 $("#alert >div").remove();
    if (status == 'true'){
        var div = document.createElement("div");
        div.setAttribute("class", "alert alert-success");
		div.setAttribute("role", "alert");
        div.innerHTML = "Awesome, Hold on two seconds " + message;
		document.getElementById("alert").appendChild(div);
    setTimeout(redirect,2000);

    }else if (status == 'error') {
        var div = document.createElement("div");
			div.setAttribute("class", "alert alert-danger");
		div.setAttribute("role", "alert");
        div.innerHTML = "Oh snap something is wrong :-O";
        
		document.getElementById("alert").appendChild(div);
    }
 
}
 
    
    
    
    function redirect(){
        
        window.location ="index.php";
        
    }
    
 });


