@extends("layouts.admin_layout")
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

            $(".pencil").click(function() {
                var pencil_num = $(this).attr("value");
            	$(this).parent().children(".text_field:eq(" + pencil_num + ")").css("display", "inline");
            	$(this).parent().children("span:eq(" + pencil_num + ")").css("display", "none");
                $(this).parent().children("b:eq(" + pencil_num + ")").css("display", "none");
            	$(this).parent().children("i:eq(" + pencil_num + ")").css("display", "none");
            	$(this).parent().children("button:eq(" + pencil_num + ")").css("display", "inline");
            });

            $(".ok").click(function() {
                var column = $(this).attr("value");
                $(this).parent().parent().children("input:eq(1)").attr("value", column);
            	var form_id = $(this).attr("form");
                $("#" + form_id).submit();
            });

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
                
                {!! Form::open(['action' => 'mainControl@new_match', 'method' => 'POST', 'id' => 'form_new_match']) !!}
                {!! Form::close() !!}

                    <tr style="display: none" id="new_match">
                        <td class="date d-none d-md-table-cell align-middle pl-4">
                                    <input type="text" form="form_new_match" class="text_field" name="date" style="height: 20%" size="3"><br>
                                    <input type="text" form="form_new_match" class="text_field" name="time" style="height: 20%" size="3">
                                </td>

                                
                                <td class="match d-none d-md-table-cell align-middle">
                                    <input type="text" form="form_new_match" class="text_field" name="team1" style="height: 20%" size="7">
                                    -
                                    <input type="text" form="form_new_match" class="text_field" name="team2" style="height: 20%" size="7">
                                </td>

                                <td class="league d-none d-md-table-cell align-middle">
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" form="form_new_match" class="text_field" name="prob1" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" form="form_new_match" class="text_field" name="probtie" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                </td>

                                <td class="rate text-center align-middle">
                                    <input type="text" form="form_new_match" class="text_field" name="prob2" style="height: 20%" 
                                    size="3">
                                    <br>
                                    <input type="text" form="form_new_match" class="text_field" style="height: 20%" 
                                    size="3">
                                </td>

                    </tr>
                


                @foreach($matches as $match)
                    {!! Form::open(['action' => 'mainControl@update_match', 'method' => 'POST', 'id' => $match->id]) !!}
                    {!! Form::close() !!}
                        
                        <tr>
                            <input type="hidden" form="{{$match->id}}" name="output_id" value="{{$match->id}}">
                            <input type="hidden" form="{{$match->id}}" name="column_name" class="column_name" value="">
                            <td class="date d-none d-md-table-cell align-middle pl-4">
                                
                                <span class="match_date">{{$match->date}}</span>
                                <input type="text" form="{{$match->id}}" class="text_field" name="date" style="display: none; height: 20%" size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="date">Ok</button>
                                <br><span>11:11</span>
                                <input type="text" form="{{$match->id}}" class="text_field" name="time" style="display: none; height: 20%" size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="1"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok" style="display: none" value="time">Ok</button>
                            </td>
                            
                            <td class="match d-none d-md-table-cell align-middle">
                            	<img src="img/logo.png" class="web_logo" alt="logo týmu"><span>{{$match->team1}}</span>
                            	<input type="text" form="{{$match->id}}" class="text_field" name="team1" style="display: none; height: 20%" size="7">
                            	<i class="fa fa-pencil ml-2 pencil" value="0"></i>
                            	<button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="team1">Ok</button> - 
                            	<img src="img/logo.png" class="web_logo" alt="logo týmu"><span>{{$match->team2}}</span>
                            	<input type="text" form="{{$match->id}}" class="text_field" name="team2" style="display: none; height: 20%" size="7">
                            	<i class="fa fa-pencil ml-2 pencil" value="1"></i>
                            	<button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="team2">Ok</button>

                      		</td>

                            <td class="match d-md-none">
                            	<img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team1}}
                            	<input type="text" style="display: none">
                            	<br>
                            	<img src="img/logo.png" class="mob_logo" alt="logo týmu">{{$match->team2}}<br>
                            	<span class="match_date">{{$match->date}}</span>, 11:11
                            </td>

                            <td class="league d-none d-md-table-cell align-middle">
                            	<img src="img/logo.png" class="web_logo ml-2" alt="logo ligy">
                            	<i class="fa fa-pencil ml-2 pencil"></i>
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->prob1}}</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" name="prob1" style="display: none; height: 20%" 
                                size="3">
                            	<i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="prob1">Ok</button>
                            	<br><b><span>1.11</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" style="display: none; height: 20%" 
                                size="3">
                            	<i class="fa fa-pencil ml-2 pencil" value="1"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok">Ok</button>
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->probtie}}</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" name="probtie" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="probtie">Ok</button>
                                <br><b><span>1.11</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="1"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok">Ok</button>
                            </td>

                            <td class="rate text-center align-middle"><b><span>{{$match->prob2}}</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" name="prob2" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="0"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok" value="prob2">Ok</button>
                                <br><b><span>1.11</span></b>
                                <input type="text" form="{{$match->id}}" class="text_field" style="display: none; height: 20%" 
                                size="3">
                                <i class="fa fa-pencil ml-2 pencil" value="1"></i>
                                <button type="button" form="{{$match->id}}" class="btn btn-sm ok">Ok</button>
                            </td>
                            
                        </tr>
                    
                @endforeach
                
                </tbody>
            </table>
        </div>
    @endsection
