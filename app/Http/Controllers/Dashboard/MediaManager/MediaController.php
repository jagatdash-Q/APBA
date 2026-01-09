<?php

namespace App\Http\Controllers\Dashboard\MediaManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    //
    // public $table = 'media';

    /**
     * Constructor, initializes media model     
     */
    public function __construct()
    {
        // Check Permissions
        // if (!@Auth::user()->permissionsGroup->media_manager) {
        //     return Redirect::to(route('NoPermission'))->send();
        // }
    }

    /**
     * Get media manager settings, load folder structure 
     * media list of path selected and display the page
     */
    public function index(Request $request)
    {
        $path = "";
        Session::forget('choose_type');
        Session::forget('catId');
        Session::forget('showsId');

        $catId = '';
        $choose_type = $request->type;
        if (isset($_GET['cat_id'])) {
            $catId = $request->cat_id;
            Session::put('catId', $catId);
        }
        if (isset($_GET['id'])) {
            $showsid = $request->id;
            Session::put('showsId', $showsid);
        }
        Session::put('choose_type', $choose_type);

        if (!$path) {
            $path = Session::put('catId', $catId);
        } else {
            if ($path == 'home') {
                $path = null;
                Session::forget('path');
            } else {
                // switch to specified media folder
                Session::put('path', $path);
            }
        }
        $data['media']['files'] = MediaManager::orderBy('id', 'DESC')->get();
        // load view
        $data['page'] = 'dashboard/gallery-manager/manager';
        $data['choose_type'] = 'news_image';
        return view('dashboard.gallery-manager.index', $data);
    }

    /**
     * Method to upload media files
     */
    public function do_upload(Request $request)
    {
        $files = [];
        if ($request->hasfile('filedata')) {
            foreach ($request->file('filedata') as $file) {
                try {
                    // $fileName = rand() . '.' . $file->extension();
                    $fileName =$file->getClientOriginalName();
                    $file_name = pathinfo($fileName, PATHINFO_FILENAME); // file
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    for($i=0;sizeof(MediaManager::where('file_name','=',$fileName)->get()) > 0; $i++){
                            $fileName=$file_name.'_'.$i.'.'.$extension;
                    }
                    $file->move(public_path('/uploads/media/'), $fileName);
                    $files['file_name'] = $fileName;
                    $files['alt_tag'] = $file_name;
                    $files['created_by'] = 1;
                    $files['file_type'] = mime_content_type(public_path('/uploads/media/') . $fileName);
                    $files['media_url'] = url("/") . "/uploads/media/" . $fileName;
                    $files['status'] = 1;
                    $files['file_ext'] = pathinfo(public_path('/uploads/media/') . $fileName, PATHINFO_EXTENSION);
                    $files['media_uid'] = Str::uuid();
                    $files['path'] = "uploads/media/" . $fileName;
                    MediaManager::create($files);
                } catch (Exception $e) {
                    Log::error($e->getMessage());
                    return $e->getMessage();
                }
            }
        }
    }

    /**
     * Method to set upload notifications
     */
    // public function set_upload_notifications()
    // {
    //     $count = (int) $this->session->userdata('upload_count');
    //     $errors = (array) $this->session->userdata('upload_errors');

    //     if ($count) {
    //         $no_files = ($count > 1) ? 'files' : 'file';
    //         $message = $count . ' ' . $no_files . ' uploaded successfully';
    //         $this->base->set_message($message, 'success');
    //     }

    //     if ($errors) {
    //         $message = implode('<br>', $errors);
    //         $this->base->set_message($message, 'error');
    //     }

    //     // Clear session for uploaded file count on every redirect
    //     $this->session->unset_userdata('upload_count');
    //     $this->session->unset_userdata('upload_errors');
    // }

    public function get_media_data(Request $request)
    {
        $imgvalue = $request->mgvalue;
        if (!empty(Session::get('mediavalue'))) {
            Session::forget('mediavalue');
            Session::put('mediavalue', $imgvalue);
            echo Session::get('mediavalue');
        } else {
            Session::put('mediavalue', $imgvalue);
            // $this->session->set_userdata('mediavalue', $imgvalue);
            echo Session::get('mediavalue');
        }
    }

    public function checkMediaData()
    {
        echo Session::get('mediavalue');
    }

    public function destroy(Request $request)
    {
        $media_id = $request->media_uid;
        $media = MediaManager::where('media_uid', $media_id)->first();
        if (!empty($media)) {
            //     if (file_exists($media->path)){
            //         Log::info(unlink($media->path));
            //         $res = $media->delete(); //returns true/false
            //         echo json_encode($res['status'] = 'success');

            //    }else{
            //     $res['status'] = 'error';
            //     $res['message'] = 'Can not delete !. Image not exist in public folder';
            //     echo json_encode($res);
            //    }
            $media->deleted_by = Auth::user()->id;
            $media->save();

            $res = $media->delete(); //returns true/false
            if ($res) {
                echo json_encode($response['status'] = 'success');
                die;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Something went wrong';
                echo json_encode($response);
                die;
            }
        }
    }
}
