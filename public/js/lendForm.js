$(function () {
    $(".timeGroup").click(function () {
        $(".timeGroup").prop('checked', false);
        $(this).prop('checked', true);
        if ($(this).val() == 'custom') {
            $("#customTimeGroup").slideDown();
            $("#customTimeGroup input").prop('disabled', false);
            if ($('#customTimeGroup input:checked').length == 0)
                $("#customTimeGroup input:first").prop('checked', true);
        } else {
            $("#customTimeGroup").slideUp();
            $("#customTimeGroup input").prop('disabled', true);
        }
    });
    $("#writeExample").click(function () {
        $("#writeExampleModal").modal('toggle');
    });
    $('#customTimeGroup input').click(function () {
        if ($('#customTimeGroup input:checked').length == 0)
            $(this).prop('checked', true);
    });
})