@extends("layouts.admin_layout")
    @section("content")
    <script type="text/javascript">
    	$(document).ready(function() {
    		$("body").css("overflow", "hidden");
    		$(".league_btn").click(function() {
    			var id = $(this).attr("id");
                if ($(this).next().children().length == 0) {
                    $.ajax({
                    type : 'get',
                    url : '{{URL::to('find_countries')}}',
                    success:function(data) {

                        for (var a = 0; a < data.length; a++) {
                            $("#" + id).next().append("<p class='drop_item'>" + data[a].country + "</p>");
                            }
                        }
                    });
                }
            });

            $(".country-list").on("click", "p", country_list);

            function country_list() {
                var value = $(this).text();
                var btn = $(this).parent().prev().attr("id");
                $("#" + btn).text(value);
                $("[name='"+ btn + "']").val(value);
            }
    	});
    	
    </script>
    <div style="overflow-y: auto; overflow-x: hidden; height: 40%">
	    <div class="row">
	    	<div class="col-md-4 ml-5 mt-4">
	    		<h1 class="font-weight-light">Chybějící státy</h1>
	    	</div>
	    </div>
	    {!! Form::open(['action' => 'mainControl@country_fill', 'method' => 'POST']) !!}
		    @foreach($empty_countries as $country)

		    <div class="row">
		    	<div class="col-md-10 ml-5 mt-2">
		    		<h5 class="font-weight-light">Liga: <b>{{$country->name_538}}</b><span class="ml-5">Stát: 
		    			<!--<input type="text" name="{{$country->name_538}}" class="country-input"></span></h5>-->
		    			<div class="dropdown d-inline">
		    				<button type="button" id="{{$country->id}}" class="btn btn-md btn-outline-dark dropdown-toggle league_btn" data-toggle="dropdown" style="max-width: 150px">Vybrat stát</button>
		    				<div class="dropdown-menu country-list" style="overflow: auto; max-height: 50vh"></div>
		    				<input type="hidden" name="{{$country->id}}">
		    			</div>
		    	</div>
		    </div>

		    @endforeach
	</div>
			<div class="row">
		    	<div class="col-md-4 ml-5 mt-4">
		    		<button class="btn btn-outline-dark" id="submit">Uložit změny</button>
		    	</div>
			</div>
		{!! Form::close() !!}
	
    @endsection