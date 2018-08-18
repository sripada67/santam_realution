<?php
namespace App\Repositories;

interface ImportRequestsRepository
{
	public function createRequest($request=array());

	public function updateRequest($id,$request=array());

}
