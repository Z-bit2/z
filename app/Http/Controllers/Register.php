<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cloutier\PhpIpfsApi\IPFS;
use DB;

class Register extends Controller
{
    public function index()
    {
    }

    public function user_register(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $pin_code = $request->input('pin_code');
        $seed = $request->input('seed');

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "listaccounts", "params" => [] );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "trey" . ":" . "trey2019raven");
        curl_setopt($curl, CURLOPT_URL, 'http://34.217.223.244:8766/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request_data));
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $decoded_result=json_decode($result, true);
        foreach ($decoded_result["result"] as $key => $value){
            if($key == $seed){
                DB::table('site_users')->where('seed', $seed)->update(array('email'=>$email, 'password'=>$password, 'pin_code'=>$pin_code,));
                return;
            }
        }

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getnewaddress", "params" => [$seed] );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "trey" . ":" . "trey2019raven");
        curl_setopt($curl, CURLOPT_URL, 'http://34.217.223.244:8766/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request_data));
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        $decoded_result=json_decode($result, true);

        DB::insert('insert into site_users (email, password, pin_code, seed, wallet_address, asset_name_list, asset_amount) values(?, ?, ?, ?, ?, ?, ?)', [$email, $password, $pin_code, $seed, $decoded_result["result"], "", ""]);

        return;
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $sql_query = 'select * from site_users where email="'.$email.'" and password="'.$password.'"';

        $users = DB::select($sql_query);
        if(count($users) > 0){
            // $request->session()->put('email', $email);
            // $request->session()->put('password', $password);
            $request->session()->put('seed', $users[0]->seed);
            $request->session()->put('wallet_address', $users[0]->wallet_address);
            $request->session()->put('pin_code', $users[0]->pin_code);
            return 1;
        }
        else{
            return 0;
        }
    }

    public function logout(Request $request){
        $request->session()->forget('seed');
        $request->session()->forget('wallet_address');
        $request->session()->forget('pin_code');

        return 1;
    }
}