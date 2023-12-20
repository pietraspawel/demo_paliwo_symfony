$().ready(() => {
    $("form#current-car").on("change", "select", (e) => {
        let select = $(e.currentTarget);
        let form = select.closest("form");
        form.submit();
    });

    $("#odometerTable").on("click", "tbody tr", (e) => {
        let row = $(e.currentTarget);
        let path = row.data("redirect-to");
        location.href = path;
    });

    $("#odometerTable").on("click", "tbody tr button", (e) => {
        e.stopPropagation();
        console.log("button klik");
    });
});
