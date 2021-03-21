<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/pickdroid.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- styly k odkazům v dropdownu -->
</head>

<body>
<script>
    $(document).ready(function() {
        $("#menu-toggle").click(function() {
            $("#menu").slideToggle();
        });


        $(".doToggle").click(function() {
            value = $(this).attr("id");
            $(".sub_"+value).slideToggle();
        });

    let search = document.getElementById("search");
    window.search = search; // Put the element in window so we can access it easily later
    search.autocomplete = "off"; // Disable browser autocomplete
    // ajax dotaz k searchboxu na keyup
    $('#search').on('keyup',function(){
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '{{URL::to('search_match')}}',
            data:{'search':$value},
            success:function(data){
                let elem = search;
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
                        opt.setAttribute("href", "http://127.0.0.1:8002/?id=" + data[item].id + "'")
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
    })

    });
</script>

<div class="container-fluid">
    <div class="row" id="topbar_row">
        <div class="col-md-2 col-12 sidebar text-md-center">
            <div class="d-none d-sm-none d-md-block">
                <a href="/">
                    <img src="{{ URL::asset('img/robot2.png') }}" alt="logo" id="robot">
                </a>
            </div>

            <div class="row d-md-none h-100 align-items-center">
                <div class="col-4 d-md-none">
                    <i class="fa fa-bars fa-2x float-left" id="menu-toggle" style="color: white; size: 5px"></i>
                </div>
                <div class="col-3 d-md-none">
                    <a href="/">
                        <img src="{{ URL::asset('img/robot2.png') }}" alt="logo" id="robot" class="d-none d-md-block">
                        <img src="{{ URL::asset('img/robot2.png') }}" alt="logo" id="robot2" class="d-md-none" style="width: 4em">

                    </a>
                </div>
                <div class="col-5 d-md-none">
                    <a href="/login"><i class="fa fa-sign-in fa-3x float-right" style="color: #FF8000"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-10 d-none d-sm-none d-md-block topbar">
            <div class="row h-100 align-items-center">
                <div class="col-xl-5 col-lg-4 col-md-4 offset-lg-2 offset-md-1">
                    <form class="form-inline" action="/action_page.php" style="margin-left: 10%">
                        <div class="form-group" style="">
                            <input type="text" class="form-control" placeholder="Search matches.." id="search" name="search" size="40">
                            <button type="button" class="btn btn-dark" style="margin-left: 0.5em"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-7">
                    <a href="/login"><button type="button" class="btn btn-dark float-right nav-btn">Login</button></a>
                    <a href="/aboutus"><button type="button" class="btn btn-dark float-right nav-btn">About us</button></a>
                    <a href="/blog"><button type="button" class="btn btn-dark float-right nav-btn">Blog</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="height: 90vh">
        <div class="col-md-2 d-md-block sidebar overflow-auto" id="menu" style="padding: 0px">
            <div id="leagues" class="mt-md-4">
                <p class="h3 font-weight-light text-md-left" style="color: #FF8000; margin-bottom: 2%; margin-left: 2%">Top leagues</p>
                @foreach($leagues as $league)
                    <div class="sidefont">
                        <a href="/?league={{$league->name_538}}">
                            <p class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-2">
                                {{$league->name_538}}
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>
            <div style="border-bottom: 1px solid white; width: 80%; margin-left: 2%"></div>
            <div id="countries">
                @foreach($countries as $country)
                    <div class="sidefont">
                        <p onclick="" class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-2 doToggle" id="{{$country->country}}">{{$country->country}}</p>
                    </div>
                    @foreach($leagues as $league)

                        @if ($league->country == $country->country)
                            <div class="sidefont">
                                <a href="/?league={{$league->name_538}}">
                                    <p class="sub_{{$country->country}} ml-3 mt-1 pt-1 pb-1" style="display: none; color: white">
                                        {{$league->name_538}}
                                    </p>
                                </a>
                            </div>
                        @endif

                    @endforeach


                @endforeach
            </div>
        </div>

        <div class="col-md-10 col-12 main" style="padding: 0px">
            <div id="wrap" style="height: 90vh; overflow-y: auto; overflow-x: hidden">
                <table class="table">
                    <thead class="thead-light h-50">
                    <tr>
                        <th class="date align-middle d-none d-md-table-cell font-weight-light h4"
                            style="width: 7%">Date</th>
                        <th class="match align-middle p-2 pl-2 p-md-3 font-weight-light h4" style="width: 31%">Match</th>
                        <th class="league align-middle d-none d-sm-table-cell font-weight-light h4" style="width: 5%">Leag.</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">1</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">X</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">2</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    // nastaví search box
    
</script>
</body>
</html>

