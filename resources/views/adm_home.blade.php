@extends("layouts.admin_layout")
    @section("content")

    <script>
        
        $(document).ready(function() {
            document.getElementById("wrap").addEventListener("scroll", function(){
           var translate = "translateY(-1px)";
           this.querySelector("thead").style.transform = translate;
            });

            var date = document.getElementsByClassName("match_date");
            for (var x = 0; x < date.length; x++) {
                var spl = date[x].innerText.split("-");
                var result = spl[2] + "." + spl[1];
                date[x].innerText = result;
            }

            $(".pencil").click(function() {
                var pencil_num = $(this).attr("value");
            	$(this).parent().children(".text_field:eq(" + pencil_num + ")").css("display", "inline");
            	$(this).parent().children("span:eq(" + pencil_num + ")").css("display", "none");
                $(this).parent().children("b:eq(" + pencil_num + ")").css("display", "none");
            	$(this).parent().children("i:eq(" + pencil_num + ")").css("display", "none");
            	$(this).parent().children("button:eq(" + pencil_num + ")").css("display", "inline");
            });

            $(".ok").click(function() {
                var column = $(this).attr("value");
                var input_value = $(this).parent().children("input[name='" + column + "']").val();

                if (input_value == '') {
                    $(this).prev().css("display", "inline")
                    $(this).prev().prev().css("display", "none");
                    $(this).prev().prev().prev().css("display", "inline");
                    $(this).css("display", "none");

                } else if ((column == "prob1" || column == "prob2" || column == "probtie") && (isNaN(parseInt(input_value))))  {
                    $(this).parent().children("input[name='" + column + "']").css("border-color", "red");

                } else {
                var id = $(this).parent().parent().children("input").val();
                $("#update_column").val(column);
                $("#update_id").val(id);
                $("#update_" + column).val(input_value);
                $("#form_update_match").submit();
                }  
            });

            $(".dr-country").click(function() {
                if ($("#country-list").children().length == 0) {
                    $.ajax({
                    type : 'get',
                    url : '{{URL::to('find_countries')}}',
                    success:function(data){
                        for (var a = 0; a < data.length; a++) {
                            $("#country-list").append("<p class='drop_item'>" + data[a].country + "</p>");
                            }
                        }
                    });
                }
            });
            
            $("#country-list").on("click", "p", country_list);

            function country_list() {
                var value = $(this).text();
                $("#country_hidden").attr("value", value);
                $("#country_btn").text(value);
                $("#league_btn").prop("disabled", false);
                if ($("#league-list").children().length != 0) {
                    $("#league-list").children("p").each(function() {
                        $(this).remove();
                    });
                }
                $.ajax({
                    type : 'get',
                    url : '{{URL::to('find_leagues')}}',
                    data:{'country': value},
                    success:function(data){
                        for (var a = 0; a < data.length; a++) {
                            $("#league-list").append("<p class='drop_item'>" + data[a].name_538 + "</p>");
                            }
                        }
                    });
            }
            
            $("#league-list").on("click", "p", league_list);

            function league_list() {
                var value = $(this).text();
                var add = $(this).parent().parent().children("button").attr("value");
                $("#league_hidden").attr("value", value);
                $("#league_btn").text(value);
                $("#team_btn").prop("disabled", false);
                $("#team_btn2").prop("disabled", false);
                if ($("#team-list").children().length != 0) {
                    $("#team-list").children("p").each(function() {
                        $(this).remove();
                    });
                }

                if ($("#team-list2").children().length != 0) {
                    $("#team-list2").children("p").each(function() {
                        $(this).remove();
                    });
                }

                $.ajax({
                    type : 'get',
                    url : '{{URL::to('find_teams')}}',
                    data:{'league': value},
                    success:function(data){
                        for (var a = 0; a < data.length; a++) {
                            $("#team-list").append("<p class='drop_item'>" + data[a] + "</p>");
                            $("#team-list2").append("<p class='drop_item'>" + data[a] + "</p>");
                            }
                        }
                    });
            }

            $("#team-list").on("click", "p", team_list);
            $("#team-list2").on("click", "p", team_list);

            function team_list() {
                var value = $(this).text();
                var add = $(this).parent().parent().children("button").attr("value");
                $("#team_hidden" + add).attr("value", value);
                $("#team_btn" + add).text(value);
            }

     });

    </script>

        <div id="wrap" style="height: 90vh; overflow-y: auto; overflow-x: hidden">
            <table class="table">
                <thead class="thead-light h-50">
                    <tr>
                        <th class="date align-middle d-none d-md-table-cell" style="width: 10%"><p class="font-weight-light h4">Datum</p></th>
                        <th class="match align-middle" style="width: 31%"><p class="font-weight-light h4">Zápas</p></th>
                        <th class="league align-middle d-none d-sm-table-cell" style="width: 5%"><p class="font-weight-light h4">Liga</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">1</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">X</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">2</p></th>
                    </tr>
                </thead>
                <tbody>
                
                {!! Form::open(['action' => 'mainControl@new_match', 'method' => 'POST', 'id' => 'form_new_match']) !!}
                <input type="hidden" name="date" id="date_hidden">
                <input type="hidden" name="country" id="country_hidden">
                <input type="hidden" name="league" id="league_hidden">
                <input type="hidden" name="team" id="team_hidden">
                <input type="hidden" name="team2" id="team_hidden2">
                {!! Form::close() !!}

                    <tr style="display: none" id="new_match">
                        <td class="date d-none d-md-table-cell align-middle pl-4">
                                    <input type="datetime-local" id="add_time" class="text_field" style="height: 20%">
                                </td>

                                
                                <td class="match d-none d-md-table-cell align-middle" colspan="2">
                                    <div class="dropdown d-inline">
                                        <button type="button" id="country_btn" class="btn btn-sm btn-outline-dark dropdown-toggle dr-country" data-toggle="dropdown">
                                          Stát
                                        </button>
                                        <div class="dropdown-menu" name="country1" form="form_new_match" id="country-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                                    <div class="dropdown d-inline">
                                        <button type="button" id="league_btn" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown" disabled>
                                          Liga
                                        </button>
                                        <div class="dropdown-menu" id="league-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                                    <div class="dropdown d-inline ml-4">
                                        <button type="button" id="team_btn" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown" value="" disabled>
                                          1. Tým
                                        </button>
                                        <div class="dropdown-menu" id="team-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                                    &nbsp;vs&nbsp;
                                    <!--
                                    <div class="dropdown d-inline" form="form_new_match">
                                        <button type="button" id="country_btn2" class="btn btn-sm btn-outline-dark dropdown-toggle dr-country" value="2" data-toggle="dropdown">
                                          2. Stát
                                        </button>
                                        <div class="dropdown-menu" id="country-list2" style="overflow: auto; max-height: 50vh">
                                          
                                        </div>
                                    </div>
                                    <div class="dropdown d-inline" form="form_new_match">
                                        <button type="button" id="league_btn2" class="btn btn-sm btn-outline-dark dropdown-toggle" value="2" data-toggle="dropdown" disabled>
                                          2. Liga
                                        </button>
                                        <div class="dropdown-menu" id="league-list2" style="overflow: auto; max-height: 50vh">
                                          
                                        </div>
                                    </div>-->
                                    <div class="dropdown d-inline">
                                        <button type="button" id="team_btn2" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown" value="2" disabled>
                                          2. Tým
                                        </button>
                                        <div class="dropdown-menu" id="team-list2" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" id="prob1" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3" disabled>
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" id="probtie" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3" disabled>
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" id="prob2" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3" disabled>
                                </td>

                    </tr>
                

                {!! Form::open(['action' => 'mainControl@update_match', 'method' => 'POST', 'id' => 'form_update_match']) !!}
                <input type="hidden" form="form_update_match" name="column_name" id="update_column">
                <input type="hidden" form="form_update_match" name="output_id" id="update_id">
                <input type="hidden" form="form_update_match" name="date" id="update_date">
                <input type="hidden" form="form_update_match" name="team1" id="update_team1">
                <input type="hidden" form="form_update_match" name="team2" id="update_team2">
                <input type="hidden" form="form_update_match" name="prob1" id="update_prob1">
                <input type="hidden" form="form_update_match" name="probtie" id="update_probtie">
                <input type="hidden" form="form_update_match" name="prob2" id="update_prob2">
                {!! Form::close() !!}
                @foreach($matches as $match)
                    
                        
                        <tr>
                            <input type="hidden" value="{{$match->id}}">
                            <td class="date d-none d-md-table-cell align-middle pl-4">
                                
                                <span class="match_date">{{$match->date}}</span>
                                <input type="date" class="text_field" name="date" style="display: none; height: 20%" size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" class="btn btn-sm ok" value="date">Ok</button>
                                <br><span>11:11</span>
                                <input type="time" class="text_field" name="time" style="display: none; height: 20%" size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="1"></i>
                                <button type="button" class="btn btn-sm ok" value="time">Ok</button>
                            </td>
                            
                            <td class="match d-none d-md-table-cell align-middle">
                            	<img src="img/logo.png" class="web_logo" alt="logo týmu"><span>{{$match->team1}}</span>
                            	<input type="text" class="text_field" name="team1" style="display: none; height: 20%" size="7">
                            	<i class="fa fa-pencil ml-2 pencil" value="0"></i>
                            	<button type="button" class="btn btn-sm ok" value="team1">Ok</button> - 
                            	<img src="img/logo.png" class="web_logo" alt="logo týmu"><span>{{$match->team2}}</span>
                            	<input type="text" class="text_field" name="team2" style="display: none; height: 20%" size="7">
                            	<i class="fa fa-pencil ml-2 pencil" value="1"></i>
                            	<button type="button" class="btn btn-sm ok" value="team2">Ok</button>

                      		</td>

                            <td class="match d-md-none">
                            	<img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team1}}
                            	<input type="text" style="display: none">
                            	<br>
                            	<img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team2}}<br>
                            	<span class="match_date">{{$match->date}}</span>, 11:11
                            </td>

                            <td class="league d-none d-md-table-cell align-middle">
                            	<img src="img/logo.png" class="web_logo ml-2" alt="logo ligy">
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->prob1}}</span></b>
                                <input type="text" class="text_field" name="prob1" style="display: none; height: 20%" 
                                size="3">
                            	<i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" class="btn btn-sm ok" value="prob1">Ok</button>
                            	<br><b><span>1.11</span></b>
                                <input type="text" class="text_field" style="display: none; height: 20%" 
                                size="3">
                            	<!--<i class="fa fa-pencil ml-2 pencil" value="1"></i>-->
                                <button type="button" class="btn btn-sm ok">Ok</button>
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->probtie}}</span></b>
                                <input type="text" class="text_field" name="probtie" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" class="btn btn-sm ok" value="probtie">Ok</button>
                                <br><b><span>1.11</span></b>
                                <input type="text" class="text_field" style="display: none; height: 20%" 
                                size="3">
                                <!--<i class="fa fa-pencil ml-2 pencil" value="1"></i>-->
                                <button type="button" class="btn btn-sm ok">Ok</button>
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->prob2}}</span></b>
                                <input type="text" class="text_field" name="prob2" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" class="btn btn-sm ok" value="prob2">Ok</button>
                                <br><b><span>1.11</span></b>
                                <input type="text" class="text_field" style="display: none; height: 20%" 
                                size="3">
                                <!--<i class="fa fa-pencil ml-2 pencil" value="1"></i>-->
                                <button type="button" class="btn btn-sm ok">Ok</button>
                            </td>
                            
                        </tr>
                    
                @endforeach
                
                </tbody>
            </table>
        </div>
    @endsection
