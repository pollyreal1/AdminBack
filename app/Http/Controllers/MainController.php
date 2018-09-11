<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Tenants;

use App\Traits\TenantTraits;

class MainController extends Controller
{
    //
	use TenantTraits;

    public function register(Request $request){

    	$validator = Validator::make($request->all(), [
    		'subscription_type' => ["required","regex:(type1|type2|type3)"],
    		'link'	=> "required|unique:tenants,link",
    		'fname' => 'required',
    		'lname' => 'required',
    		'email' => 'required|unique:tenants,owner_email',
    		'companyname' => 'required',
    		'password' => 'required|confirmed',
    		'password_confirmation' => 'required',
    	],[
    		'fname.required' => "First name is required",
    		'lname.required' => "Last name is required",
    		'companyname.required' => "Company name is required",
    		'password_confirmation.required' => 'Please confirm your password',
    	]);

    	if( !$validator->fails() ){

    		if( $request->post('subscription_type') == 'type1'){

    			// Tenant Traits 
    			$company_id = $this->clientInsertion($request, 'free_db');

    			clientConnect('127.0.0.1','free_db','root');

    			migrateClientTables($request->post('link').$company_id);

    			dd('Freeee Subscription');

    		}else if( $request->post('subscription_type') == 'type2' ){

    			$company_id = $this->clientInsertion($request, 'standard_db');

    			clientConnect('127.0.0.1','standard_db','root');

    			migrateClientTables($request->post('link').$company_id);

    			dd('standard subscription');
    		}else if( $request->post('subscription_type') == 'type3' ){

    			$company_id = $this->clientInsertion($request, 'premium_db');

    			clientConnect('127.0.0.1','premium_db','root');

    			migrateClientTables($request->post('link').$company_id);

    			dd('premium subscription');
    		}else{
    			dd('susbcription not found');
    		}

    		dd('is not fail');

    	}else{

    		dd('failed');

    	}

    }
}
