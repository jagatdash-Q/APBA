$(function() {
    $("#tblLocations").sortable({
        items: 'tr:not(tr:first-child)',
        cursor: 'pointer',
        axis: 'y',
        dropOnEmpty: false,
        start: function(e, ui) {
            ui.item.addClass("selected");
        },
        update: function(event, ui) {
            var content = $("#tblLocations").sortable("toArray");
            const base_url = $('#base_url').val();
            var fd = new FormData();
            fd.append('data', JSON.stringify(content));

            $.ajax({
                url: base_url + "/admin/menu/sort",
                contentType: false,
                processData: false,
                type: "post",
                data: fd,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log('success');
                },
                error: function(data) {
                    console.log('error');
                },
            });
        },
        stop: function(e, ui) {
            const base_url = $('#base_url').val();
            ui.item.removeClass("selected");
            $(this).find("tr").each(function(index) {
                let html =
                    ` <img src="${base_url}/assets/dashboard/images/up-down-left-right-solid.svg" height="20" width="20" alt="Image not avalible" /> ` +
                    index;

                if (index > 0) {
                    if (index != 1) {
                        $(this).find("td").eq(0).html(html);
                    }
                }
            });
        }
    });
});