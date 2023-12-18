$().ready(function() {
    $("form.delete").on("click", "button[type='button']", (e) => {
        let button = $(e.currentTarget);
        let id = button.data("id");
        $("#deleteConfirmationModal").data("id", id);
        $("#deleteConfirmationModal").modal("show");
    });

    $("#deleteConfirmationModal").on("click", "button", () => {
        let id = $("#deleteConfirmationModal").data("id");
        $("form.delete-" + id).submit();
    });
});
