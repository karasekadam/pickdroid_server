<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/d9da5ef095.js" crossorigin="anonymous"></script>

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
        <script type="text/javascript" src="js/layout.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row" id="topbar_row">

                <div class="col-md-12 d-none d-sm-none d-md-block topbar">
                    <div class="row h-100 align-items-center">
                        <div class="col-xl-2">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-1">
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-4">

                            <form class="form-inline" action="/action_page.php">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search matches.." id="search" name="search" size="40">
                                    <div onclick="search_site()" class="" style="margin-left: 1em; color: white; cursor: pointer;"><i class="fa fa-search"></i></div>
                                </div>

                            </form>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-7">
                            @if ($user == "")
                            <div class="float-right mt-1 mr-3" style="color: white; cursor: pointer;" data-toggle="modal" data-target="#exampleModal">Login</div>
                            @else
                            <div class="dropdown">
                              <div class="dropdown-toggle float-right" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Účet
                              </div>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="account">Přehled účtu</a>
                                {!! Form::open(['action' => 'mainControl@logout', 'method' => 'POST', 'id' => 'logout']) !!}
                                <a class="dropdown-item" id="logout_btn" style="cursor: pointer; color: black">Odhlásit se</a>
                                {!! Form::close() !!}
                              </div>
                            </div>
                            @endif
                            <a href="/login"><div class="float-right mt-1 mr-4 pr-3 pl-3 font-weight-light" style="color: black; background-color: #ffdf1b; border-radius: 2px">Register</div></a>
                            <!--
                            <a href="/blog"><button type="button" class="btn btn-dark float-right nav-btn">Blog</button></a>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center" style="height: 80%">
                            <div class="col-md-10">
                        {!! Form::open(['action' => 'mainControl@check_login', 'method' => 'POST']) !!}
                        <div class="mt-4">
                            <div class="form-group">
                                <label for="email"><b>Email</b></label>
                                <input type="text" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password"><b>Password</b></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="text-center"><button class="btn btn-lg btn-block" id="prihasit" style="color: white; background-color: black">Log in</button></div><br>
                    </div>
                    {!! Form::close() !!}
                    <a href="/google_login" style="text-decoration: none"><button class="btn btn-block" style="border: 1px solid black"><i class="fab fa-google float-left mt-1"></i>Continue with Google</button></a>
                    <!--<a href="/facebook_login" style="text-decoration: none"><button class="btn btn-info btn-block mt-2">Sign up with Facebook</button></a>-->
                </div>
            </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row" style="height: 92vh">
                <div class="col-md-2 d-md-block sidebar overflow-auto" id="menu" style="padding: 0px">
                    <div id="leagues" class="mt-md-4">
                        <form class="form-inline d-md-none">
                            <div class="form-group row pl-2">
                                <div class="col-8 pr-0">
                                <input type="text" class="form-control" placeholder="Search matches.." id="search_mob" name="search">
                                </div>
                                <div class="col-4 pl-1">
                                <div class="" style="color: white"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                        </form>

                        <p class="h6 text-md-left ml-4" style="color: #00378a; margin-bottom: 2%"><b>Top leagues</b></p>
                        @foreach($top_leagues as $league)
                        <div class="sidefont">
                            @if (is_null($league->our_name))
                            <a href="/?league={{$league->name_538}}">
                                <p class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-4">
                                    {{$league->name_538}}
                                </p>
                            </a>
                            @else
                                @if (is_null($league->name_538))
                                <a href="/?league={{$league->our_name}}">
                                @else
                                <a href="/?league={{$league->name_538}}">
                                @endif
                                <p class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-2">
                                    {{$league->our_name}}
                                </p>
                            </a>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <div id="countries" class="mt-3">
                        <p class="h6 text-md-left ml-4" style="color: #00378a"><b>All matches</b></p>
                        @foreach($countries as $country)
                        <div class="sidefont">
                            <p class="pt-2 pb-2 mt-0 mb-1 ml-4 font-weight-light doToggle" id="{{$country->country}}">{{$country->country}}</p>
                        </div>
                            @foreach($leagues as $league)
                               @if ($league->country == $country->country)
                                <div>
                                    @if (is_null($league->our_name))
                                    <a href="/?league={{$league->name_538}}" style="text-decoration: none">
                                        <p class="sub_{{$country->country}} ml-5 font-weight-light" style="display: none; color: black">
                                            {{$league->name_538}}
                                        </p>
                                    </a>
                                    @else
                                    @if(is_null($league->name_538))
                                    <a href="/?league={{$league->our_name}}">
                                    @else
                                    <a href="/?league={{$league->name_538}}">
                                    @endif
                                        <p class="sub_{{$country->country}} ml-3 mt-1 pt-1 pb-1" style="display: none; color: white">
                                            {{$league->our_name}}
                                        </p>
                                    </a>
                                    @endif
                                </div>
                                @endif

                            @endforeach


                        @endforeach
                    </div>
                </div>

                <div class="col-md-10 col-12 main" style="padding: 0px; background-color: #f7f7f7">
                    @yield("content")
                </div>
            </div>

        </div>
    </body>
</html>
