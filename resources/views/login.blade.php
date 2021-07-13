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
	
	$(document).ready(function() {
		$("#no_pad_row").parent().attr("style", "padding: auto");

	});

	</script>


	<div class="row" id="topbar_row">
	    <div class="col-md-12 d-none d-sm-none d-md-block topbar">
	        <div class="row h-100 align-items-center">
	            <div class="col-xl-12 text-center">
	                <a href="/">
	                    <img src="img/robot2.png" alt="logo" id="robot">
	                </a>
	            </div>
	        </div>
	    </div>
	</div>


	
    <div class="row" style="height: 100%;" id="no_pad_row">
    	<div class="col-md-12">
    		<div class="row mt-4 justify-content-center" style="height: 80%">
    			<div class="col-md-3">
	    			<p class="h2 font-weight-light text-center">Sign up</p>

	    			{!! Form::open(['action' => 'mainControl@check_reg', 'method' => 'POST']) !!}
	    			<div class="mt-4">

	    				<div class="form-group">
							<label for="email"><b>Email</b></label>
							<input type="email" name="email" id="email" class="form-control" required>
						</div>

	    				<div class="form-group">
							<label for="name"><b>Name</b></label>
							<input type="text" name="name" id="name" class="form-control" required>
						</div>

						<div class="form-group">
							<label for="password"><b>Password</b></label>
							<input type="password" name="password" id="password" class="form-control" required>
						</div>

						<div class="text-center"><button class="btn btn-lg btn-block" id="prihasit" style="color: white; background-color: black">Sign up</button></div><br>
					</div>
					{!! Form::close() !!}
					<a href="/google_login" style="text-decoration: none"><button class="btn btn-block" style="border: 1px solid black"><i class="fab fa-google float-left mt-1"></i>Continue with Google</button></a>
					<!--<a href="/facebook_login" style="text-decoration: none"><button class="btn btn-info btn-block mt-2">Sign up with Facebook</button></a>-->
				</div>
    		</div>
    	</div>
    </div>
	</body>
</html>