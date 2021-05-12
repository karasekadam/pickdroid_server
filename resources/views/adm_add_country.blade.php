@extends("layouts.admin_layout")
    @section("content")
    	<script>
            $(document).ready(function() {
                $("#no_pad_row").parent().attr("style", "padding: auto");
            });
		</script>

	    <div class="row" style="height: 100%" id="no_pad_row">
	    	<div class="col-md-4 offset-md-4">
                <div class="mt-5">
                    <p class="h1 font-weight-light text-center">Přidat Stát</p>
                    {!! Form::open(['action' => 'mainControl@new_country', 'method' => 'POST']) !!}
                        <div class="mt-4">
                            <div class="form-group mt-3">
                                <label><b>Název státu:</b></label>
                                <input type="text" name="new_country" class="form-control"><br>
                            </div>

                            <div class="text-center"><button class="btn btn-lg btn-outline-dark" id="add_new_league">Přidat</button></div>

                            </div>
                        </div>
                    {!! Form::close() !!}
        </div>
    @endsection