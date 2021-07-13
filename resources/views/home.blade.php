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
            <table class="table" style="background-color: #f7f7f7">
                <thead>
                    <tr>
                        <th class="match d-none d-md-table-cell font-weight-light h5 pb-1"
                        style="width: 43%"><span class="ml-2">Match</span></th>
                        <!--<th class="match align-middle p-2 pl-2 p-md-3 font-weight-light h4" style="width: 31%">Match</th>
                        <th class="league align-middle d-none d-sm-table-cell font-weight-light h4" style="width: 5%">Leag.</th>-->
                        <th class="rate text-center pb-1 font-weight-light h5" style="width: 19%">1</th>
                        <th class="rate text-center pb-1 font-weight-light h5" style="width: 19%">X</th>
                        <th class="rate text-center pb-1 font-weight-light h5" style="width: 19%">2</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matches as $match)
                    <tr>
                        
                        @php
                        {{
                            $logo_title1 = str_replace("/", "-", $match->team1);
                            $logo_title2 = str_replace("/", "-", $match->team2);
                        }}
                        @endphp
                        @if (is_file('img/logo/' . $logo_title1 . '.png'))
                            <td class="date d-none d-md-table-cell align-middle pl-4"><img src="img/logo/{{$logo_title1}}.png" class="web_logo">{{$match->team1}}<br>
                        @else
                            <td class="date d-none d-md-table-cell align-middle pl-4">{{$match->team1}}<br>
                        @endif

                        @if (is_file('img/logo/' . $logo_title2 . '.png'))
                            <img src="img/logo/{{$logo_title2}}.png" class="web_logo">{{$match->team2}}<br>
                        @else
                            {{$match->team2}}<br>
                        @endif
                        <span class="match_date pl-1" style="font-size: 85%">{{$match->date}}</span><span style="font-size: 85%">, 11:11</span> 
                            @if (is_file('img/logo/' . $match->league . '.png'))
                            <img src="img/logo/{{$match->league}}.png" style="width: 15px; height: 15px">
                            @endif
                        </td>
                        <td class="match d-md-none pt-1 pb-1"><img src="img/logo.png" class="mob_logo">{{$match->team1}}<br><img src="img/logo.png" class="mob_logo">{{$match->team2}}<br><span class="match_date">{{$match->date}}</span>, 11:11</td>

                        <!--<td class="league d-none d-md-table-cell align-middle">
                            @if (is_file('img/logo/' . $match->league . '.png'))
                            <img src="img/logo/{{$match->league}}.png" class="web_logo ml-3">
                            @endif
                        </td>-->

                        <td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>{{$match->prob1}}<br>1.11</b></div></td>
                        <td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>{{$match->probtie}}<br>1.11</b></div></td>
                        <td class="rate text-center align-md-middle"><div class="rate_pad font-weight-light"><b>{{$match->prob2}}<br>1.11</b></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection
