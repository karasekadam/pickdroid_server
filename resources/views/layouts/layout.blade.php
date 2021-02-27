<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/pickdroid.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <script>
            $(document).ready(function() {
                $("#menu-toggle").click(function() {
                    $("#menu").slideToggle();
                });


            });
        </script>

        <div class="container-fluid">
            <div class="row" style="height: 10vh">
                <div class="col-md-2 col-12 sidebar text-md-center">
                    <div class="d-none d-sm-none d-md-block">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                    </div>

                    <div class="row d-md-none h-100 align-items-center">
                        <div class="col-5 d-md-none">
                            <i class="fa fa-bars fa-2x float-left" id="menu-toggle" style="color: white; size: 5px"></i>
                        </div>
                        <div class="col-1 d-md-none">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                        </div>
                        <div class="col-6 d-md-none">
                            <a href="/login"><i class="fa fa-sign-in fa-3x float-right" style="color: #FF8000"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 d-none d-sm-none d-md-block topbar">
                    <div class="row h-100 align-items-center">
                        <div class="col-xl-5 col-lg-4 col-md-4 offset-lg-3 offset-md-1">
                            <form class="form-inline" action="/action_page.php" style="margin-left: 10%">
                                <div class="form-group" style="">
                                    <input type="text" class="form-control" placeholder="Search matches.." name="search" size="20">
                                    <button type="button" class="btn btn-outline-dark" style="margin-left: 0.5em"><i class="fa fa-search"></i></button>
                                </div>

                            </form>
                        </div>

                        <div class="col-xl-4 col-lg-5 col-md-7">
                            <a href="/login"><button type="button" class="btn btn-dark float-right nav-btn">Login</button></a>
                            <a href="/aboutus"><button type="button" class="btn btn-dark float-right nav-btn">About us</button></a>
                            <a href="/blog"><button type="button" class="btn btn-dark float-right nav-btn">Blog</button></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="height: 90vh">
                <div class="col-md-2 d-md-block sidebar" id="menu">
                    <div id="leagues" style="margin-top:20%">
                        <p class="h3 font-weight-light text-md-left" style="color: #FF8000; margin-bottom: 10%">Leagues</p>
                        @foreach($leagues as $league)
                            <p class="text-md-center font-weight-light sidefont">
                                <a href="/?league={{$league->league}}" style="color: white; text-decoration: none">{{$league->league}}</a>
                            </p>
                        @endforeach
                    </div>

                    <div id="countries">
                        <p class="h3 font-weight-light text-md-left" style="color: #FF8000">Countries</p>
                            <p class="text-md-center font-weight-light sidefont">
                                <a href="#" style="color: white; text-decoration: none">...</a>
                            </p>
                    </div>
                </div>

                <div class="col-md-10 col-12 main">
                    @yield("content")
                </div>
            </div>

        </div>
    </body>
</html>
