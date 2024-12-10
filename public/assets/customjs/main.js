$(function () {
    $(document).ready(function () {
        $('.preloader').fadeOut('slow');
    });
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

$('.update-record').on('click', function () {
    var modalid = $(this).attr('data-modalid');
    var updateurl = $(this).attr('data-updateurl');
    $(modalid).modal('show');
    $(modalid).find('form').attr('action', updateurl);
});
// 
function SendAjaxRequestToServer(
    requestType = "GET",
    url,
    data,
    dataType = "json",
    callBack = "",
    spinner_button = '',
    submit_button = ''
) {
    // console.log(data, url, dataType);
    $.ajax({
        type: requestType,
        url: url,
        data: data,
        dataType: dataType,
        contentType: 'application/json',
        processData: false,
        contentType: false,
        beforeSend: function (response) {
            $('.preloader').show();
            if (spinner_button != '') {
                $(spinner_button).toggle();
            }
            if (submit_button != '') {
                $(submit_button).attr('disabled', true);
            }
            // $(submit_button).toggle();
        },
        success: function (response) {
            $('.preloader').hide();
            if (typeof callBack === "function") {
                callBack(response);
            } else {
                console.log("error");
            }
        },
        complete: function (data) {
            $('.preloader').hide();
            if (spinner_button != '') {
                $(spinner_button).toggle();
            }
            if (submit_button != '') {
                $(submit_button).attr('disabled', false);
            }
        },
        error: function (xhr) {
            $('.preloader').hide();
            if (submit_button != '') {
                $(submit_button).attr('disabled', false);
            }
            if (xhr.status === 422) {

                let responseJSON = JSON.parse(xhr.responseText);
                $.each(responseJSON.errors, function (key, val) {
                    toastr.error(val[0], 'Error');
                    $("#" + key).addClass('is-invalid');

                });
            } else {
                console.log(xhr);
            }
        },
    });
}

function isValidTime(time) {
    return /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/.test(time);
}

function trimText(textString, length=50) {
    
    return textString.length > length ? textString.substring(0, length) + '...' : textString;
}

function formatDate(dateString) {
    const months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];

    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
}
function formatTime(timeString) {
    // Split the time string into components
    var timeParts = timeString.split(':');
    
    // Extract hours and minutes
    var hours = timeParts[0];
    var minutes = timeParts[1];
    
    // Return the formatted time
    return hours + ':' + minutes;
}