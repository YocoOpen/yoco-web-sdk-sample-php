<!DOCTYPE html>
<html class=''>
<head>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700'>
    <link rel='stylesheet prefetch' href='/css/yoco/demo/demo.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

@include('yoco.demo.navbar')

<div class="container">
    <div class="row">
        <div class="col-sm m-1">

            <div class="shop-yococard shop-yococard-1" onclick="location='/yoco/demo/popup';">
                <div class="title">
                    Popup Demo
                </div>
                <div style="padding: 10px">
                    <figure>
                        <img src="/img/yoco/demo/hoodie-387x346.png"/>
                    </figure>
                </div>
                <div class="title">
                    Yoco Hoodie
                </div>           
                <div class="cta">
                    <div class="price"></div>
                    <a href="/yoco/demo/popup" class="btn">Try it!<span class="bg"></span></a>
                </div>
            </div>
        </div>

        <div class="col-sm m-1">

        <div class="shop-yococard shop-yococard-2" onclick="location='/yoco/demo/inline';">
                <div class="title">
                    Inline Demo
                </div>
                <div style="padding: 10px">
                    <figure data-color="#000000, #23A0DB" data-title="" data-desc="">
                        <img src="/img/yoco/demo/cap-3-387x346.png"/>
                    </figure>
                </div>
                <div class="title">
                    Yoco Dad Hat
                </div>                       
                <div class="cta">
                    <div class="price"></div>
                    <a href="/yoco/demo/inline" class="btn">Try it!<span class="bg"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
