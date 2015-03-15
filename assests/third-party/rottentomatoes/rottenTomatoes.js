

 
var apikey = "ezwg5jkbj8jtjy8z9bj9rrm7";
var baseUrl = "http://api.rottentomatoes.com/api/public/v1.0";

// construct the uri with our apikey
var moviesSearchUrl = baseUrl + '/movies.json?apikey=' + apikey;



  function getMovies(searchTerm, limit){
    var query = searchTerm;
  // send off the query
  console.log("called roten tomatoes"+query);

  $.ajax({
    url: moviesSearchUrl + '&q=' + encodeURI(query) + '&page_limit='+limit,
    dataType: "jsonp",
    success: searchCallback

  });
}

// callback for when we get back the results
function searchCallback(data) {
 $(document.body).append('Found ' + data.total + ' results for ');
 var movies = data.movies;
 console.log(data);
 $.each(movies, function(index, movie) {
   $(document.body).append('<h1>' + movie.title + '</h1>');
    $(document.body).append('<a href="'+movie.links.alternate+'" >'+'<img src="' + movie.posters.thumbnail + '" />'+'</a>');
 });
}



