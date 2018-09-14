<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
// Model inside of tenants
use App\Tenant\Users;
use App\Tenant\Branch;
use App\Tenant\Branch_time;
use App\Tenant\Time_tracking;

class EmployeesController extends Controller
{
	// Get Employees per tenant
    // PARAMS: database, tbl
    public function getEmployees(Request $request){

    	if(!empty($request->header('database') && $request->header('tbl'))){

       		clientConnect('127.0.0.1',$request->header('database'),'root');
       		$users = new Users();
       		$users = $users->setTable($request->header('tbl').'_users')->get();

       		return response()->json($users);

    	}else{
    		dd('invalid post');
    	}

    }

    public function insertEmployee(Request $request){

    	if(!empty($request->header('database') && $request->header('tbl'))){

    		$validator = Validator::make($request->all(), [
	            'fname' => 'required',
	            'lname' => 'required',
	            'email' => 'required|unique:client.'.$request->database.'.'.$request->tbl.'_users,email',	        
	            'role_id' => 'required',
	            'reports_to' => 'required',
	            'location' => 'required'
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

    public function getBundee(Request $request){

    	if(!empty($request->header('database') && $request->header('tbl'))){

	    	clientConnect('127.0.0.1',$request->header('database'),'root');

    		$bundee = new Time_tracking();
    		$bundee = $bundee->setTable($request->header('tbl').'_time_tracking')->get();

    		$data = [
    			'msg' => $bundee,
    			'status' => 'success'
    		];

    		return response()->json($bundee);

    	}else{
    		dd('Invalid request parameters');
    	}
    }

    public function getLocation(Request $request){

    	if(!empty($request->header('database') && $request->header('tbl'))){

	    	clientConnect('127.0.0.1',$request->header('database'),'root');
	    	$branch = new Branch();
	    	$branch = $branch->setTable($request->header('tbl').'_branch')->get();

	    	$data = [
	    		'msg' => $branch,
	    		'status' => 'success'
	    	];

	    	return response()->json($data);

	    }else{
	    	dd('Invalid request');
	    }
    }

    public function insertLocation(Request $request){

    	if(!empty($request->header('database') && $request->header('tbl'))){

			clientConnect('127.0.0.1',$request->header('database'),'root');

			$validator = Validator::make($request->all(), [
	            'name' => 'required|unique:client.'.$request->header('database').'.'.$request->header('tbl').'_branch,name',
	            'timetrack_id' => 'required'        
	        ],[
	            'name.required' => "Location name is required"
	        ]);

			if( !$validator->fails() ):
				$branch_id = randomNumber();
				$data = [
					'branch_id' => $branch_id,
					'name' => $request->post('name'),
					'address' => (!empty($request->post('address'))) ? $request->post('address') : null,
				];
				$branch = new Branch();
		    	$branch = $branch->setTable($request->header('tbl').'_branch')->insert($data);

		    	$branchtime = new Branch_time();
		    	foreach($request->post('timetrack_id') as $timetrack_id){
		    		$branchtime->setTable($request->header('tbl').'_branch_time')->insert(['branch_id'=>$branch_id,'timetrack_id'=>$timetrack_id]);
		    	}

		    	$data = [
	       			'response_msg'=>'Adding of location successful!',
	       			'status'=>true
	       		];

		    	return response()->json($data);
		    else:

		    	$data = [
		    		'msg' => 'Failed to add location',
		    		'status' => 'failed',
		    		'errors' => $validator->errors()
		    	];

		    	return response()->json($data);

		    endif;


		}else{

			dd('Invalid request');

		}
    }
}
