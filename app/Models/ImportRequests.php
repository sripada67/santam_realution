<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportRequests extends Model
{
    protected $table = 'import_requests';

    protected $fillable = ['fileName', 'sequence_number', 'fileType', 'response_file', 'total_records'];
}
