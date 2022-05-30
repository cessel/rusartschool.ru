/* global jQuery*/
$=jQuery;
var body = $('body');
$(document).ready(function(){

    var form = $('.js--rusartform');
    if(form.length > 0){
        form.on('submit',function (e) {
            e.preventDefault();
            let formData = $(this).serializeArray();

            get_ajax_data($('.js-ccf-result'),'send_rus_art_forms',formData)


            console.log(formData);
        });
    }
    body.on('send_rus_art_forms',function (e) {
        form[0].reset();
    });



    console.log('CCF Misc.js: Init!')
});

function get_ajax_data(result_block,action,send_data) {


    if (!(body.hasClass('loading'))) {
        body.addClass('loading');

        var spinner = "<i class='icon-spin icon-2x animate-spin'></i>";
        var url = ccf_vars.myajaxurl;
        result_block.html(spinner);
        var nonce = result_block.data('nonce');
        var data = {'action': action, '_ajax_nonce': nonce,'data':send_data};
        console.log(data);
        jQuery.post(url, data, function (result_json) {
            body.removeClass('loading');
            // var result_json = JSON.parse(result);
            if (result_json.status === 0) {
                result_block.html(result_json.html);
                body.trigger(action);
            }
            else {
                console.log(result_json);
                result_block.html(result_json.error);
            }
        });
    }
}