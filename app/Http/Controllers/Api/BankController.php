<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Bank\AdminBankDetail;
use App\Models\Bank\User_Bank_Details;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use stdClass;

class BankController extends Controller
{
    protected $res;
    function __construct()
    {
        $this->res = new stdClass;
    }

    function delete_my_account($id)
    {

        User_Bank_Details::where('id', $id)->delete();
        $this->res->message = 'Account deleted!';
        return $this->res;
    }

    function save_account(Request $request)
    {
    
        try {
            $validate = Validator::make($request->all(), [
                'account_title' => "required",
                'account_number' => 'required',
                'bank_id' => 'required|exists:banks,id'
            ]);
            if ($validate->fails()) {
                $this->res->error = $validate->errors();
            } else {
                $data = $request->all();
                $data['user_id'] = Auth::id();
                User_Bank_Details::create($data);
                $this->res->message = 'Bank accound added!';
            }
        } catch (Exception $ex) {
            $this->res->error = $ex->getMessage();
        } finally {
            return $this->res;
        }
    }
    function get_available_banks(Request $request)
    {
        return AdminBankDetail::all();
    }

    function get_banks(){
        return Bank::all();
    }
    function get_bank_accounts_of_admin(Request $request)
    {
        return AdminBankDetail::with(['bank'])
            ->get();
    }
    function get_bank_accounts_of_mine(Request $request)
    {
        return User_Bank_Details::where('user_id', Auth::id())->with(['bank'])
            ->get();
    }
}
