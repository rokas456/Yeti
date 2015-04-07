$(function() {
//picture();

  var url = '';
  // This is for the personal Settings
  $("#signin").submit(function() {
    var url = "index.php?action=signin"; // the script where you handle the form input.
    $.ajax({
      type: "POST",
      cache: false,
      url: url,
      data: $("#signin").serialize(), // serializes the form's elements.
      success: function(data) {
        alerts(data, 'Logging you in'); //Handles log in
      }
    });
    return false; // avoid to execute the actual submit of the form.
  });



  // This is for the personal Settings
  $("#search_bar").submit(function() {
    var url = "index.php?action=webresults"; // the script where you handle the form input.
    $.ajax({
      type: "POST",
      cache: false,
      url: url,
      data: $("#search_bar").serialize(), // serializes the form's elements.
      success: function(data) {
        console.log(data);
        myFunction(data);
        $.getScript(
          "http://localhost/yeti/assests/third-party/instagram/instagram.js",
          function() {
            grabImages(jQuery("#search_bar_input").val(), 4,
              access_parameters);
          });
      }
    });
    return false; // avoid to execute the actual submit of the form.
  });



  // This is for the personal Settings
  $("#search_bar2").submit(function() {
    alert('test');
    var url = "index.php?q=" + jQuery("#search_bar_input").val(); // the script where you handle the form input.
    window.location = url;
    return false; // avoid to execute the actual submit of the form.
  });


  // This is for the personal Settings
  $("#signup").submit(function() {
    var url = "index.php?action=register"; // the script where you handle the form input.
    $.ajax({
      type: "POST",
      cache: false,
      url: url,
      data: $("#signup").serialize(), // serializes the form's elements.
      success: function(data) {
        alerts(data, 'Account created'); // show response from the php script.
      }
    });
    return false; // avoid to execute the actual submit of the form.
  });



  // This is for the personal Settings
  $("#delete_account").submit(function() {
    var url = "index.php?action=delete_account"; // the script where you handle the form input.
    $.ajax({
      type: "POST",
      cache: false,
      url: url,
      data: $("#delete_account").serialize(), // serializes the form's elements.
      success: function(data) {
        redirect();
      }
    });
    return false; // avoid to execute the actual submit of the form.
  });


  // This is for the personal Settings
  $("#update_account").submit(function() {
    var url = "index.php?action=update_account"; // the script where you handle the form input.
    $.ajax({
      type: "POST",
      cache: false,
      url: url,
      data: $("#update_account").serialize(), // serializes the form's elements.
      success: function(data) {
        alerts(data, 'Settings Changed '); // show response from the php script.
      }
    });
    return false; // avoid to execute the actual submit of the form.
  });


  function alerts(status, message) {
    $("#alert >div").remove();
    if (status == 'true') {
      var div = document.createElement("div");
      div.setAttribute("class", "alert alert-success");
      div.setAttribute("role", "alert");
      div.innerHTML = "Awesome, Hold on two seconds " + message;
      document.getElementById("alert").appendChild(div);
      setTimeout(redirect, 2000);
    } else if (status == 'error') {
      var div = document.createElement("div");
      div.setAttribute("class", "alert alert-danger");
      div.setAttribute("role", "alert");
      div.innerHTML = "Oh snap something is wrong ";
      document.getElementById("alert").appendChild(div);
    } else if (status == 'passwordchanged') {
      var div = document.createElement("div");
      div.setAttribute("class", "alert alert-success");
      div.setAttribute("role", "alert");
      div.innerHTML = "Password Change Successful";
      document.getElementById("alert").appendChild(div);
    }
  }


  function picture(){

    document.getElementById("webresults").innerHTML = "<div id='searchEmpty' ><img src='assests/img/search.png' alt='The Image' width='128' height='128' /> <h1>No Searches :(</h1></div>";

  }

  function myFunction(data) {
    document.getElementById("webresults").innerHTML = data;
  }


  function redirect() {
    window.location = "index.php";
  }
});