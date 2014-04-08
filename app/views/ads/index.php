<?php 
if (App::environment('local') == "local") {
    $base_link = "";
} else {
    $base_link = "/source_codes/php/Angular-PHP-CRUD/public";
}

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laravel Demo</title>
    

     <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

     <link href="css/media/normal-screen.css"   rel="stylesheet" />
     <link href="css/media/small-screen.css"    rel="stylesheet" media="screen and (max-width: 600px)" />
     <link href="css/media/medium-screen.css"   rel="stylesheet" media="screen and (min-width: 600px) and (max-width: 900px)" />
     <link href="css/media/big-screen.css"      rel="stylesheet" media="screen and (min-width: 900px)" />
     <link href="css/pure/base.css"             rel="stylesheet">
     <link href="css/pure/pure-style.css"       rel="stylesheet">

     <link href="http://yui.yahooapis.com/pure/0.4.2/buttons-min.css" rel="stylesheet" >
     <link href="http://yui.yahooapis.com/pure/0.4.2/tables-min.css" rel="stylesheet">
     <link href="http://yui.yahooapis.com/pure/0.4.2/forms-min.css" rel="stylesheet">

</head>


    <body>
    <div id="container">
    	<div id="nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="#/profile">Profile</a></li>
                <li><a href="#/">My Account</a></li>
                <li><a href="#/contacts">My Contacts</a></li>
                <li><a href="#/upload">Upload</a></li>
                <li><a href="/logout">Logout</a></li>
                
            </ul>
        </div><!-- end nav -->


        <div ng-app="myApp">
        	  <div id="loading">Loading...</div>
		  
		  <div  ng-view></div>


		  
  <!-- <div>Angular seed app: v<span app-version></span></div> -->


    </div><!-- end container -->
        <footer class="footer2">
            <p class="pull-right"><a href="/">Back Home</a></p>
            <p>Built as a sample application with <a href="http://documentcloud.github.com/backbone/">Angular.js</a>,
            <a href="http://laravel.com/">Laravel 4</a>,
            <a href="https://www.firebase.com/">Firebase</a>,
            and <a href="http://www.mongodb.org/">MongoDB</a> by
            <a href="http://sardor.me" target="_blank">Sardor Isakov</a>.<br>
            The source code for this application is available in <a href="#">this repository</a> on GitHub.</p>
        </footer>
    </body>
    <!--  Frameworks -->
    <script src="js/vendor/angular-file-upload-shim.js"></script>
    <script src="//code.jquery.com/jquery-1.9.1.min.js"> </script>

    <script src="http://code.angularjs.org/1.2.5/angular.min.js"> </script>
    <script src="http://code.angularjs.org/1.2.5/angular-route.min.js"> </script>
    <script src="http://code.angularjs.org/1.2.5/angular-resource.min.js"> </script>

    <!--  My Script -->
    <script src="js/vendor/angular-file-upload.js"></script>
    
    <script src="js/src/app.js"></script>
    <script src="js/src/services.js"></script>
    <script src="js/src/controllers.js"></script>
    <script src="js/src/filters.js"></script>
    <script src="js/src/directives.js"></script>
 
</html>