<!DOCTYPE html>
<html>
    <head>
        <title>Exception | Error</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 25px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><b>{{$errormessage}}</b></div> <br>
                <div style="color:red;"><b><i>{{$excepterr}}</i></b></div><br><br>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();" >Back to Home</a>

                <form id="logoutform" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </body>
</html>
