$(document).ready(function() {
    // Hide notifications after 5sec.
        setTimeout(function() {
            $("div.notifications").fadeOut();
        }, 5000);

    // Set current menu item active.
        var currentPath = window.location.pathname;
        $("a[href='" + currentPath + "']").addClass("active");

    // Handle fast edit inputs.
    // It submits form after enter pushed or focus input out.
    // Submit form only if input changed.
        $(".fastEdit").on("focusout", "input[type='text']", (event) => {
            let element = $(event.currentTarget);
            let form = element.closest("form");
            form.submit();
        });

        $(".fastEdit").submit((event) => {
            let element = $(event.currentTarget);
            let input = element.find("input[type='text']");
            if (input.data('description-origin') == input.val()) {
                event.preventDefault();
            }
        });
});

