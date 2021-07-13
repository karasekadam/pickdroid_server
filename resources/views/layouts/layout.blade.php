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
    </head>
    <body>
        <script>
            // funkce filtru
            /*function filter() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // hides dropdown-content
            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    var i;
                    for (i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }*/

            // funkce vyhledávacího tlačíka
            function search_site() {
                name = document.getElementById("search").value
                window.location.replace("http://www.dangrb.dreamhosters.com/?search=" + name); // 
            }

            $(document).ready(function() {
                $("#menu-toggle").click(function() {
                    $("#menu").slideToggle();
                });


                $(".doToggle").click(function() {
                    value = $(this).attr("id");
                    $(".sub_"+value).slideToggle();
                });

                $("#logout_btn").click(function() {
                    $("#logout").submit();
                });

                // filter
                //let filter = document.getElementById("2");
                //$('#filter').on('keyup', search_func(search));
                // filter

                let search = document.getElementById("search");
                let search_mob = document.getElementById("search_mob");
                window.search = search; // Put the element in window so we can access it easily later
                search.autocomplete = "off"; // Disable browser autocomplete

                // ajax dotaz k searchboxu na keyup
                $('#search').on('keyup', search_func(search));
                $('#search_mob').on('keyup', search_func(search_mob)); // proč to tady je??? zakomentované search pořád funguje

                function search_func(elem) {
                    return function(e) {
                        $value=$(this).val();
                        $.ajax({
                            type : 'get',
                            url : '{{URL::to('search_match')}}',
                            data:{'search':$value},
                            success:function(data){
                                let selector = document.getElementById("selector");
                                // Check if input is empty
                                if (elem.value.trim() !== "") {
                                    elem.classList.add("dropdown"); // Add dropdown class (for the CSS border-radius)
                                    // If the selector div element does not exist, create it
                                    if (selector == null) {
                                        selector = document.createElement("div");
                                        selector.id = "selector";
                                        elem.parentNode.appendChild(selector);
                                        // Position it below the input element
                                        selector.style.left = elem.getBoundingClientRect().left + "px";
                                        selector.style.top = elem.getBoundingClientRect().bottom + "px";
                                        selector.style.width = elem.getBoundingClientRect().width + "px";
                                    }
                                    // Clear everything before new search
                                    selector.innerHTML = "";
                                    // Variable if result is empty
                                    let empty = true;
                                    for (let item in data) {
                                        // vytvoří link pro každý výsledek, který dostal od serveru
                                        let opt = document.createElement("a");
                                        opt.setAttribute("href", "http://www.dangrb.dreamhosters.com/?id=" + data[item].id + "'");
                                        str = data[item].team1 + " - " + data[item].team2;
                                        opt.innerHTML = str;
                                        selector.appendChild(opt);
                                        empty = false;
                                    }
                                    // If result is empty, display a disabled button with text
                                    if (empty == true) {
                                        let opt = document.createElement("div");
                                        opt.disabled = true;
                                        opt.innerHTML = "No results";
                                        selector.appendChild(opt);
                                    }
                                }
                                // Remove selector element if input is empty
                                else {
                                    if (selector !== null) {
                                        selector.parentNode.removeChild(selector);
                                        elem.classList.remove("dropdown");
                                    }
                                }
                            }
                        });
                    };
                }
            })

            // funkce zajišťující filter
            function content_filter(hours) {
                // vytvoří ajax dotaz
                let xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    // funkce obstarávající odpověď dotazu
                    if (this.readyState == 4 && this.status == 200) {
                        let myArr = JSON.parse(this.responseText);
                        let output = ""
                        for (let i = 0; i < myArr.length; i++) {
                            let date = myArr[i].date.split("-")
                            let match_time = new Date(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]), parseInt((myArr[i].time)) ? (myArr[i].time) : 0);
                            let now = new Date();
                            let until = new Date(now.getTime() + hours*3600000);
                            if (hours !== "0" && match_time > until) {
                                continue;
                            }
                            let format = date[2] + "." + date[1]
                            output += '<tr> <td class="date d-none d-md-table-cell align-middle pl-4"><span class="match_date">' + format + '</span><br>11:11</td>' +
                                '<td class="match d-none d-md-table-cell align-middle pt-1 pb-1"><img src="img/logo/' + myArr[i].team1 + '.png" class="web_logo" alt="logo týmu">' + myArr[i].team1 +' - <img src="img/logo/' + myArr[i].team2 + '.png" class="web_logo" alt="logo týmu">' + myArr[i].team2 +'</td>' +
                                '<td class="match d-md-none pt-1 pb-1"><img src="img/logo/' + myArr[i].team1 + '.png" class="mob_logo" alt="logo týmu">' + myArr[i].team1 +'<br><img src="img/logo/' + myArr[i].team2 + '.png" class="mob_logo" alt="logo týmu">' + myArr[i].team2 +'<br><span class="match_date">' + format +'</span>, 11:11</td>' +
                                '<td class="league d-none d-md-table-cell align-middle"><img src="img/logo/' + myArr[i].league + '.png" class="web_logo ml-3" alt="logo ligy"></td>' +
                                '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].prob1 +'<br>1.11</b></div></td>' +
                                '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].probtie +'<br>1.11</b></div></td>' +
                                '<td class="rate text-center align-md-middle"><div class="rate_pad"><b>' + myArr[i].prob2 +'<br>1.11</b></div></td></tr>'
                        }
                        if (output === "") {
                            output = "To do - chybová hláška a odkaz zpět na všechny bez načítání stránky";
                        }
                        document.getElementsByTagName("tbody")[0].innerHTML = output;
                    }
                };
                let href = window.location.href.split("/");
                let last = href[href.length - 1];
                console.log(last);
                xhttp.open("GET", "http://www.dangrb.dreamhosters.com/search_match_filter" + last, true); // smazal jsem hodiny z dotazu, snad v pohodě? www.dangrb.dreamhosters.com/search_match_filter
                xhttp.send();
            }
        </script>

        <div class="container-fluid">
            <div class="row" id="topbar_row">
                <!--
                <div class="col-md-2 col-12 sidebar text-md-center">
                    <div class="d-none d-sm-none d-md-block">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                    </div>

                    <div class="row d-md-none h-100 align-items-center">
                        <div class="col-4 d-md-none">
                            <i class="fa fa-bars fa-2x float-left" id="menu-toggle" style="color: white; size: 5px"></i>
                        </div>
                        <div class="col-3 d-md-none">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot" class="d-none d-md-block">
                                <img src="img/robot2.png" alt="logo" id="robot2" class="d-md-none" style="width: 4em">

                            </a>
                        </div>
                        <div class="col-5 d-md-none">
                            <a href="/login"><i class="fa fa-sign-in fa-3x float-right" style="color: #FF8000"></i></a>
                        </div>
                    </div>
                </div>-->

                <div class="col-md-12 d-none d-sm-none d-md-block topbar">
                    <div class="row h-100 align-items-center">
                        <div class="col-xl-2">
                            <a href="/">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-1">
                            <!--<div class="dropdown">
                                <div onclick="" class="dropdown-toggle" id="drpdwn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white; cursor: pointer;">Filter</div>
                                <div class="dropdown-menu dropdown-content" aria-labelledby="drpdwn">
                                    <button class="dropdown-item" onclick="content_filter('2')">2 hours</button>
                                    <button class="dropdown-item" onclick="content_filter('4')">4 hours</button>
                                    <button class="dropdown-item" onclick="content_filter('24')">today</button>
                                    <button class="dropdown-item" onclick="content_filter('0')">all</button>
                                </div>
                            </div>-->
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
