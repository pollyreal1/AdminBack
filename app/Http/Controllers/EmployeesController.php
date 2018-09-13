<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
// Model inside of tenants
use App\Tenant\Users;

class EmployeesController extends Controller
{
	// Get Employees per tenant
    // PARAMS: database, tbl
    public function getEmployees(Request $request){

    	if(!empty($request->database && $request->tbl)){

       		clientConnect('127.0.0.1',$request->database,'root');
       		$users = new Users();
       		$users = $users->setTable($request->tbl.'_users')->get();

       		return response()->json($users);

    	}else{
    		dd('invalid post');
    	}

    }

    public function insertEmployee(Request $request){

    	if(!empty($request->database && $request->tbl)){

    		clientConnect('127.0.0.1',$request->database,'root');

    		$validator = Validator::make($request->all(), [
	            'fname' => 'required',
	            'lname' => 'required',
	            'email' => 'required|unique:client.'.$request->database.'.'.$request->tbl.'_users,email',	        
	        ],[
	            'fname.required' => "First name is required",
	            'lname.required' => "Last name is required"
	        ]);

	        if( !$validator->fails() ):

	    		$data = [
	    			'user_id' => randomNumber(),
	    			'email' => $request->email,
	    			'password' => 'sample1',
	    			'company_id' => $request->company_id,
	    		];
	    		$users = new Users();
	       		$users = $users->setTable($request->tbl.'_users')->insert($data);

	       		$data = [
	       			'response_msg'=>'Adding of employee successful!',
	       			'status'=>true
	       		];
	       		return response()->json($data);

	       	else:

	       		$data = [
	       			'response_msg' => 'Adding of employee failed!',
	       			'errors' => $validator->errors(),
	       			'status' => false
	       		];

	       		return response()->json($data);
	       	endif;

    	}else{
    		dd('invalid post');
    	}

    }
}
