@extends("layouts.admin_layout")
    @section("content")
    	<script>
		
		$(document).ready(function() {
			$("#no_pad_row").parent().attr("style", "padding: auto");
			$(".countries").click(function() {
                if ($("#country-list").children().length == 0) {
                    $.ajax({
                    type : 'get',
                    url : '{{URL::to('find_countries')}}',
                    success:function(data){
                        for (var a = 0; a < data.length; a++) {
                            $("#country-list").append("<p class='drop_item'>" + data[a].country + "</p>");
                            $("#country-list2").append("<p class='drop_item'>" + data[a].country + "</p>");
                            }
                        }
                    });
                }
                
            });

            $("#country-list").on("click", "p", country_list);
            $("#country-list2").on("click", "p", country_list2);

            function country_list() {
                var value = $(this).text();
                $("#country_btn").text(value);
                if ($("#league-list").children().length != 0) {
                    $("#league-list").children("p").each(function() {
                        $(this).remove();
                    });
                }
            }


            function country_list2() {

            	var value = $(this).text();
                $("#country_btn2").text(value);
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
                $("#league_btn").text(value);
            }
		});

		</script>

	    <div class="row" style="height: 100%" id="no_pad_row">
	    	<div class="col-md-6">
	    		<div class="row mt-5" style="height: 80%; border-right: 1px solid black">
	    			<div class="col-md-6 offset-md-3">
		    			<p class="h1 font-weight-light text-center">Přidat ligu</p>
		    			{!! Form::open(['action' => 'mainControl@check_login', 'method' => 'POST']) !!}
		    			<div class="mt-4">
		    				<div class="form-group">
								<label><b>Stát:</b></label>
								<div class="dropdown d-inline ml-5">
                                    <button type="button" id="country_btn" class="btn btn-md btn-outline-dark dropdown-toggle countries" data-toggle="dropdown" style="max-width: 150px">
                                      Vybrat stát
                                    </button>
                                    <div class="dropdown-menu" name="country1" id="country-list" style="overflow: auto; max-height: 50vh">
                               	</div>
							</div>

							<div class="form-group mt-3">
								<label><b>Název ligy:</b></label>
								<input type="text" class="form-control"><br>
							</div>

							<div class="text-center"><button class="btn btn-lg btn-outline-dark">Přidat</button></div>

						</div>
						{!! Form::close() !!}
					</div>
	    		</div>
	    	</div>
	    	</div>
	    	<div class="col-md-6">
	    		<div class="row mt-5" style="height: 80%">
	    			<div class="col-md-6 offset-md-3">
		    			<p class="h1 font-weight-light text-center">Přidat tým</p>

		    			{!! Form::open(['action' => 'mainControl@check_reg', 'method' => 'POST']) !!}
		    			<div class="mt-4">

		    				<div class="form-group">
								<label><b>Stát:</b></label>
								<div class="dropdown d-inline ml-5">
                                    <button type="button" id="country_btn2" class="btn btn-md btn-outline-dark dropdown-toggle countries" data-toggle="dropdown" style="max-width: 150px">
                                      Vybrat stát
                                    </button>
                                    <div class="dropdown-menu" id="country-list2" style="overflow: auto; max-height: 50vh">
                                    </div>
                               	</div>
							</div>

		    				<div class="form-group">
								<label><b>Liga:</b></label>
								<div class="dropdown d-inline ml-5">
                                        <button type="button" id="league_btn" class="btn btn-md btn-outline-dark dropdown-toggle" data-toggle="dropdown" style="max-width: 150px" disabled>
                                          Vybrat ligu
                                        </button>
                                        <div class="dropdown-menu" id="league-list" style="overflow: auto; max-height: 50vh">
                                        </div>
                                    </div>
							</div>

							<div class="form-group">
								<label><b>Název týmu</b></label>
								<input type="text" class="form-control"><br>
							</div>

							<div class="text-center"><button class="btn btn-lg btn-outline-dark" id="prihasit">Přidat</button></div>
						</div>
						{!! Form::close() !!}
					</div>
	    		</div>
	    	</div>
	    </div>
    @endsection