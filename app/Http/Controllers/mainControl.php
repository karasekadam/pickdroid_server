<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class mainControl extends Controller
{
    public function check_login(Request $data) {
    	$this->validate($data, [
            "email"=>"required",
            "password"=>"required"
        ]);

        $user = User::where("email", $data->email)->get();
        if (!$user->first() or $user->first()->password != $data->password) {
        	return redirect()->route("login");
        }

        return redirect()->route("main");
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
        $user->password = $data->password;
        $user->email = $data->email;
        $user->save();
        return view("success_reg");
    }

}
