$(document).ready(function () {

    $('.select2,.coulmns-select').select2({
        placeholder: "Select",
    });

    $(".select2").on('change', function () {
        let request = {
            'data': {},
            'column': {},
        };

        if (jQuery(this).val().length > 0) {
            request['column'] = jQuery(this).data('column');
        }
        let request_count = 0;
        jQuery('.select2').each(function () {
            if (jQuery(this).val().length > 0) {
                request['data'][jQuery(this).data('column')] = jQuery(this).val();
                request_count++;
            }
        });
        if (request_count > 0) {
            ajax_call(request);
        }
        else {
            $('.select2 option').removeAttr("disabled");
            // initSelect2();
        }
    });
});
function ajax_call(request) {
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {
            request
        },
        success: function (response) {
            if (response && response.length > 0) {
                const columns = JSON.parse(response);
                for (const column in columns) {
                    const data = columns[column];
                    console.log("column", column, `select#${column} option`);
                    jQuery(`select#${column} option`).each(function () {
                        const option = jQuery(this).val();
                        if (!data[option]) {
                            jQuery(this).attr("disabled", "disabled");
                        }
                        else {
                            jQuery(this).removeAttr("disabled");
                        }
                    })
                }
                // initSelect2();
            } else {
                console.log("Empty or null response received");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
}
function initSelect2() {
    jQuery(`.select2`).select2('destroy');
    jQuery('.select2').select2({
        placeholder: "Select",
    });
}