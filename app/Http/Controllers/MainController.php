<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

// Models of tenant management
use App\Tenants;

// Models of inside tenant/client
use App\Tenant\Users;
use App\Tenant\Profile;
use App\Tenant\Company;

// Traits for tenant: connect and migrate
use App\Traits\TenantTraits;

class MainController extends Controller
{
    //
    use TenantTraits;

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'subscription_type' => ["required","regex:(type1|type2|type3)"],
            'link'  => "required|unique:tenants,link",
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
                $response_array = $this->clientInsertion($request, 'free_db');

                // Table prefix : needed for concatination
                $tbl = $request->post('link').$response_array['company'];

                // Connect to DB and create tables for the tenant
                clientConnect('127.0.0.1','free_db','root');
                migrateClientTables($tbl);

                // Insert owner to the own DB and users table
                $users = new Users();
                $users->setTable($tbl.'_users')->insert([$response_array['owner']]);

                $profile = new Profile();
                $profile->setTable($tbl.'_profile')->insert([$response_array['profile']]);

                $company = new Company();
                $company->setTable($tbl.'_company')->insert([$response_array['company_info']]);

                $data = [
                    'response_msg'=>'Successful on registring for free!',
                    'db_connection' => $request->post('companyname'),
                    'status'=>true
                ];

                return response()->json($data);

            }else if( $request->post('subscription_type') == 'type2' ){

                // Tenant Traits 
                $response_array = $this->clientInsertion($request, 'standard_db');

                // Table prefix : needed for concatination
                $tbl = $request->post('link').$response_array['company'];

                // Connect to DB and create tables for the tenant
                clientConnect('127.0.0.1','standard_db','root');
                migrateClientTables($tbl);

                // Insert owner to the own DB and users table
                $users = new Users();
                $users->setTable($tbl.'_users')->insert([$response_array['owner']]);

                $profile = new Profile();
                $profile->setTable($tbl.'_profile')->insert([$response_array['profile']]);

                $company = new Company();
                $company->setTable($tbl.'_company')->insert([$response_array['company_info']]);

                $data = [
                    'response_msg'=>'Successful on registring for standard subscription!',
                    'db_connection' => $request->post('companyname'),
                    'status'=>true
                ];

                return response()->json($data);

            }else if( $request->post('subscription_type') == 'type3' ){

                // Tenant Traits 
                $response_array = $this->clientInsertion($request, 'premium_db');

                // Table prefix : needed for concatination
                $tbl = $request->post('link').$response_array['company'];

                // Connect to DB and create tables for the tenant
                clientConnect('127.0.0.1','premium_db','root');
                migrateClientTables($tbl);

                // Insert owner to the own DB and users table
                $users = new Users();
                $users->setTable($tbl.'_users')->insert([$response_array['owner']]);

                $profile = new Profile();
                $profile->setTable($tbl.'_profile')->insert([$response_array['profile']]);

                $company = new Company();
                $company->setTable($tbl.'_company')->insert([$response_array['company_info']]);

                $data = [
                    'response_msg'=>'Successful on registring for premium subscription!',
                    'db_connection' => $request->post('companyname'),
                    'status'=>true
                ];

                return response()->json($data);

            }else{
                dd('susbcription not found');
            }
                    
        }else{

            $data = [
                'response_msg'=>'Failure on registration!',
                'errors'=>$validator->errors(),             
                'status'=>false
            ];
            return response()->json($data);

        }

    }


    public function tenantChecker(Request $request){

        $tenant = Tenants::where('link',$request->link)->first();

        return response()->json($tenant);
    }
}
