<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cloutier\PhpIpfsApi\IPFS;
use DB;

class PIpfs extends Controller
{
   public function get_ipfs(Request $request){
        $ipfs = new IPFS();
        $file = $request->input('file');
        $hash = $ipfs->add($file);
        return $hash;
    }
}