<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
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
            

                $(".doToggle").click(function() {
                    value = $(this).attr("id");
                    $(".sub_"+value).slideToggle();
                });

                $("#add_match").click(function() {
                    $("#new_match").show();
                    $("#add_done").show();
                    var date = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                    var formatted = (new Date(Date.now() - date)).toISOString().slice(0, -1);
                    var remove = formatted.slice(-7);
                    var final = formatted.replace(remove, "");
                    $("#add_time").val(final);
                    $("#add_time").attr("min", final);
                });

                $("#add_done").click(function() {
                    var check = 0;
                    var prob1 = $("#prob1").val();
                    var probtie = $("#probtie").val();
                    var prob2 = $("#prob2").val();
                    if (isNaN(prob1)) {
                        $("#prob1").css("border-color", "red");
                        console.log("1")
                        check = 1;
                    }

                    if (isNaN(probtie)) {
                        $("#probtie").css("border-color", "red");
                        console.log("2")
                        check = 1;
                    }

                    if (isNaN(prob2)) {
                        $("#prob2").css("border-color", "red");
                        console.log("3")
                        check = 1;
                    }

                    if ($("#country_btn").text().trim() == 'Stát' || $("#league_btn").text().trim() == 'Liga' || $("#team_btn").text().trim() == '1. Tým' || $("#team_btn2").text().trim() == '2. Tým') {
                        console.log("4")
                        check = 1;
                    }
                    
                    if (check == 0) {
                        $("#date_hidden").val($("#add_time").val());
                        $("#prob1_hidden").val(prob1);
                        $("#probtie_hidden").val(probtie);
                        $("#prob2_hidden").val(prob2);
                        $("#form_new_match").submit();
                    }
                });

                $(".pencil_league").click(function() {
                    //$(this).parent().parent().children("p").css("display", "none");
                    $(this).parent().children("a").css("display", "none");
                    $(this).parent().children("i").css("display", "none");
                    $(this).parent().children("input").css("display", "inline");
                    $(this).parent().children("button").css("display", "inline");
                });

                $(".leag_submit").click(function() {
                    var input_value = $(this).parent().children("input[name='new_leag_input']").val();
                    if (input_value == '') {
                        $(this).prev().css("display", "none")
                        $(this).prev().prev().css("display", "inline");
                        $(this).prev().prev().prev().css("display", "inline");
                        $(this).css("display", "none");

                    } else {
                        $("#old_leag_name").val($(this).parent().parent().prev().val());
                        $("#new_leag_name").val(input_value);
                        $("#form_leag_update").submit();
                    }
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
                })

            });
        </script>

        <div class="container-fluid">
            <div class="row" id="topbar_row">
                <div class="col-md-2 col-12 sidebar text-md-center">
                    <div class="d-none d-sm-none d-md-block">
                            <a href="/admin_home">
                                <img src="img/robot2.png" alt="logo" id="robot">
                            </a>
                    </div>

                    <div class="row d-md-none h-100 align-items-center">
                        <div class="col-4 d-md-none">
                            <i class="fa fa-bars fa-2x float-left" id="menu-toggle" style="color: white; size: 5px"></i>
                        </div>
                        <div class="col-3 d-md-none">
                            <a href="/admin_home">
                                <img src="img/robot2.png" alt="logo" id="robot" class="d-none d-md-block">
                                <img src="img/robot2.png" alt="logo" id="robot2" class="d-md-none" style="width: 4em">

                            </a>
                        </div>
                        <div class="col-5 d-md-none">
                            <a href="/login"><i class="fa fa-sign-in fa-3x float-right" style="color: #FF8000"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 d-none d-sm-none d-md-block topbar">
                    <div class="row h-100 align-items-center">
                        <div class="col-xl-3 col-lg-2">
                            <button type="button" class="btn btn-dark nav-btn" id="add_match">Přidat zápas</button>
                            <button type="button" class="btn btn-dark nav-btn" id="add_done" style="display: none">Hotovo</button>
                        </div>
                        <div class="col-xl-5 col-lg-6">
                            <form class="form-inline" action="/action_page.php">
                                <div class="form-group" style="">
                                    <input type="text" class="form-control" placeholder="Search matches.." name="search" id="search" size="40">
                                    <button type="button" class="btn btn-dark" style="margin-left: 0.5em"><i class="fa fa-search"></i></button>
                                </div>

                            </form>
                        </div>

                        <div class="col-xl-4 col-lg-4">
                            {!! Form::open(['action' => 'mainControl@logout', 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-dark float-right nav-btn">Odhlásit se</button>
                            {!! Form::close() !!}
                            <a href="/admin_aboutus"><button type="button" class="btn btn-dark float-right nav-btn">About us</button></a>
                            <a href="/admin_blog"><button type="button" class="btn btn-dark float-right nav-btn">Blog</button></a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::open(['action' => 'mainControl@update_league', 'method' => 'POST', 'id' => 'form_leag_update']) !!}
            <input type="hidden" name="old_leag_name" id="old_leag_name">
            <input type="hidden" name="new_leag_name" id="new_leag_name">
            {!! Form::close() !!}
            <div class="row" style="height: 90vh">
                <div class="col-md-2 d-md-block sidebar overflow-auto" id="menu" style="padding: 0px">
                    <div id="leagues" class="mt-md-4">
                        <p class="h3 font-weight-light text-md-left" style="color: #FF8000; margin-bottom: 5%; margin-left: 2%">Top leagues</p>
                        <a href="/admin_add"><button class="btn btn-outline-light ml-1">+ Přidat ligu/tým</button></a>
                        <a href="/admin_logo"><button class="btn btn-outline-light ml-1 mt-2">+ Upravit logo</button></a>
                        @foreach($top_leagues as $league)
                            
                            <input type="hidden" value="{{$league->name_538}}">
                            <div>
                                <p class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-2">

                                    @if (is_null($league->our_name))
                                    <a href="/admin_home?league={{$league->name_538}}" style="color: white; text-decoration: none">
                                    {{$league->name_538}}
                                    </a>
                                    @else
                                        @if (is_null($league->name_538))
                                        <a href="/?league={{$league->our_name}}" style="color: white; text-decoration: none">
                                        @else
                                        <a href="/?league={{$league->name_538}}" style="color: white; text-decoration: none">
                                        @endif
                                    {{$league->our_name}}
                                    </a>
                                    @endif

                                    <i class="fa fa-pencil ml-2 pencil_league" style="color: white" value="0">
                                    </i>
                                    <input type="text" class="text_field" name="new_leag_input" style="display: none; height: 20%" size="12">
                                    <button type="button" class="btn btn-sm leag_submit" style="background-color: white; margin-bottom: 2%; display: none" value="date">Ok</button>
                                </p>
                            </div>

                            
                        @endforeach
                    </div>
                    <div style="border-bottom: 1px solid white; width: 80%; margin-left: 2%"></div>
                    <div id="countries">
                        <a href="/admin_add_country"><button class="btn btn-outline-light ml-1 mt-1">+ Přidat stát</button></a>
                        @foreach($countries as $country)
                        <div class="sidefont">
                            <p class="font-weight-light pt-2 pb-2 mt-0 mb-0 ml-2 doToggle" id="{{str_replace(' ', '', $country->country)}}">{{$country->country}}</p>
                        </div>
                            @foreach($leagues as $league)
                                @if ($league->country == $country->country)
                                <input type="hidden" value="{{$league->name_538}}">
                                <div>
                                    <p class="sub_{{str_replace(' ', '', $country->country)}} ml-3 mt-1 pt-1 pb-1" style="display: none; color: white">

                                        @if (is_null($league->our_name))
                                        <a href="/admin_home?league={{$league->name_538}}" style="text-decoration: none; color: white">
                                        {{$league->name_538}}
                                        </a>
                                        @else
                                            @if(is_null($league->name_538))
                                            <a href="/?league={{$league->our_name}}" style="text-decoration: none; color: white">
                                            @else
                                            <a href="/?league={{$league->name_538}}" style="text-decoration: none; color: white">
                                            @endif
                                        {{$league->our_name}}
                                        </a>
                                        @endif

                                    <i class="fa fa-pencil ml-2 pencil_league" style="color: white" value="0"></i>
                                    <input type="text" class="text_field" name="new_leag_input" style="display: none; height: 20%" size="12">
                                    <button type="button" class="btn btn-sm leag_submit" style="background-color: white; margin-bottom: 2%; display: none" value="date">Ok</button>
                                    </p>
                                </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="col-md-10 col-12 main" style="padding: 0px">
                    @yield("content")
                </div>
            </div>

        </div>
    </body>
</html>
