function showErrors(message) {
    let $errortext = $('.tool-yococards.error div.yococard');
    for (const m of message) {
        $errortext.append(m+"<br>");
        log_activity("**** ERROR: " + m);
    }
    $('.tool-yococards.error').removeClass('hide');   
    $('.tool-yococards.cards').addClass('hide');
}

// change display according to live /test keys
function enableLiveKeys(enabled) {
    if(enabled) {
        $('.live').removeClass('hide');
        $('.notlive').addClass('hide');
    } else {
        $('.live').addClass('hide');
        $('.notlive').removeClass('hide');
    }
}        

// log to the activity monitor text area
function log_activity(line) {
    let $activity = $('.activity');
    let current = $activity.text() == '' ? $activity.text() : ($activity.text() + "\n");
    $activity.text(current + "- " + line);
    $activity.scrollTop($activity[0].scrollHeight);
    console.log(line);
}

// set listeners for test cards to copy to clipboard
$('.copy-card').each(function () {
    let $button = $(this);
    $button.on('click', function (e) {
        let text = $button.children('.copy-text').data('copy');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
        log_activity("Copied " + text + " to clipboard");
    })
});

// set listener for setting public key
$('input[name=public_key]')
    .val(public_key)
    .on('change', function (e) {
        // This is for demo purposes only, you wouldn't let your UI change your public key
        let public_key = $('input[name=public_key]').val();

        log_activity("Changing public key to " + public_key + ", demo only.")
        yoco = new window.YocoSDK({
            publicKey: public_key
        });

    });

