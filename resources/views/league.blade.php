@extends("layouts.layout")
    @section("content")
        <table class="table overflow-auto h-75">
            <thead>
            <tr>
                <th class="date"><p class="font-weight-light h4">Datum</p></th>
                <th class="match"><p class="font-weight-light h4">Zápas</p></th>
                <th class="league"><p class="font-weight-light h4">Liga</p></th>
                <th class="rate"><p class="font-weight-light h4">Náš kurz</p></th>
                <th class="rate"><p class="font-weight-light h4">Fortuna</p></th>
                <th class="rate"><p class="font-weight-light h4">Něco</p></th>
            </tr>
            </thead>
            @foreach($matches as $match)
                <tr>
                    <td class="date">{{$match->date}}</td>
                    <td class="match"><img src="img/logo.png" class="logo" alt="logo týmu">{{$match->team1}} - {{$match->team2}}<img src="img/logo.png" class="logo" alt="logo týmu"></td>
                    <td class="league">{{$match->league}}</td>
                    <td class="rate">{{$match->spi1}}</td>
                    <td class="rate">{{$match->spi2}}</td>
                    <td class="rate">{{$match->prob1}}</td>
                </tr>
            @endforeach
        </table>
    @endsection

