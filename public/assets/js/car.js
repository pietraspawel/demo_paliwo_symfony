$().ready(function() {
    $("form.delete").on("click", "button[type='button']", (e) => {
        let button = $(e.currentTarget);
        let id = button.data("id");
        let description = button.data("description");
        $("#deleteConfirmationModal").data("id", id);
        $("#deleteConfirmationModal").find("span.carName").text(description);
        $("#deleteConfirmationModal").modal("show");
    });

    $("#deleteConfirmationModal").on("click", "button[type='submit']", () => {
        let id = $("#deleteConfirmationModal").data("id");
        $("form.delete-" + id).submit();
    });
});
