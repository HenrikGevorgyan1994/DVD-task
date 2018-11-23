<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js">
        </script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
            <form action="{{ url('/api/uploadCSV')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                <input type="file" name="csv-file" class="form-control" placeholder="csv">
                <button type="submit">Save</button>
            </form>


<br>
            <form action="{{ url('/api/uploadProduct')}}" method="POST" enctype="multipart/form-data">
                @csrf
              <label for="case_count" ></label>
            <input type="text" name="case_count" placeholder="case_count">
            <label for="name" ></label>
            <input type="text" name="name" placeholder="name,">
            <label for="description" ></label>
            <input type="text" name="description" placeholder="description,">
            <label for="brand" ></label>
            <input type="text" name="brand" placeholder="brand">
            <label for="size" ></label>
            <input type="text" name="size" placeholder="size">
            <button type="button" onclick="fileFunction()">+</button>
            <div class="myimg">
                <label for="file"></label>
                <input type="file" name="files[]" class="form-control" placeholder="files">
            </div>
            <button type="submit">Save</button>
            </form>




              
            </div>
        </div>
        <script>
        function fileFunction() {
        $('.myimg').append(" <div> <label for=\"file\"></label>" +
        " <input type=\"file\" class=\"form-control\" name=\"files[]\"  placeholder=\"files\"/></div>");
}</script>
    </body>
</html>
