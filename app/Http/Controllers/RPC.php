<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cloutier\PhpIpfsApi\IPFS;
use DB;

class RPC extends Controller
{
    public function index()
    {
        //R9vyyfdSYeQ3gYHF5yJ3NBtkf2EpinSD9V
    }

    public function get_my_assets(Request $request){
        $seed = $request->session()->get('seed');
        if(!isset($seed)){
            return "error";
        }
        $sql_query = 'select * from all_asset_transactions where owner="'.$seed.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            $arr = [];
            for($i = 0; $i < count($users); $i ++){
                array_push($arr, $users[$i]);
            }
            return json_encode($arr);
        }
        else{
            return 1;
        }
    }

    public function get_my_admin_assets(Request $request){
        $seed = $request->session()->get('seed');
        if(!isset($seed)){
            return "error";
        }
        $sql_query = 'select * from asset_list where admin="'.$seed.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            $arr = [];
            for($i = 0; $i < count($users); $i ++){
                array_push($arr, $users[$i]);
            }
            return json_encode($arr);
        }
        else{
            return 1;
        }
    }

    public function try_create_asset(Request $request){
        $data = $request->input('data');
        $seed = $request->session()->get('seed');
        $myaddress = "";

        if(!isset($seed)){
            return "unkown";
        }

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getbalance", "params" => [$seed] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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

        $current_amount = $decoded_result["result"];

        $sql_query = 'select * from site_users where seed="'.$seed.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            $myaddress = $users[0]->wallet_address;
            if(floatval($current_amount) < floatval(525)){
                // return response()->json($decoded_result, 200);
                return "Charge Error";
            }
        }
        else{
            return "DB error";
        }

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "move", "params" => [$seed, "", 525] );
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

        $ipfs = $data['ipfs'];
        $asset_symbol = $data['asset_symbol'];
        $asset_unit = intval($data['asset_units']);
        $asset_quantity = intval($data['asset_quantity']);
        $reissuable = $data['reissuable'];

        if($reissuable)
            $reissuable = 1;
        else
            $reissuable = 0;

        if($ipfs != ""){
            $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "issue", "params" => [$asset_symbol, $asset_quantity, $myaddress, $myaddress, $asset_unit, $reissuable, true, $ipfs] );
        }
        else{
            $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "issue", "params" => [$asset_symbol, $asset_quantity, $myaddress, $myaddress, $asset_unit, $reissuable] );
        }

        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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
        if($decoded_result["error"] == null){
            DB::insert('insert into all_asset_transactions (asset_name, amount, admin_token_role, owner) values(?, ?, ?, ?)', [$asset_symbol, $asset_quantity, 2, $seed]);

            DB::insert('insert into asset_list (asset_name, amount, unit, avatar_url, full_asset_name, description, issuer, website_url, image_url, contact_name, contact_address, contact_email, contact_phone, type, restricted, reissuable, ipfs, contact_url, sale_price, admin) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$data['asset_symbol'], $data['asset_qty'], $data['asset_sub_units'], '', $data['full_asset_name'], $data['description'], $data['issuer'], $data['website_url'], $data['image_url'], $data['contact_name'], $data['contact_address'], $data['contact_email'], $data['contact_phone'], $data['type'], $data['restricted'], $data['reissuable'], $data['ipfs'], '', $data['sale_price'], $seed]);

            return "success";
        }
        return $decoded_result["error"];
    }


    public function try_send_asset(Request $request){
        $seed = $request->session()->get('seed');
        $pin = $request->session()->get('pin_code');
        $myaddress = "";
        if(!isset($seed)){
            return "unkown";
        }

        $input_pin = $request->input('pin');
        $asset_symbol = $request->input('asset_name');
        $send_address = $request->input('send_address');
        $amount = $request->input('amount');
        if($pin != $input_pin){
            return "pin not matched!";
        }

        $sql_query = 'select * from all_asset_transactions where owner="'.$seed.'" and asset_name="'.$asset_symbol.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            if($users[0]->amount < $amount){
                return "No Such Amount in your wallet!";
            }
            else{
                $temp = intval($users[0]->amount) - intval($amount);
                $sql_query = 'select * from site_users where wallet_address="'.$send_address.'"';
                $users = DB::select($sql_query);

                if(count($users) > 0){
                    $new_owner = $users[0]->seed;
                    $sql_query = 'select * from all_asset_transactions where owner="'.$new_owner.'" and asset_name="'.$asset_symbol.'"';
                    $users = DB::select($sql_query);
                    DB::table('all_asset_transactions')->where(['owner' => $seed, 'asset_name' => $asset_symbol])->update(array('amount'=>$temp));

                    if(count($users) > 0){
                        $temp = intval($users[0]->amount) + intval($amount);
                        DB::table('all_asset_transactions')->where(['owner' => $new_owner, 'asset_name' => $asset_symbol])->update(array('amount'=>$temp));
                        return "success";
                    }
                    else{
                        $temp = intval($amount);
                        DB::insert('insert into all_asset_transactions (asset_name, amount, admin_token_role, owner) values(?, ?, ?, ?)', [$asset_symbol, $amount, 1, $new_owner]);
                        return "success";
                    }
                }
                else{
                    return "Invalid Address!";
                }
                // DB::table('site_users')->where('seed', $seed)->update(array('amount'=>$temp));
            }
        }
        else{
            return "No Wallet Balance!";
        }
    }

    public function send_raven(Request $request){
        $pin_code = $request->session()->get('pin_code');
        if($pin_code != $request->input('pin_code')){
            return "pin_error";
        }

        $seed = $request->session()->get('seed');
        $amount = $request->input('send_amount');
        $send_to_address = $request->input('send_to');

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getbalance", "params" => [$seed] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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

        if($amount > $decoded_result["result"]){
            return "amount_error";
        }

        $send_to = "";
        $sql_query = 'select * from site_users where wallet_address="'.$send_to_address.'"';
        $users = DB::select($sql_query);
        if(count($users) > 0){
            $send_to = $users[0]->seed;
        }

        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "move", "params" => [$seed, $send_to, $amount] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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
        return $decoded_result["error"];
    }

    public function get_raven_amount(Request $request){
        $seed = $request->session()->get('seed');
        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getbalance", "params" => [$seed] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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

        return $decoded_result;
    }

    public function get_all_assets(Request $request){
        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "listassets", "params" => [] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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

        return $decoded_result["result"];
    }

    public function get_asset_details(Request $request){
        $asset_name = $request->input("asset_name");
        $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getassetdata", "params" => [$asset_name] );
        $curl = curl_init();
            // We POST the data
        curl_setopt($curl, CURLOPT_POST, 1);
        // set header
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

        return $decoded_result["result"];
    }

    public function transfer_admin(Request $request){
        $transfer_to = $request->input('transfer_to');
        $pin = $request->input('pin');
        $current_seed = $request->session()->get('seed');
        $current_pin = $request->session()->get('pin_code');
        if($pin != $current_pin){
            return "Pin Error!";
        }
        $sql_query = 'select * from site_users where wallet_address="'.$transfer_to.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            if($users[0]->seed == $current_seed){
                return "Address Duplicated!";
            }
            else{
                $sql_query = 'select * from asset_list where admin="'.$current_seed.'"';
                $users1 = DB::select($sql_query);
                if(count($users1) > 0){
                    DB::table('asset_list')->where('admin', $current_seed)->update(array('admin'=>$users[0]->seed));
                    return "success";
                }
                else{
                    return "something went wrong! Refresh and try again!";
                }
            }
        }
        else{
            return "Wrong Address!";
        }
    }

    public function get_details_of_specific(Request $request){
        $asset_name = $request->input('asset_name');
        $seed = $request->session()->get('seed');
        $sql_query = 'select * from asset_list where asset_name="'.$asset_name.'" and admin="'.$seed.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            return response()->json($users[0]);
        }
        else{
            return "error!";
        }
    }

    public function try_reissue(Request $request){
        $asset_name = $request->input('asset_name');
        $new_unit = intval($request->input('new_unit'));
        $new_amount = intval($request->input('new_amount'));
        $new_ipfs = $request->input('ipfs');
        $reissuable = $request->input('reissuable');

        $seed = $request->session()->get('seed');
        $pin = $request->input('pin');
        $current_pin = $request->session()->get('pin_code');
        $myaddress = $request->session()->get('wallet_address');

        if($pin != $current_pin){
            return "pin error!";
        }

        if($new_unit < 1){
            return "unkown!";
        }

        if($new_amount < 1){
            return "unkown!";
        }

        $sql_query = 'select * from asset_list where asset_name="'.$asset_name.'" and admin="'.$seed.'"';
        $users = DB::select($sql_query);

        if(count($users) > 0){
            if($users[0]->unit > $new_unit){
                return "db error2!";
            }
            else{
                $current_amount = $users[0]->amount;

                $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "getbalance", "params" => [$seed] );
                $curl = curl_init();
                    // We POST the data
                curl_setopt($curl, CURLOPT_POST, 1);
                // set header
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

                $wallet_amount = $decoded_result["result"];

                $sql_query = 'select * from site_users where seed="'.$seed.'"';
                $users = DB::select($sql_query);

                if(count($users) > 0){
                    $myaddress = $users[0]->wallet_address;
                    if(floatval($wallet_amount) < floatval(525)){
                        // return response()->json($decoded_result, 200);
                        return "Charge Error";
                    }
                }
                else{
                    return "DB error";
                }

                $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "move", "params" => [$seed, "", 525] );
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

                if($reissuable){
                    $reissuable = true;
                }
                else{
                    $reissuable = false;
                }
                if($new_ipfs == ""){
                    $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "reissue", "params" => [$asset_name, $new_amount, $myaddress, $myaddress, $reissuable, $new_unit] );
                }
                else{
                    $request_data = array("jsonrpc" => "1.0", "id" => "curltest", "method" => "reissue", "params" => [$asset_name, $new_amount, $myaddress, $myaddress, $reissuable, $new_unit, $new_ipfs] );
                }
                $curl = curl_init();
                    // We POST the data
                curl_setopt($curl, CURLOPT_POST, 1);
                // set header
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

                if($decoded_result["error"] == null){
                    DB::table('asset_list')->where(['admin' => $seed, 'asset_name' => $asset_name])->update(array('amount'=>$new_generated_amount, 'unit'=>$new_unit, 'reissuable'=>$reissuable, 'ipfs'=>$new_ipfs));

                    $sql_query = 'select * from all_asset_transactions where owner="'.$seed.'" and asset_name="'.$asset_name.'"';
                    $users = DB::select($sql_query);

                    if(count($users) > 0){
                        $temp = intval($current_amount) + intval($new_amount);
                        DB::table('all_asset_transactions')->where(['asset_name' => $asset_name, 'owner'=>$seed])->update(array('amount'=>$temp));
                    }
                    else{
                        DB::insert('insert into all_asset_transactions (asset_name, amount, admin_token_role, owner) values(?, ?, ?, ?)', [$asset_name, $new_amount, 2, $seed]);
                    }
                    return "success";
                }
                return response()->json($decoded_result["error"]);
            }
        }
        else{
            return "error!";
        }
    }
}