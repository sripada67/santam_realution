<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Libraries\Validate;
use App\Repositories\ImportRequestsRepository;
use App\Repositories\DeliveryRequestsRepository;
use Carbon\Carbon;

class ProcessCourierImportFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:process_courier_import_file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process courier import file';

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
    public function handle(ImportRequestsRepository $importRequestsRepository,DeliveryRequestsRepository $deliveryRequestsRepository)
    {
        $fileName = '4544_20180704_SANTAMCOURIER.txt';
        $processed_filename = "4544_20180704_SANTAMCOURIER.txt";
        
        $filename_slices = $importRequestsRepository->convertCIFileName($fileName,"santamcourier.txt");
        if(\Storage::exists($fileName)){
            $file = \Storage::get($fileName);
            $response_file = \Storage::put('4544_20180704_SantamCourierConfirmation.txt', "");

            $list = explode(PHP_EOL, $file);
            $list = array_filter($list);
            $total_records = $importRequestsRepository->getTotalRecords($list[count($list)-1]);

            $file_id =$importRequestsRepository->createRequest(array('fileName'=>$fileName, 'sequence_number'=>$filename_slices['sequence_number'], 'fileType'=>'courier_import', 'total_records'=>$total_records));
            $processed = array();
            $keys = \Config::get('file_keys.courier_import');
            foreach ($list as $item) {
                $data = explode(',', $item);
                
                if(count($data)==16){
                    $data = array_combine($keys, $data);
                    $response = Validate::validateCourierImport($data);
                    $item .= ",".$response;
                    $data['file_id'] = $file_id;
                    $data['status'] = 'initiated';
                    $data['message'] = $response;
                    $deliveryRequestsRepository->createRequest($data);
                }else if(starts_with($data[0],'T')){
                    $data[0] = (integer) str_replace("T","",$data[0]);
                }else{
                    $item .= ",Invalid Data";
                }
                $item = str_replace("\n","",$item);
                $response_file_text = \Storage::get('c_import_procesed.txt');
                \Storage::put('c_import_procesed.txt', $response_file_text."\n".$item);
                $processed[] = $item;
            }
        }else{
            echo "invalid file";
        }
        exit;
    }
}
