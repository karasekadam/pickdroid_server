@extends("layouts.layout")
@section("content")
    <div class="mt-3 ml-3">
        {{$content->first()->about_us}}
    </div>
@endsection
