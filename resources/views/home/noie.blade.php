<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Unsupported Browser</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2Y0RQWGNMN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-2Y0RQWGNMN');
    </script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

</head>
<body class="site">
    <!-- Main Content -->
    <section class="main pt-8 pt-md-11 pb-8 pb-md-12">
        <div class="container">
            <div class="row align-items-center mb-11">
                <div class="col-12 col-md-6 mb-8 mb-md-0">
                    <!-- Badge -->
                    <span class="badge badge-pill badge-danger-soft mb-3">
                        <span class="h6 text-uppercase">
                            Not Supported
                        </span>
                    </span>

                    <!-- Heading -->
                    <h2>Internet Explorer is <span class="text-danger">not supported.</span></h2>

                    <!-- Text -->
                    <p class="font-size-lg text-gray-dark mb-6">
                        Internet Explorer is going the way of the Dodo. We no longer support IE and neither should you.
                    </p>
                </div>
                <div class="col-12 col-md-6 mb-8 mb-md-0 text-center">
                    <!-- Internet Explorer Logo -->
                    <span class="fab fa-internet-explorer fa-10x text-primary"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-10 col-lg-8">
                    <!-- Badge -->
                    <span class="badge badge-pill badge-primary-soft mb-3">
                        <span class="h6 text-uppercase">
                            Download
                        </span>
                    </span>

                    <!-- Heading -->
                    <h2>Supported browsers we recommend for <span class="text-primary">download.</span></h2>

                    <!-- Text -->
                    <p class="lead text-gray-dark mb-7 mb-md-9">
                        We support all modern browsers. Here is a list of the top ones.
                    </p>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-12 col-md-3 mb-8 mb-md-0 text-center">
                    <!-- Microsoft Edge Logo -->
                    <a class="btn-social sb-outline sb-tile sb-edge mr-2 mb-2" title="Download Microsoft Edge" href="https://www.microsoft.com/en-us/edge" target="_blank" rel="noopener"><span class="sb-icon fab fa-edge"></span></a>
                </div>
                <div class="col-12 col-md-3 mb-8 mb-md-0 text-center">
                    <!-- Google Chrome Logo -->
                    <a class="btn-social sb-outline sb-tile sb-chrome mr-2 mb-2" title="Download Google Chrome" href="https://www.google.com/chrome/" target="_blank" rel="noopener"><span class="sb-icon fab fa-chrome"></span></a>
                </div>
                <div class="col-12 col-md-3 mb-8 mb-md-0 text-center">
                    <!-- Firefox Logo -->
                    <a class="btn-social sb-outline sb-tile sb-firefox mr-2 mb-2" title="Download Firefox" href="https://www.mozilla.org/en-US/firefox/new/" target="_blank" rel="noopener"><span class="sb-icon fab fa-firefox-browser"></span></a>
                </div>
                <div class="col-12 col-md-3 mb-8 mb-md-0 text-center">
                    <!-- Safari Logo -->
                    <a class="btn-social sb-outline sb-tile sb-safari mr-2 mb-2" title="Download Safari" href="https://www.apple.com/safari/" target="_blank" rel="noopener"><span class="sb-icon fab fa-safari"></span></a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
