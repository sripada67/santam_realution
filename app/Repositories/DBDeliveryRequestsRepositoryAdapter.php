<?php
namespace App\Repositories;
use App\Models\DeliveryRequests;
/**
* 
*/
class DBDeliveryRequestsRepositoryAdapter implements DeliveryRequestsRepository
{

	public function __construct(){
	}

 	public function createRequest($requestData=array())
 	{
 		$request = DeliveryRequests::create($requestData);
 		return $request->id;
 	}

 	public function updateRequest($id,$requestData=array())
 	{
 		$request = DeliveryRequests::where('id',$id)->update($requestData);
 		return $request->id;
 	}
}