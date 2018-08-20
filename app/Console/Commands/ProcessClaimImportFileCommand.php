<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Libraries\Validate;

class ProcessClaimImportFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:process_claim_import_file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process claims file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $processed_filename = "claims_import_procesed.txt";
        $download_file = @file_get_contents("http://197.242.146.204/santam/claims_import.TXT");
        \Storage::put("claims_import.TXT",$download_file);
        $response_file = \Storage::put($processed_filename, "");
        $file = \Storage::get('claims_import.TXT');

        $list = explode(PHP_EOL, $file);
        $processed = array();
        $keys = \Config::get('file_keys.claims_import');
        $list = array_filter($list);
        foreach ($list as $item) {
            $data = explode(',', $item);

            if(count($data)==5){
                $data = array_combine($keys, $data);
                $response = Validate::validateClaimsImport($data);
                $item .= ",".$response;
            }else if(starts_with($data[0],'T')){
                $data[0] = (integer) str_replace("T","",$data[0]);
            }else{
                $item .= ",Insufficient Data";
            }
            $response_file_text = \Storage::get($processed_filename);
            \Storage::put($processed_filename, $response_file_text."\n".$item);
            $processed[] = $item;
        }
        $file_local = \Storage::get($processed_filename);
        $file_ftp = \Storage::disk('ftp')->put($processed_filename, $file_local);
        exit;
    }
}
