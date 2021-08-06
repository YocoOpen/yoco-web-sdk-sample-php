<div class="slider d-lg-inline d-none">
    <div class="title">
        Demo Tools
    </div>
    <div class="tool-yococards error hide">
        <div class="title">
            Error
        </div>
        <div class="yococard">
        </div>
    </div>    
    <div class="tool-yococards cards">
        <div class="title">
            Test Cards
        </div>
        <div class="yococard live hide">
            <span class="text">Test cards are not available because you are using live keys</span>
        </div>
        <div class="yococard notlive hide">
            <span class="text">
                Click to copy, then paste into the card field.<br>
                Use any future expiry date and CVV number.
            </span>
        </div>
        <div class="yococard notlive hide">
            <span class="yocobadge yocobadge-success copy-card" style="width: 100%">
                <span style="float: left;">Success</span>
                <span style="float: right;" class="copy-text" data-copy="4111 1111 1111 1111">&nbsp;&nbsp;&nbsp;&nbsp;4111 1111 1111 1111</span>
            </span>
        </div>
        <div class="yococard notlive hide">
            <span class="yocobadge yocobadge-fail copy-card" style="width: 100%">
                <span style="float: left;">Failure</span>
                <span style="float: right;" class="copy-text" data-copy="5105 1051 0510 5100">&nbsp;&nbsp;&nbsp;&nbsp;5105 1051 0510 5100</span>
            </span>
        </div>
    </div>
    <div class="tool-yococards keys">
        <div class="title">
            KEYS
        </div>
        <div class="yococard">
            <span class="yocobadge">
                Public:<br> {{ $client->getPublicKey() }}
            </span>
        </div>
        <div class="yococard">
            <span class="yocobadge">
                Secret:<br> {{ $client->getRedactedSecretKey() }}
            </span>
        </div>        
        <div class="yococard">
            <span class="text">Keep the secret key secure on your server!</span>
        </div>
    </div>
    <div class="tool-yococards monitor">
        <div class="title">
            Activity Monitor
        </div>
        <div class="yococard">
            <textarea class="activity" rows="20" disabled></textarea>
        </div>
    </div>
</div>

<!-- Helper code for this demo -->
<script src="/js/yoco/demo/demo.js"></script>
<script src="/js/yoco/demo/sweetalert.min.js"></script>

<script>
    var errorMessages = @json($client->getKeyErrors());
    if (errorMessages.length) {
        showErrors(errorMessages);
    }

    var keyEnv = "{{ $client->keyEnvironment() }}";
    log_activity(`Using ${keyEnv} keys`);    
    enableLiveKeys(keyEnv === "live");
</script>

