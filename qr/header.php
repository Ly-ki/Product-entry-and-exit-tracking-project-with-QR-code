<!DOCTYPE html>

<html lang="tr">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Qr Kod Okuma</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="icon" type="image/x-icon" href="./assets/img/faviconGA16.png">

    <link rel="stylesheet" href="./assets/css/style.css">

    <link href="./assets/css/lightbox.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link rel="manifest" href="./manifest.json">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-title" content="groupeatlantic.com">

    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link href="./pwa/img/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <link href="./pwa/img/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <link rel="apple-touch-icon" sizes="144x144" href="./pwa/img/144x144.png">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="./pwa/img/144x144.png">

    <link rel="icon" sizes="192x192" href="./pwa/img/192x192.png">

    <link rel="icon" sizes="144x144" href="./pwa/img/144x144.png">

    <script type="text/javascript" src="./assets/js/qrcode.js"></script>

    <script>

        if ('serviceWorker' in navigator) {

            window.addEventListener('load', function() {

                navigator.serviceWorker.register('./sw.js?v=7');

            });

        }

    </script>

    <script src="./assets/js/instascan.min.js"></script>

</head>



<body>

    <div class="container">

        <div id="offline" class="alert alert-danger" role="alert">

            İnternet Bağlantısı Yok!!!

        </div>

    </div>