<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Libraries\XMLRPC;
use App\Jobs;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	public function getBalance()
	{
        $transaction_id = uniqid();
        
        $datetime = XMLRPC::get_iso_date();

        $params = array("0043496595","6219555239","5338927263472256",$transaction_id,str_replace("-","",$datetime->scalar));

		$checksum = XMLRPC::create_hash("Balance",$params,"1880756B15");

		array_pop($params);

		array_push($params,$datetime,$checksum);
        
		$response =  XMLRPC::callMethod("Balance",$params,"vexdev.tutuka.com","/handlers/remote/profilexmlrpc.cfm","UTF-8");

		return $response;
	}

    public function getFileContent(Request $request)
    {
        $file = \Storage::get('c_import.TXT');
        $this->dispatch(new Jobs\ProcessCourierImportFileJob($file));
    }
}
