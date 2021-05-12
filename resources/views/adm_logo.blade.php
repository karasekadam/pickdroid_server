@extends("layouts.admin_layout")
    @section("content")
    	<script>
            $(document).ready(function() {
                $("#no_pad_row").parent().attr("style", "padding: auto");

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
                            $("#league-list").append("<p class='drop_item'>" + data[a] + "</p>");
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
                if ($("#team-list").children().length != 0) {
                    $("#team-list").children("p").each(function() {
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
                            }
                        }
                    });
            }

            $("#team-list").on("click", "p", team_list);

            function team_list() {
                var value = $(this).text();
                var add = $(this).parent().parent().children("button").attr("value");
                $("#team_hidden").attr("value", value);
                $("#team_btn").text(value);
            }

            $("#btn_add").click(function() {
                $("#country_hidden").val($("#country_btn").text());
                $("#league_hidden").val($("#league_btn").text());
                $("#team_hidden").val($("#team_btn").text());
                $("#logo_update").submit();
            });

            });
		</script>

	    <div class="row" style="height: 100%" id="no_pad_row">
	    	<div class="col-md-4 offset-md-4">
                <div class="mt-5">
                    <p class="h1 font-weight-light text-center">Upravit logo</p>
                    {!! Form::open(['action' => 'mainControl@upload_logo', 'method' => 'POST', 'id' => 'logo_update', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" name="country_hidden" id="country_hidden">
                        <input type="hidden" name="league_hidden" id="league_hidden">
                        <input type="hidden" name="team_hidden" id="team_hidden">
                        <div class="mt-4">
                            <div class="form-group text-center">
                                <label><b>Stát:</b></label>
                                <div class="dropdown d-inline ml-5">
                                    <button type="button" id="country_btn" class="btn btn-md btn-outline-dark dropdown-toggle countries dr-country" data-toggle="dropdown" style="max-width: 150px">
                                        @if ($country == "")
                                        Vybrat stát
                                        @else
                                        {{$country}}
                                        @endif
                                    </button>
                                    <div class="dropdown-menu" id="country-list" style="overflow: auto; max-height: 50vh">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <label><b>Liga:</b></label>
                                <div class="dropdown d-inline ml-5">
                                    @if ($league == "")
                                        <button type="button" id="league_btn" class="btn btn-md btn-outline-dark dropdown-toggle" data-toggle="dropdown" style="max-width: 150px" disabled>
                                            Vybrat ligu
                                        </button>
                                    @else
                                        <button type="button" id="league_btn" class="btn btn-md btn-outline-dark dropdown-toggle" data-toggle="dropdown" style="max-width: 150px">
                                            {{$league}}
                                        </button> 
                                    @endif    
                                        <div class="dropdown-menu" id="league-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group text-center">
                                <label><b>Tým:</b></label>
                                <div class="dropdown d-inline ml-5">
                                    @if ($team == "")
                                        <button type="button" id="team_btn" class="btn btn-md btn-outline-dark dropdown-toggle" data-toggle="dropdown" style="max-width: 150px" disabled>
                                            Vybrat ligu
                                        </button>
                                    @else
                                        <button type="button" id="team_btn" class="btn btn-md btn-outline-dark dropdown-toggle" data-toggle="dropdown" style="max-width: 150px">
                                            {{$team}}
                                        </button> 
                                    @endif    
                                        <div class="dropdown-menu" id="team-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group text-center">
                                <label for="upload"><b>Náhrat logo</b></label>
                                <input type="file" accept="image/png" id="upload" name="new_logo" class="d-none">
                            </div>

                            <div class="text-center"><button type="button" class="btn btn-lg btn-outline-dark" id="btn_add">Hotovo</button></div>

                            </div>
                        </div>
                    {!! Form::close() !!}
        </div>
    @endsection