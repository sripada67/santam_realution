<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryRequests extends Model
{
    protected $table = 'delivery_requests';

    protected $fillable = ['customer_no','firstname','lastname','id_no','passport_id','address1','address2','suburb','city','postal_code','province','work_contact','cell_contact','home_contact','extra','scenario_flag','status','file_id','message'];
}
