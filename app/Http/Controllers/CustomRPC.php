<?php
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Cloutier\PhpIpfsApi\IPFS;

	// use App\Http\Controllers\RavencoinRPC;

	class CustomRPC extends Controller
	{
	    public function index()
	    {
	    }

	    public function user_register(Request $request){
	        require_once('RavencoinRPCP.php');
			$ravencoin = new RavencoinRPC('trey','trey2019raven','34.217.223.244','8766');
			$res = $ravencoin->getinfo();
			echo json_encode($res);
			// if ($ravencoin->status == 500) {
			// 	echo "Connection to RPC Server Established!";
			// } else {
			// 	echo "HTTP Error: ".$ravencoin->status;
			// }
	    }
	}