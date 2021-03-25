@extends("layouts.layout")
    @section("content")

    <script>
        
        $(document).ready(function() {

            document.getElementById("wrap").addEventListener("scroll", function(){
           var translate = "translateY(-1px)";
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

        <div id="wrap" style="height: 90vh; overflow-x: hidden; overflow-y: auto">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th class="date align-middle d-none d-md-table-cell font-weight-light h4" 
                        style="width: 7%">Date</th>
                        <th class="match align-middle p-2 pl-2 p-md-3 font-weight-light h4" style="width: 31%">Match</th>
                        <th class="league align-middle d-none d-sm-table-cell font-weight-light h4" style="width: 5%">Leag.</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">1</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">X</th>
                        <th class="rate align-middle text-center p-2 p-md-3 font-weight-light h4" style="width: 19%">2</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matches as $match)
                    <tr>
                        <td class="date d-none d-md-table-cell align-middle pl-4"><span class="match_date">{{$match->date}}</span><br>11:11</td>

                        <td class="match d-none d-md-table-cell align-middle pt-1 pb-1"><img src="img/logo.png" class="web_logo" alt="logo týmu">{{$match->team1}} - <img src="img/logo.png" class="web_logo" alt="logo týmu">{{$match->team2}}</td>

                        <td class="match d-md-none pt-1 pb-1"><img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team1}}<br><img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team2}}<br><span class="match_date">{{$match->date}}</span>, 11:11</td>

                        <td class="league d-none d-md-table-cell align-middle"><img src="img/logo.png" class="web_logo ml-3" alt="logo ligy"></td>

                        <td class="rate text-center align-md-middle"><div class="rate_pad"><b>{{$match->prob1}}<br>1.11</b></div></td>
                        <td class="rate text-center align-md-middle"><div class="rate_pad"><b>{{$match->probtie}}<br>1.11</b></div></td>
                        <td class="rate text-center align-md-middle"><div class="rate_pad"><b>{{$match->prob2}}<br>1.11</b></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection
