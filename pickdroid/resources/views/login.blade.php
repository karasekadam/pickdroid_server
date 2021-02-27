@extends("layouts.layout")
@section("content")
    <div class="row" style="height: 100%">
    	<div class="col-md-6">
    		<div class="row mt-5" style="height: 80%; border-right: 1px solid black">
    			<div class="col-md-6 offset-md-3">
	    			<p class="h1 font-weight-light text-center">Log in</p>
	    			{!! Form::open(['action' => 'mainControl@check_login', 'method' => 'POST']) !!}
	    			<div class="mt-4">
	    				<div class="form-group">
							<label for="email"><b>Email:</b></label>
							<input type="text" name="email" id="email" class="form-control"><br>
						</div>

						<div class="form-group">
							<label for="password"><b>Password:</b></label>
							<input type="password" name="password" id="password" class="form-control"><br>
						</div>

						<div class="text-center"><button class="btn btn-lg btn-outline-dark">Log in</button></div>

					</div>
					{!! Form::close() !!}
				</div>
    		</div>
    	</div>

    	<div class="col-md-6">
    		<div class="row mt-5" style="height: 80%">
    			<div class="col-md-6 offset-md-3">
	    			<p class="h1 font-weight-light text-center">Sign up</p>

	    			{!! Form::open(['action' => 'mainControl@check_reg', 'method' => 'POST']) !!}
	    			<div class="mt-4">

	    				<div class="form-group">
							<label for="email"><b>Email:</b></label>
							<input type="email" name="email" id="email" class="form-control"><br>
						</div>

	    				<div class="form-group">
							<label for="name"><b>Name:</b></label>
							<input type="text" name="name" id="name" class="form-control"><br>
						</div>

						<div class="form-group">
							<label for="password"><b>Password:</b></label>
							<input type="password" name="password" id="password" class="form-control"><br>
						</div>

						<div class="text-center"><button class="btn btn-lg btn-outline-dark" id="prihasit">Sign up</button></div>
					</div>
					{!! Form::close() !!}
				</div>
    		</div>
    	</div>
    </div>
@endsection
