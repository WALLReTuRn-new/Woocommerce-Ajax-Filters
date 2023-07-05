/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */
$ = jQuery;
/*start header*/
$(document).on('submit', 'form[data-toggle=\'ajax\']', function (e) {
    e.preventDefault();


    var element = this;

    var form = e.target;

    var action = $(form).attr('action');

    var ajaxscript = {ajax_url: 'admin-ajax.php'};

    // Example starter JavaScript for disabling form submissions if there are invalid fields

    if (e.originalEvent !== undefined && e.originalEvent.submitter !== undefined) {
        //  var button = e.originalEvent.submitter;
    } else {
        // var button = this.id;
    }
    var dataForm = $(form).serialize();


    var method;
    if (method === undefined) {
        method = 'post';
    }

    $.ajax({
        type: method,
        url: ajaxscript.ajax_url.replaceAll('&amp;', '&'),
        //dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        data: {
            action: action,
            data: dataForm
        },
        error: function (result) {
            alert("An error occured: " + result.status + " " + result.statusText);
        },
        beforeSend: function (result) {
            // $('#' + button).prop('disabled', true).addClass('loading');

        },
        success: function (result) {
            var forms = $('.needs-validation');
            console.log(result);
            if (!result.error) {
                $('.invalid-feedback').hide();
                // $('#' + button).prop('disabled', false).removeClass('loading');
                $('.valid-feedback').show();
                $('.valid-feedback').html('Add Succesed');
                forms.addClass('was-validated');
                 location.reload();
            } else {
                // dasdsadsasdsadas
                //var forms = $('.needs-validation');
                forms.removeClass('was-validated');
                $('.invalid-feedback').html(result.error);
                $('.invalid-feedback').show();
                $('.valid-feedback').hide();
                // $('#' + button).prop('disabled', false).removeClass('loading');
            }

        }


    });
    return false;

});

/*end header*/


$('.nav-tabs-dropdown')
        .on("click", ".nav-link:not('.active')", function (event) {
            $(this).closest('ul').removeClass("open");
        })
        .on("click", ".nav-link.active", function (event) {
            $(this).closest('ul').toggleClass("open");
        });



