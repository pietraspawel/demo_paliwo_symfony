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

    $("#odometerTable").on("click", "button[type='button']", (e) => {
        e.stopPropagation();
        let button = $(e.currentTarget);
        let id = button.data("id");
        $("#deleteConfirmationModal").data("id", id);
        $("#deleteConfirmationModal").modal("show");
    });

    $("#deleteConfirmationModal").on("click", "button[type='submit']", () => {
        let id = $("#deleteConfirmationModal").data("id");
        $("form.delete-" + id).submit();
    });
});
