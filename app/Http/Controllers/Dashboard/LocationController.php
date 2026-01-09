<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function manageCountries(Request $request){
        $country = Country::with('getCreaterDetails')->orderBy('name','asc')->paginate(10);
        return view('dashboard.location-manager.manage-country', ['country' => $country]);
    }

    public function createCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Checkif country exist
        $is_country_exist = Country::where('name',$request->name)->first();
        if($is_country_exist==null){
            $countryData = array(
                'name' => $request->name,
                'slug' =>  Str::slug($request->name) ,
                'status' => $request->status , 
                'created_by' => Auth::id(),
            );
            try{
                Country::create($countryData);
                return redirect()->route('admin.manage.countries')->with('doneMessage', 'Country has been successfully created');
            }catch(Exception $e){
                Log::info('Error in country creation create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
                return redirect()->route('admin.manage.countries')->with('errorMessage', 'Unable to create Country please contact our technical team');
            }
        }else{
            return redirect()->route('admin.manage.countries')->with('errorMessage', 'Country name has been taken');
        }
        
        

    }

    public function deleteCountry(Request $request){
        if($request->id==''){
            return ['status'=>'error','message'=>'country details required'];
        }else{
            $is_country_exist = Country::whereId($request->id)->first();
            if($is_country_exist==null){
                return ['status'=>'error','message'=>'country is invalid'];
            }else{
                $updated_data = array(
                    'deleted_by' => Auth::id()
                );
                Country::whereId($request->id)->update($updated_data);
                $is_country_exist->delete();
                return ['status'=>'success','message'=>'country deleted successfully'];
            }
        }
    }

    public function editCountry(Request $request){
        if($request->id==''){
            return ['status'=>'error','message'=>'country details required'];
        }else{
            $is_country_exist = Country::whereId($request->id)->first();
            if($is_country_exist==null){
                return ['status'=>'error','message'=>'country is invalid'];
            }else{
                return ['status'=>'success','message'=>'country fetched successfully','result'=>$is_country_exist];
            }
        }
    }

    public function updateCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Checking if country exist

        $is_country_exist = Country::where('name',$request->name)->first();

        if($is_country_exist!=null){
            if($is_country_exist->id==$request->country_id){
                $countryData = array(
                    'name' => $request->name,
                    'slug' =>  Str::slug($request->name) ,
                    'status' => $request->country_status , 
                    'updated_by' => Auth::id(),
                );
                try{
                    Country::whereId($request->country_id)->update($countryData);
                    return redirect()->route('admin.manage.countries')->with('doneMessage', 'Country has been successfully updated');
                }catch(Exception $e){
                    Log::info('Error in country update create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
                    return redirect()->route('admin.manage.countries')->with('errorMessage', 'Unable to update Country please contact our technical team');
                }
            }else{
                return redirect()->route('admin.manage.countries')->with('errorMessage', 'Country name hes been taken');
            }
        }else{
            $countryData = array(
                'name' => $request->name,
                'slug' =>  Str::slug($request->name) ,
                'status' => $request->country_status , 
                'updated_by' => Auth::id(),
            );
            try{
                Country::whereId($request->country_id)->update($countryData);
                return redirect()->route('admin.manage.countries')->with('doneMessage', 'Country has been successfully updated');
            }catch(Exception $e){
                Log::info('Error in country update create on :- ' . date('Y-m-d') . 'Error message :-> ' . $e->getMessage());
                return redirect()->route('admin.manage.countries')->with('errorMessage', 'Unable to update Country please contact our technical team');
            }
        }

        
        

    }

}
