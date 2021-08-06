<!DOCTYPE html>
<html class=''>
<head>

    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700'>
    <link rel='stylesheet prefetch' href='/css/yoco/demo/demo.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

@include('yoco.demo.navbar', ['other' => 'popup'])

<div class="container">
    <div class="row text-center">
        <div class="col m-1">
            <div class="shop-yococard" style="margin: 0px 70% auto 10%;">
                <div class="mode-box">
                    <span class="yocobadge yocobadge-fail live hide">LIVE Mode</span>
                    <span class="yocobadge yocobadge-success notlive hide">Test Mode</span>
                </div>
                <div class="title">

                </div>
                <div class="desc">

                </div>
                <div style="padding: 10px">
                    <figure>
                        <img src="/img/yoco/demo/cap-3-387x346.png"/>
                    </figure>
                </div>
                <div class="cta">
                    <div class="price"></div>
                </div>
                <div id="yococard-frame">
                    <!-- Yoco Inline form will be added here -->
                </div>
                <div class="cta">
                    <!-- We don't show the pay button until the yoco form is loaded -->
                    <button id="pay-button" style="display: none" class="btn">Pay<span class="bg"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- include jquery -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>


<!-- Pre setup -->
<script>
    // Lets decide on some data
    var price = 150;
    // the currency (must be ZAR)
    var currency = 'ZAR';
    // the name at the top of the popup (either shop or product)
    var product_title = "Inline Demo: Yoco Dad Hat";
    // the description of the purchase (product or product description)
    var product_description = "Keep the sun out your face and your eyes on the prize with our dad hat. Beaches, braais and quick pops to the shops never looked so good.";
    // shop (YOUR) logo
    var shop_logo = "/img/yoco/demo/logo.png";
    // Customer Name
    var customer_name = "Joe Bloggs";
    // Customer Email
    var customer_email = "joe@test.com";
    // Metadata (optional)
    var bill_note = "INV123456";

    // change the title
    $('.shop-yococard .title').text(product_title);
    // change the description
    $('.shop-yococard .desc').text(product_description);
    // change the price
    $('.shop-yococard .price').text("R " + price);

    // What is your public key
    var public_key = '{{ config('yoco.public_key') }}';
</script>

<!-- Demo Tools -->
@include('yoco.demo.demo_tools')

<!-- Include the Yoco SDK in your web page -->
<script src="https://js.yoco.com/sdk/v1/yoco-sdk-web.js"></script>

<!-- Now the yoco sdk interactions -->
<script>

    // log to demo console, remove for production
    log_activity("Initializing Yoco SDK");
    // Initialise the Yoco SDK with your public key
    var yoco = new window.YocoSDK({
        // Add your public key here
        publicKey: public_key
    });
    // log to demo console, remove for production
    log_activity("Initialized Yoco SDK");

    // Create a new dropin form instance
    var yocoForm = yoco.inline({
        // the form layout (reference https://developer.yoco.com/online/inline/customization)
        layout: 'basic',
        // the price (IN CENTS)
        amountInCents: price * 100,
        // the currency (eg. ZAR/USD/GBP)
        currency: currency,
        // the name at the top of the popup (either shop or product)
        name: product_title,
        // the description of the purchase (product or product description)
        description: product_description,
        // the url to the shop's logo/icon
        image: shop_logo,
        // show any errors
        'showErrors': true,
        // Customer details
        'customer': {
            'name': customer_name,
            'email': customer_email
        },
        // metadata
        metadata: {
            'billNote': bill_note
        },
    });

    // You can't submit a yoco form successfully twice, so we track if it has been submitted
    var formSubmitted = false;

    // When the form is ready, lets bind the pay button
    yocoForm.on('ready', function () {
        log_activity("Yoco form loaded");

        // Bind pay button
        $('#pay-button')
            .css('display', 'unset')
            .on('click', function () {
                $('#pay-button').prop('disabled', true);
                yocoForm.createToken();
            });

        // Bind re-enabling pay button when the customer fixes their mistake
        yocoForm.on('validity_change', function () {
            if (!formSubmitted) {
                $('#pay-button').prop('disabled', false);
            }
        })
    });

    yocoForm.on('card_tokenized', function (chargeToken) {
        // log to demo console, remove for production
        log_activity("Card tokenized, passing token to backend server");

        // Pass back the token to the backend for verification
        $.ajax(
            {
                // This is the URL to your backend
                'url': '/yoco/charge',
                'method': 'POST',
                'dataType': 'json',
                'headers': {
                    // necessary for laravel's anti x-site hacking functionality
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                'data': 'token=' + chargeToken.id
                    + '&amountInCents=' + (price * 100)
                    + "&currency=" + currency
                    // optional metadata
                    + "&metadata[billNote]=" + bill_note
                    + "&metadata[customerName]=" + customer_name
                    + "&metadata[customerEmail]=" + customer_email
                ,
                'success': function (data) {
                    // log to demo console, remove for production
                    log_activity("Successfully charged " + data.currency + " " + (data.amountInCents / 100) + " with ref " + data.id);
                    formSubmitted = true;
                    // log data to console for demo
                    console.log(data);
                    // raise an notification
                    swal({
                        title: "Purchase successful",
                        text: "Your new gear is on its way!",
                        icon: "success",
                        button: "OK",
                    }).then(function () {
                        location.reload();
                    });
                },
                'error': function (result) {
                    error = result.responseJSON;
                    if (error) {
                        if (error.errors) {
                            // this is a validation error
                            // log to demo console, remove for production
                            log_activity("Failed to charge " + currency + " " + price + " : " + error.message);
                            $.each(error.errors, function (key, value) {
                                log_activity("Validation: " + key + " : " + value[0]);
                            });
                        } else if (error.charge_error) {
                            // log to demo console, remove for production
                            log_activity("Failed to charge " + currency + " " + price + " : " + error.charge_error.displayMessage);
                        } else {
                            log_activity("Failed to charge " + currency + " " + price + " : Unknown Error");
                        }
                    } else {
                        log_activity("Failed to charge " + currency + " " + price + " : Unknown Error");
                    }
                    console.log(error);
                    // Popup notification
                    swal({
                        title: "Purchase failed",
                        text: "Something went wrong and we couldn't get this for you",
                        icon: "error",
                        button: "OK",
                    });
                },
                'complete': function (result) {
                    // log to demo console, remove for production
                    log_activity("Backend server call complete");
                }
            }
        );

    });

    // this ID matches the id of the element we created earlier.
    yocoForm.mount('#yococard-frame');

</script>
</body>
</html>
