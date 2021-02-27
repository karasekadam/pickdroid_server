@extends("layouts.layout")
    @section("content")

    <!--<script>
        $(document).ready(function() {
        document.getElementById("wrap").addEventListener("scroll", function(){
       var translate = "translate(0,"+this.scrollTop+"px)";
       this.querySelector("thead").style.transform = translate;
        });
     })
    </script>-->

        <div class="overflow-auto" id="wrap" style="height: 90vh">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="date align-middle"><p class="font-weight-light h4">Datum</p></th>
                        <th class="match align-middle"><p class="font-weight-light h4">Zápas</p></th>
                        <th class="league align-middle"><p class="font-weight-light h4">Liga</p></th>
                        <th class="rate align-middle"><p class="font-weight-light h4">Náš kurz</p></th>
                        <th class="rate align-middle"><p class="font-weight-light h4">Fortuna</p></th>
                        <th class="rate align-middle"><p class="font-weight-light h4">Něco</p></th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        </div>
    @endsection
