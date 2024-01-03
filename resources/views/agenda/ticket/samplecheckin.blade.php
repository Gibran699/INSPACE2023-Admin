<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/inspace-logo.png') }}">
    <title>Success</title>
    <!-- Custom CSS -->
    <link href="{{ asset('src/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url({{ asset('src/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
            <div class="auth-box row">
                <div class="col-12">
                    <div class="bg-white">
                        <div class="p-3">
                            <div class="text-center">
                                <img src="{{ asset('images/checkicon.png') }}" alt="wrapkit" width="100">
                            </div>
                            <h2 class="mt-3 text-center">Check In Berhasil</h2>
                            <h3 class="mt-2 text-center">Atas Nama</h3>
                            <h4 class="mt-2 text-center"><b>Sample Name</b></h4>
                            <p class="text-center">Silahkan berikan gelang kepada peserta</p>
                            <p class="text-center">Jenis Tiket: <b>Silverspace Couple</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('src/assets/libs/jquery/dist/jquery.min.js') }} "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('src/assets/libs/popper.js/dist/umd/popper.min.js') }} "></script>
    <script src="{{ asset('src/assets/libs/bootstrap/dist/js/bootstrap.min.js') }} "></script>
    <script>
        $(".preloader ").fadeOut();
    </script>
</body>

</html>
