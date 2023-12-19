$().ready(() => {
    $("form#current-car").on("change", "select", (e) => {
        let select = $(e.currentTarget);
        let form = select.closest("form");
        form.submit();
    });

    $("button#add").click(() => {
        $("#addModal").modal("show");
    });
});
