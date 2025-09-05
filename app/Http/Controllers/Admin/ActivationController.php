<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ActivationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewActivation(){
        $user = Auth::user();
        $ex = explode(" ", $user->name);

        $data = [
            'lastName' => end($ex)
        ];

        return view('admin.activation.activation', $data);
    }

    public function activateAccount(Request $request){
        try{
            $request->validate([
                ""
            ]);
             }catch(ValidationException $e){
                $message = "";
                foreach($e->errors() as $fieldErrors){
                    foreach($fieldErrors as $err){
                        $message .= $err. " | ";
                    }
                } 

                $message = rtrim($message, " | ");
                notify()->warning($message);
                return back();

        }catch(Exception $e){
            notify()->warning($e->getMessage());
            return back();
        }
    }
}