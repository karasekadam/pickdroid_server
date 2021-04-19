@extends("layouts.admin_layout")
    @section("content")
    	<script>
            $(document).ready(function() {
                $("#no_pad_row").parent().attr("style", "padding: auto");
            });
		</script>

	    <div class="row" style="height: 100%" id="no_pad_row">
	    	<div class="col-md-6 offset-md-3 text-center">
                <div class="mt-5">
                    <p class="h1 font-weight-light text-center">Přidat Stát</p>
                    {!! Form::open(['action' => 'mainControl@new_league', 'method' => 'POST', 'id' => 'add_league']) !!}
                        <input type="hidden" name="country_name" id="country_name">
                        <div class="mt-4">
                            <div class="form-group">
                                <label><b>Stát:</b></label>
                                <div class="dropdown d-inline ml-5">
                                    <button type="button" id="country_btn" class="btn btn-md btn-outline-dark dropdown-toggle countries" data-toggle="dropdown" style="max-width: 150px">
                                        @if ($leag_country == "")
                                        Vybrat stát
                                        @else
                                        {{$leag_country}}
                                        @endif
                                    </button>
                                    <div class="dropdown-menu" id="country-list" style="overflow: auto; max-height: 50vh">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label><b>Název ligy:</b></label>
                                <input type="text" name="new_league" class="form-control"><br>
                            </div>

                            <div class="text-center"><button type="button" class="btn btn-lg btn-outline-dark" id="add_new_league">Přidat</button></div>

                            </div>
                        </div>
                    {!! Form::close() !!}
        </div>
    @endsection