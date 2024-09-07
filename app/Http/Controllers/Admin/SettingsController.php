<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        $user = auth()->user();
        $ex = explode(" ", $user->name);
        $phones = json_decode(companyInfo()->company_phones);

        $data = [
            'lastName' => end($ex),
            'phone_i' => $phones[0],
            'phone_ii' => $phones[1],
        ];

        return view('admin.company.info', $data);
    }

    public function saveCompanyInfo(Request $request){
        try{
            $info = Setting::findOrFail($request->row_id);
            if($request->file('logo') != null){
                if(!empty($info->company_logo)){
                    unlink(public_path('ui/'. $info->company_logo));
                }
                
                $image = $request->file('logo');
                $imageName = time() . '.' . $image->extension();
                $img = Image::make($image->path());
                $img->resize(300, 300);
                $img->save(public_path('ui/' . $imageName));
                $info->company_logo = $imageName;
                $compressedImageSize = filesize(public_path('ui/' . $imageName));
            }else{
                $info->company_logo = $info->company_logo;
            }

            if($request->file('signature') != null){
                if(!empty($info->company_signature)){
                    unlink(public_path('ui/'. $info->company_signature));
                }
                
                $image = $request->file('signature');
                $imageName = time() . '.' . $image->extension();
                $img = Image::make($image->path());
                $img->resize(300, 300);
                $img->save(public_path('ui/' . $imageName));
                $info->company_signature = $imageName;
                $compressedImageSize = filesize(public_path('ui/' . $imageName));
            }else{
                $info->company_signature = $info->company_signature;
            }
            
            $info->company_name = $request->company_name;
            $info->company_email = $request->company_email;
            $info->company_address = $request->company_address;
            $info->logo_status = $request->logo_status;
            $info->discount_mode = $request->discount_mode;
            $info->discount_visibility = $request->discount_visibility;
            $info->signature_status = $request->signature_status;
            $info->company_phones = json_encode([
                $request->company_phone_i,
                $request->company_phone_ii,
            ]);
            // Save changes
            $info->save();
            notify()->success('Changes successfully saved!');
            return back();
        }catch(Exception $e){
            notify()->error($e->getMessage());
            return back();
        }
    }
}