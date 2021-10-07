require('./bootstrap');
$( document ).ajaxError(function( event, jqxhr, settings, thrownError ) {
    alert("Session expired. You'll be take to the login page");
    location.href = "/login"; 
});