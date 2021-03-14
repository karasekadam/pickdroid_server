@extends('layouts.layout')
	@section('content')

	<script>
		$(document).ready(function() {
			$(".edit").hover(function() {
				$("#edit_icon").show();
			}, function() {
				$("#edit_icon").hide();
			});

			$("#edit_icon").click(function() {
				$(".edit").hide();
				$("#edit_area").show();
				$("#edit_btn").show();

			});

			$("#no_pad_row").parent().attr("style", "padding: auto");

		});

	</script>
	<div class="row" id="no_pad_row">
		<div class="col-md-6">
			<div class="mt-3 ml-3">
				<p class="edit">{{$content->first()->blog}}<i id="edit_icon" class="fa fa-pencil ml-2" style="display: none"></i></p>
				{!! Form::open(['action' => 'mainControl@update_other', 'method' => 'POST']) !!}

					<textarea class="form-control" name="edit_area" id="edit_area" style="display: none"></textarea>

					<input type="hidden" value="blog" name="edit_hidden">

					<button class="btn btn-outline-dark mt-2 float-right" id="edit_btn" style="display: none">Odeslat</button>

				{!! Form::close() !!}
			</div>
		</div>
	</div>

	@endsection