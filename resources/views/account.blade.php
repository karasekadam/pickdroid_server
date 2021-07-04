@extends("layouts.layout")
	@section("content")
		<div class="row mt-3">
			<div class="col-md-3 text-center"><h1 class="display-4">Můj účet</h1></div>
		</div>
		<div class="row mt-5">
			<div class="col-md-1"></div>
			<div class="col-md-4 text-center"><h3 class="font-weight-light">Email: {{$user}}</h3></div>
			<div class="col-md-1"></div>
			<div class="col-md-4 text-center"><h3 class="font-weight-light">Lokace: {{$country}}</h3></div>
		</div>
	@endsection