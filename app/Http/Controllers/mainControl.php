<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matches;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class mainControl extends Controller
{
    public function check_login(Request $data) {
    	$this->validate($data, [
            "email"=>"required",
            "password"=>"required"
        ]);

        $user = User::where("email", $data->email)->get();
        if (!$user->first() or !(Hash::check($data->password, $user->first()->password))) {
        	return redirect()->route("login");
        }


        $sport = request("sport");   //nešlo mi to použít jako parametr místo Matches, tak buď na to přijdu, nebo tam budou ify, když nebude moc sportů
        $league = request("league");
        if ($league) {
            $matches = Matches::where("league", $league)->where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->get();
        }
        else {
            $matches = Matches::where("date", ">=", Carbon::now())->orderBy("priority", "asc")->orderBy("date", "asc")->take(30)->get();
        }
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(4)->get();
        return redirect()->route("home", ["matches"=>$matches, "leagues"=>$leagues]);
    }

    public function check_reg(Request $data) {
    	$this->validate($data, [
            "name"=>"required",
            "password"=>"required"
        ]);

        $user = User::where("email", $data->email)->get();
        if($user->first()) {
        	return redirect()->route("login");
        }

        // checknout ostatní mrdky, délku hesla, velký písmena atd

        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->fill([
            'password' => Hash::make($data->password)
        ])->save();
        $user->save();
        $leagues = Matches::where("date", ">=", Carbon::now())->select("league")->distinct()->take(4)->get();
        return view('success_reg', ["leagues"=>$leagues]);
    }

}