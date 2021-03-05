@extends("layouts.layout")
    @section("content")

    <script>
        $(document).ready(function() {
        document.getElementById("wrap").addEventListener("scroll", function(){
       var translate = "translate(0,"+this.scrollTop+"px)";
       this.querySelector("thead").style.transform = translate;
        });
     })
    </script>

        <div class="overflow-auto" id="wrap" style="height: 90vh">
            <table class="table">
                <thead class="thead-light h-50">
                    <tr>
                        <th class="date align-middle d-none d-md-table-cell"><p class="font-weight-light h4">Datum</p></th>
                        <th class="match align-middle"><p class="font-weight-light h4 cs">Zápas</p></th>
                        <th class="league align-middle d-none d-sm-table-cell"><p class="font-weight-light h4">Liga</p></th>
                        <th class="rate align-middle text-center"><p class="font-weight-light h4">1</p></th>
                        <th class="rate align-middle text-center"><p class="font-weight-light h4">X</p></th>
                        <th class="rate align-middle text-center"><p class="font-weight-light h4">2</p></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matches as $match)
                    <tr>
                        <td class="date d-none d-md-table-cell">{{$match->date}}</td>
                        <td class="match d-none d-md-table-cell"><img src="img/logo.png" class="logo1" alt="logo týmu">{{$match->team1}} - {{$match->team2}}<img src="img/logo.png" class="logo2" alt="logo týmu"></td>
                        <td class="match d-md-none">{{$match->team1}}<img src="img/logo.png" class="logo2" alt="logo týmu"><br> {{$match->team2}}<img src="img/logo.png" class="logo2" alt="logo týmu"><br>{{$match->date}}</td>

                        <td class="league d-none d-sm-table-cell">{{$match->league}}</td>
                        <td class="rate text-center align-middle">{{$match->spi1}}</td>
                        <td class="rate text-center align-middle">{{$match->spi2}}</td>
                        <td class="rate text-center align-middle">{{$match->prob1}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection
