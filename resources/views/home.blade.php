@extends("layouts.layout")
    @section("content")

    <script>
        
        $(document).ready(function() {

            document.getElementById("wrap").addEventListener("scroll", function(){
           var translate = "translate(0,"+this.scrollTop+"px)";
           this.querySelector("thead").style.transform = translate;
            });

            var date = document.getElementsByClassName("match_date");
            var date_obj = new Date();
            var month = (date_obj.getMonth())+1;
            if (month < 10) {
                month = "0" + month;
            }
            var day = date_obj.getDate();
            var today = day + "." + month
            for (var x = 0; x < date.length; x++) {
                var spl = date[x].innerText.split("-");
                var result = spl[2] + "." + spl[1];
                if (result != today) {
                    date[x].innerText = result;
                } else {
                    date[x].innerText = "";
                }
                
            }

     });
    </script>

        <div id="wrap" style="height: 90vh; overflow-y: auto; overflow-x: hidden">
            <table class="table">
                <thead class="thead-light h-50">
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

                        <td class="rate text-center align-middle"><b>{{$match->spi1}}<br>1.11</b></td>
                        <td class="rate text-center align-middle"><b>{{$match->spi2}}<br>1.11</b></td>
                        <td class="rate text-center align-middle"><b>{{$match->prob1}}<br>1.11</b></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection
