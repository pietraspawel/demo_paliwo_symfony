$().ready(function() {
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
    // If new value isn't in range(min, max) restore origin value.
        $(".fastEdit").on("click", ".valueSpan", (event) => {
            let valueSpan = $(event.currentTarget);
            let form = valueSpan.closest("form");
            let input = form.find("input[type='text']");
            valueSpan.addClass("d-none");
            input.removeClass("d-none");
            input.focus();
            input.select();
        })

        $(".fastEdit").on("focusout", "input[type='text']", (event) => {
            let input = $(event.currentTarget);
            let form = input.closest("form");
            let valueSpan = form.find(".valueSpan");
            input.addClass("d-none");
            valueSpan.removeClass("d-none");
            form.submit();
        });

        $(".fastEdit").submit((event) => {
            event.preventDefault();

            let form = $(event.currentTarget);
            let input = form.find("input[type='text']");
            let valueSpan = form.find(".valueSpan");
            let waitSpan = form.find(".waitSpan");

            if (input.data('origin') == input.val()) {
                input.addClass("d-none");
                valueSpan.removeClass("d-none");
            } else if (input.data('min') !== undefined && countUtfString(input.val()) < input.data('min')) {
                input.val(input.data('origin'));
            } else if (input.data('max') !== undefined && countUtfString(input.val()) > input.data('max')) {
                input.val(input.data('origin'));
            } else {
                let dataToSend = {
                    id: input.data('id'),
                    description: input.val(),
                    _token: form.find("input[name='_token']").val(),
                }
                input.addClass("d-none");
                valueSpan.addClass("d-none");
                waitSpan.removeClass("d-none");
                $.ajax({
                    url: '/car/edit',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(dataToSend),
                    success: function(response) {
                        valueSpan.text(dataToSend['description']);
                        input.val(dataToSend['description']);
                        input.data('origin', dataToSend['description']);
                        valueSpan.removeClass("d-none");
                        waitSpan.addClass("d-none");
                    },
                    error: function(error) {
                        // console.error('Błąd podczas edycji:', error);
                        // console.error('Response text:', error.responseText);
                        // console.log(dataToSend);
                    }
                });
            }
        });
});

function countUtfString(string) {
    let characterArray = Array.from(string);
    return characterArray.length;
}
