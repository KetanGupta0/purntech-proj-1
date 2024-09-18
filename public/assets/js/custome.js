$(document).ready(function() {
    // Get the current URL path
    var path = window.location.pathname;

    // Extract the last segment of the path
    var lastSegment = path.substring(path.lastIndexOf('/') + 1);
    var pageTitle = lastSegment.replace(/-/g, ' ').replace(/\b\w/g, function(l) { return l.toUpperCase(); });
    if(pageTitle == '' || pageTitle == undefined){
        document.title = 'Home - FISBHT';
        $('.home').addClass('active');
    }else{
        // Set the page title
        document.title = pageTitle + ' - FISBHT';
        $('.'+lastSegment).addClass('active');
        // Set the content of the #page-title div
        $('.pg-title').html(pageTitle);
        $('#pg-title-main').html(pageTitle);
        $('#pg-title-second-main').html(pageTitle.toUpperCase());
        
    }
    

});
