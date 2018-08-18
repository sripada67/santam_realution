<?php
namespace App\Repositories;

interface DeliveryRequestsRepository
{
	public function createRequest($request=array());

	public function updateRequest($id,$request=array());

}
