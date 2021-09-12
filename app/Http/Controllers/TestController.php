<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class TestController extends Controller
{
    public function getTestPage(Request $request){
        // $u = DB::table('user_balance')->get();
        // dd($u);
        return view('testForm');
    }

    public function addAcount(Request $request){
        $validator = Validator::make($request->all(), [
            'account_id' => 'required|numeric|unique:account,account_id',
            'introducer_id' => 'required|numeric',
            
        ]);
        if(!$validator->fails()){
            $data = $request->toArray();
            $introducer = DB::table('account')->where('account_id',$data['introducer_id'])->first();

            $introducer_network = DB::table('account')->where('introducer_id',$data['introducer_id'])->get();
            if(empty($introducer)){
                $introducer_id = 0;
                $benificary_id = 0;
            }elseif((count($introducer_network) + 1)%2 == 0){
                $introducer_id = $introducer->introducer_id;
                $benificary_id = $introducer->introducer_id;
            }else{
                $introducer_id = $data['introducer_id'];
                $benificary_id = $data['introducer_id'];
            }
            // dd($introducer);
            $save_account_array = [
                'account_id' => $data['account_id'],
                'introducer_id' => $introducer_id,
                'benificary_id' => $benificary_id,
                'created_at' => now()
            ];

            $save_account = DB::table('account')->insertGetId($save_account_array);

            $save_balance_array = [
                'account_id' => $benificary_id,
                'amount' => 100,
                'payment_type' => 1,
                'created_at' => now()
            ];
            $save_account = DB::table('user_balance')->insertGetId($save_balance_array);
            // dd($save_account);
            $msg = "Account Saved ,Benificiary Id = ".$benificary_id;
            Session::flash('message', $msg);
            return redirect()->back();

        }
        else{
        	return redirect()->back()->withInput()->withErrors($validator);
        }
    }
}
