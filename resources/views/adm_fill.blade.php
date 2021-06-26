@extends("layouts.admin_layout")
    @section("content")
    <script type="text/javascript">
    	$(document).ready(function() {
    		$("body").css("overflow", "hidden");
    		$(".country-input").each(function() {
    			console.log($(this).attr("name"))
    		});
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
		    		<h5 class="font-weight-light">Liga: <b>{{$country->name_538}}</b><span class="ml-5">Stát: <input type="text" name="{{$country->name_538}}" class="country-input"></span></h5>
		    	</div>
		    </div>

		    @endforeach
	</div>
			<div class="row">
		    	<div class="col-md-4 ml-5 mt-4">
		    		<button class="btn btn-outline-dark">Uložit změny</button>
		    	</div>
			</div>
		{!! Form::close() !!}
	
    @endsection