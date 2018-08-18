<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Libraries\Validate;

class ProcessCourierImportFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $list = explode(PHP_EOL, $this->file);
        $processed = array();
        $keys = \Config::get('file_keys.courier_import');
        $list = array_filter($list);
        foreach ($list as $item) {
            $data = explode(',', $item);

            if(count($data)==16){
                $data = array_combine($keys, $data);
                $response = Validate::validateCourierImport($data);
                $item .= ",".$response;
            }else{
                $item .= ",Invalid Data";
            }
            echo $item."<br><br>";
            $processed[] = $item;
        }
    }
}