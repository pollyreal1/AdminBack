<?php

namespace App\Traits;

use App\Tenants;

trait TenantTraits{

	function clientInsertion($request, $database){

		$owner_id = randomNumber();
		$company_id = randomNumber(10);

		Tenants::insert([
			'company_id'	=>	$company_id,
			'owner_id'	=>	$owner_id,
			'company_name' => $request->post('companyname'),
			'owner_email'	=> $request->post('email'),
			'subscription_type' => $request->post('subscription_type'),
			'database'	=>	$database,
			'tbl'	=>	$request->post('link').$company_id,
			'link'	=>	$request->post('link')
		]);

		$data = [
			'company' => $company_id,
			'owner' => [
				'user_id' => $owner_id,
				'email' => $request->post('email'),
				'type' => 0,
				'password' => $request->post('password'),
				'company_id' => $company_id
			],
			'profile' => [
				'user_id' => $owner_id,
				'fname' => $request->post('fname'),
				'lname' => $request->post('lname')
			],
			'company_info' => [
				'company_id' => $company_id,
				'name' => $request->post('companyname')
			]
		];
		return $data;
	}

}

