<?php

namespace App\Http\Controllers\Dashboard\MediaManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebmasterSection;
use App\Models\MediaManager;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MediaManagerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');

        // Check Permissions
        // if (!@Auth::user()->permissionsGroup->media_manager) {
        //     return Redirect::to(route('NoPermission'))->send();
        // }
    }

    /**
     *  Index method.
     *
     * @param  void
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('media_managers-read'))
            abort(403);
        // General for all pages
        // $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')
        //     ->orderby('row_no', 'asc')
        //     ->get();
        // Get media files with pagination
        // if (@Auth::user()->permissionsGroup->view_status) {
            $MediaFiles = MediaManager::orderby('id', 'DESC')
                ->with('userDetails')->get();
                // ->paginate(env('BACKEND_PAGINATION'));
        // } else {
        //     $MediaFiles = MediaManager::orderby('id', 'DESC')
        //         ->with('userDetails')
        //         ->paginate(env('BACKEND_PAGINATION'));
        // }

        // General END
        return view('dashboard.media-manager.list', compact( 'MediaFiles'));
    }

    public function get_media_data(Request $request)
    {
        $imgvalue = $request->imgvalue;
        if (!empty(Session::get('mediavalue'))) {
            Session::forget('mediavalue');
            Session::put('mediavalue', $imgvalue);
            echo Session::get('mediavalue');
        } else {
            Session::put('mediavalue', $imgvalue);
            echo Session::get('mediavalue');
        }
    }

    public function check_media_data(Request $request)
    {
        $file_name = Session::get('mediavalue');
        echo $file_name;
    }

    public function pdf_upload(Request $request)
    {
        if ($request->TotalFiles > 0) {
            if ($request->TotalFiles > 10) {
                return response()->json(['message' => 'Maximum number of file can not be more than 10.']);
            }
            $total_file_size = 0;

            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $total_file_size += (int)$request->file('files' . $x)->getSize();
                }
            }

            // return $total_file_size;

            if ($total_file_size > 25000000) {
                return response()->json(['message' => 'File size is too large. Can not upload .'], 404);
            }
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $fileName = $request->file('files' . $x)->getClientOriginalName();
                    $file = $request->file('files' . $x);
                    if (file_exists(public_path('/uploads/pdf/' . $fileName))) {
                        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . "_" . rand(0, 99) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                    }
                    $path = $file->store('public/uploads/pdf/');
                    $name = $fileName;
                    $insert[$x]['name'] = $name;
                    $insert[$x]['path'] = $path;
                    $file->move(public_path('/uploads/pdf/'), $name);
                    try {
                        $files['file_name'] = $name;
                        $files['created_by'] = 1;
                        $files['file_type'] = mime_content_type(public_path('/uploads/pdf/') . $name);
                        $files['media_url'] = url('/') . '/uploads/pdf/' . $name;
                        $files['status'] = 1;
                        $files['file_ext'] = pathinfo(public_path('/uploads/pdf/') . $name, PATHINFO_EXTENSION);
                        $files['media_uid'] = Str::uuid();
                        $files['path'] = 'uploads/pdf/' . $name;
                        MediaManager::create($files);
                    } catch (Exception $e) {
                        Log::error($e->getMessage());
                        return $e->getMessage();
                    }
                }
            }
            return response()->json(['status' => 'success', 'message' => 'File is successfully uploaded']);
        } else {
            return response()->json(['message' => 'Something went wrong. Please try again.']);
        }
    }

    public function update_all(Request $request)
    {
        if ($request->action == 'delete') {
            // Check Permissions
            // if (!@Auth::user()->permissionsGroup->delete_status) {
            //     return Redirect::to(route('NoPermission'))->send();
            // }
            // $MediaFiles = MediaManager::wherein('media_uid', $request->media_uids)->get();
            // foreach ($MediaFiles as $MediaFile) {
            //     if ($MediaFile->file_name != "") {
            //         File::delete($MediaFile->path . $MediaFile->file_name);
            //     }
            // }
            // $reponse = MediaManager::wherein('media_uid',$request->media_uids)->update(['deleted_by',Auth::user()->id]);
            // $res = MediaManager::wherein('media_uid', $request->media_uids)->delete();
            $res = 0;
            if ($res != 0) {
                return redirect()
                    ->action('Dashboard\MediaManager\MediaManagerController@index')
                    ->with('doneMessage', __('Modifications you have made saved successfully'));
            } else {
                return redirect()
                    ->action('Dashboard\MediaManager\MediaManagerController@index')
                    ->with('doneMessage', __('There is an error, please try again'));
            }
        }
    }

    public function media_file_change(Request $request)
    {
        $media_file = MediaManager::where('media_uid', $request->media_uid)->first();
        $file_name = $request->file_name;
        $media_manager_array = [];
        if (strlen($file_name) > 50) {
            return response()->json(['status' => 'error', 'message' => 'File name is too large. Max limit 50 characters.']);
        }
        $final_file_name = preg_replace('/\s+/', '_', $file_name);

        $temp_name = explode('.', $file_name);
        if (count($temp_name) > 1) {
            $final_file_name = $temp_name[0];
        }

        try {
            //code...
            switch ($media_file->file_ext) {
                case 'pdf':
                    if (!file_exists(public_path('/uploads/pdf/' . $media_file->file_name))) {
                        return response()->json(['status' => 'error', 'message' => 'File does not exist']);
                    }

                    if (file_exists(public_path('/uploads/pdf/' . $final_file_name . '.' . $media_file->file_ext))) {
                        return response()->json(['status' => 'error', 'message' => 'File is already exists with this name. Please change it.']);
                    }

                    $media_manager_array['file_name'] = $final_file_name . '.' . $media_file->file_ext;
                    $media_manager_array['path'] = 'uploads/pdf/' . $final_file_name . '.' . $media_file->file_ext;
                    $media_manager_array['media_url'] = url('') . '/uploads/pdf/' . $final_file_name . '.' . $media_file->file_ext;
                    $res = MediaManager::where('media_uid', $request->media_uid)->update($media_manager_array);
                    if ($res == true) {
                        rename(public_path('/uploads/pdf/' . $media_file->file_name), public_path('/uploads/pdf/' . $final_file_name . '.' . $media_file->file_ext));
                        return response()->json(['status' => 'success', 'message' => 'Updated']);
                    }

                    break;

                default:
                    if (!file_exists(public_path('uploads/media/' . $media_file->file_name))) {
                        return response()->json(['status' => 'error', 'message' => 'File does not exist']);
                    }

                    if (file_exists(public_path('/uploads/media/' . $final_file_name . '.' . $media_file->file_ext))) {
                        return response()->json(['status' => 'error', 'message' => 'File is already exists with this name. Please change it.']);
                    }

                    $media_manager_array['file_name'] = $final_file_name . '.' . $media_file->file_ext;
                    $media_manager_array['path'] = 'uploads/media/' . $final_file_name . '.' . $media_file->file_ext;
                    $media_manager_array['media_url'] = url('') . '/uploads/media/' . $final_file_name . '.' . $media_file->file_ext;
                    $res = MediaManager::where('media_uid', $request->media_uid)->update($media_manager_array);
                    if ($res == true) {
                        rename(public_path('/uploads/media/' . $media_file->file_name), public_path('/uploads/media/' . $final_file_name . '.' . $media_file->file_ext));
                        return response()->json(['status' => 'success', 'message' => 'Updated']);
                    }
            }
        } catch (Exception $e) {
            // Log::info($e->getMessage());
        }
        return response()->json(['status' => 'error', 'message' => 'Something went wrong! please contact our dev team']);
    }

    public function media_alttag_change(Request $request)
    {
        $media_file = MediaManager::where('media_uid', $request->media_uid)->first();
        $file_name = $request->alt_tag;
        $media_manager_array = [];
        if (strlen($file_name) > 50) {
            return response()->json(['status' => 'error', 'message' => 'Alt tag is too large. Max limit 50 characters.']);
        }
        $media_manager_array['alt_tag'] = $file_name;
        $res = MediaManager::where('media_uid', $request->media_uid)->update($media_manager_array);
        if ($res == true) {
            return response()->json(['status' => 'success', 'message' => 'Updated']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! please contact our dev team']);
        }
    }


    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
