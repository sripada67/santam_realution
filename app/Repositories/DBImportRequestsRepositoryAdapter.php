<?php
namespace App\Repositories;
use App\Models\ImportRequests;
/**
* 
*/
class DBImportRequestsRepositoryAdapter implements ImportRequestsRepository
{

	public function __construct(){
	}

 	public function createRequest($requestData=array())
 	{
 		$request = ImportRequests::create($requestData);
 		return $request->id;
 	}

 	public function updateRequest($id,$requestData=array())
 	{
 		$request = ImportRequests::where('id',$id)->update($requestData);
 		return $request->id;
 	}

 	public function getTotalRecords($record)
 	{
 		$data = explode(',', $record);
 		if(starts_with($data[0],'T')){
 			return (integer) str_replace("T","",$data[0]);
 		}else{
 			return 0;
 		}
 	}

 	public function convertCIFileName($filename,$name)
 	{
 		$slices = explode('_', $filename);
 		if(count($slices)==3){
 			if(strtolower($slices[2])===$name){
 				return array('sequence_number'=>$slices[0],'date'=>$slices[1],'name'=>$slices[2]);
 			}
 		}
 		return [];
 	}
}