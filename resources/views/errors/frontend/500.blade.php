<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>500</title>

    <style id="" media="all">
        @font-face {
            font-family: 'Montserrat';
            font-weight: 900;
            font-display: swap;
            src: url("{{ asset('src/frontend/fonts/montserrat/Montserrat-Regular.ttf') }}");
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        body {
            padding: 0;
            margin: 0
        }

        #server-error {
            position: relative;
            height: 100vh
        }

        #server-error .server-error {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%)
        }

        .server-error {
            max-width: 520px;
            width: 100%;
            line-height: 1.4;
            text-align: center
        }

        .server-error .server-error-500 {
            position: relative;
            height: 240px
        }

        .server-error .server-error-500 h1 {
            font-family: montserrat, sans-serif;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            font-size: 252px;
            font-weight: 900;
            margin: 0;
            color: #262626;
            text-transform: uppercase;
            letter-spacing: -40px;
            margin-left: -20px
        }

        .server-error .server-error-500 h1>span {
            text-shadow: -8px 0 0 #fff
        }

        .server-error .server-error-500 h3 {
            font-family: cabin, sans-serif;
            position: relative;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            color: #262626;
            margin: 0;
            letter-spacing: 3px;
            padding-left: 6px
        }

        .server-error h2 {
            font-family: cabin, sans-serif;
            font-size: 20px;
            font-weight: 400;
            text-transform: uppercase;
            color: #000;
            margin-top: 0;
            margin-bottom: 25px
        }

        @media only screen and (max-width: 767px) {
            .server-error .server-error-500 {
                height: 200px
            }

            .server-error .server-error-500 h1 {
                font-size: 200px
            }
        }

        @media only screen and (max-width: 480px) {
            .server-error .server-error-500 {
                height: 162px
            }

            .server-error .server-error-500 h1 {
                font-size: 162px;
                height: 150px;
                line-height: 162px
            }

            .server-error h2 {
                font-size: 16px
            }
        }
    </style>
    <meta name="robots" content="noindex, follow">
</head>

<body>
    <div id="server-error">
        <div class="server-error">
            <div class="server-error-500">
                <h3>Oops! Server Eror</h3>
                <h1><span>5</span><span>0</span><span>0</span></h1>
            </div>
            <h2>Mohon maaf, Sepertinya terjadi suatu kesalahan.</h2>
        </div>
    </div>
</body>

</html>
