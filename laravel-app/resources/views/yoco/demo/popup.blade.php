<!DOCTYPE html>
<html class=''>
<head>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700'>
    <link rel='stylesheet prefetch' href='/css/yoco/demo/demo.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body style="overflow:auto;">

@include('yoco.demo.navbar', ['other' => 'inline'])

<div class="container">
    <div class="row text-center">
        <div class="col-sm m-1">
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
                        <img src="/img/yoco/demo/hoodie-387x346.png"/>
                    </figure>
                </div>
                <div class="cta">
                    <div class="price"></div>
                    <button id="pay" class="btn" style="display: none">Buy<span class="bg"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- include jquery -->
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

<script>
     // Lets decide on some data
     var price = 200;
    // the currency (must be ZAR)
    var currency = 'ZAR';
    // the name at the top of the popup (either shop or product)
    var product_title = "Popup Demo: Yoco Hoodie";
    // the description of the purchase (product or product description)
    var product_description = "Less is more with our signature hoodie. The box-fit style is always Insta-ready, with a 100% cotton weave that keeps you warm and cosy.";
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

    // Trigger this code when your button is clicked
    $('#pay')
        .css('display', 'unset')
        .on('click', function () {
            // log to demo console, remove for production
            log_activity("Showing Yoco Card Popup");
            // Show the Yoco Popup
            yoco.showPopup({
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
                // Customer details
                'customer': {
                    'name': customer_name,
                    'email': customer_email
                },
                // metadata
                metadata: {
                    'billNote': bill_note
                },
                callback: function (chargeToken) {
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
                }
            });

        });
</script>


</body>
</html>
