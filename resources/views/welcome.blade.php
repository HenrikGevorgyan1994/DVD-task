<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
            .size {
                width: 100%;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
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

            <div class="container">
                <div class="col-sm-12">
                <form action="{{ url('/api/uploadCSV')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="csv"> Upload CSV file</label>
                                <input type="file" name="csv-file" class="form-control" placeholder="csv"><br>
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </div>
                      
                </form>
                </div>
            </div>
          

            <div class="container">
            <form action="{{ url('/api/uploadProduct')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group ">
                    <div class="col-sm-4">
                        <label for="case_count"></label>
                        <input type="text" class="form-control" name="case_count" placeholder="case_count">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-4">
                        <label for="name" ></label>
                        <input type="text" class="form-control" name="name" placeholder="name">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-4">
                        <label for="description"></label>
                        <input type="text" class="form-control" name="description" placeholder="description">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-4">
                        <label for="brand"></label>
                        <input type="text" class="form-control" name="brand" placeholder="brand">
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-sm-4">
                        <label for="size" ></label>
                        <input type="text" class="form-control" name="size" placeholder="size">
                    </div>
                </div>
                <div class="col-sm-1">
                    <br>
                    <button type="button" class="btn btn-success btn-sm size" onclick="fileFunction()">+</button>
                </div>
            <div class="form-group">   
                <div class="col-sm-3">
                    <div class="myimg">
                        <label for="file"></label>
                        <input type="file" name="files[]" class="form-control" placeholder="files">
                       
                    </div>
 
                </div>
                
            </div>
            
            <div class="form-group">
                <div class="col-sm-4"><br>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
            </form>

            </div>
       
    
        <script>
        function fileFunction() {
        $('.myimg').append(" <div> <label for=\"file\"></label>" +
        " <input type=\"file\" class=\"form-control\" name=\"files[]\"  placeholder=\"files\"/></div>");
}</script>
    </body>
</html>
