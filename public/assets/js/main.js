$(document).ready(function() {
    setTimeout(function() {
        $("div.notifications").fadeOut();
    }, 5000);

    var currentPath = window.location.pathname;
    $("a[href='" + currentPath + "']").addClass("active");
});
