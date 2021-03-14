@extends("layouts.layout")
    @section("content")

    <script>
        
        $(document).ready(function() {

            document.getElementById("wrap").addEventListener("scroll", function(){
           var translate = "translate(0,"+this.scrollTop+"px)";
           this.querySelector("thead").style.transform = translate;
            });

            var date = document.getElementsByClassName("match_date");
            for (var x = 0; x < date.length; x++) {
                var spl = date[x].innerText.split("-");
                var result = spl[2] + "." + spl[1];
                date[x].innerText = result;
            }

     });
    </script>

        <div id="wrap" style="height: 90vh; overflow-y: auto; overflow-x: hidden">
            <table class="table">
                <thead class="thead-light h-50">
                    <tr>
                        <th class="date align-middle d-none d-md-table-cell" style="width: 10%"><p class="font-weight-light h4">Datum</p></th>
                        <th class="match align-middle" style="width: 31%"><p class="font-weight-light h4">Zápas</p></th>
                        <th class="league align-middle d-none d-sm-table-cell" style="width: 5%"><p class="font-weight-light h4">Liga</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">1</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">X</p></th>
                        <th class="rate align-middle text-center" style="width: 18%"><p class="font-weight-light h4">2</p></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matches as $match)
                    <tr>
                        <td class="date d-none d-md-table-cell align-middle pl-4"><span class="match_date">{{$match->date}}</span><br>11:11</td>

                        <td class="match d-none d-md-table-cell align-middle"><img src="img/logo.png" class="web_logo" alt="logo týmu">{{$match->team1}} - <img src="img/logo.png" class="web_logo" alt="logo týmu">{{$match->team2}}</td>

                        <td class="match d-md-none"><img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team1}}<br><img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team2}}<br><span class="match_date">{{$match->date}}</span>, 11:11</td>

                        <td class="league d-none d-md-table-cell align-middle"><img src="img/logo.png" class="web_logo ml-2" alt="logo ligy"></td>

                        <td class="rate text-center align-middle"><b>{{$match->spi1}}<br>1.11</b></td>
                        <td class="rate text-center align-middle"><b>{{$match->spi2}}<br>1.11</b></td>
                        <td class="rate text-center align-middle"><b>{{$match->prob1}}<br>1.11</b></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection
