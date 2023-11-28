<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FeaturedWorkController extends Controller
{
    //
    public function photo(){
        return view('pages.admin.portfolio.featuredwork.photo',[
            'featuredPhoto' => Utilities::getFeaturedWorkPhoto()
        ]);
    }

    public function video(){
        return view('pages.admin.portfolio.featuredwork.video',[
            'featuredVideo' => Utilities::getFeaturedWorkVideo()
        ]);
    }

    public function uploadVideo(Request $request){

        if($request->hasFile('videoUpload')){
            $folderPath = public_path('images/landing/featured_work/video');
            $fileCount = 0;

            if (File::exists($folderPath)) {
                $files = File::files($folderPath);
                $fileCount = count($files);
            }

            $files = $request->file('videoUpload');
            foreach ($files as $file) {
                $fileName = time().'_'.++$fileCount.'.'.$file->getClientOriginalExtension();
                $file->move($folderPath, $fileName);
            }
        }

    return redirect('/portfolio/featuredwork/video');

}

    public function uploadimage(Request $request){

            if($request->hasFile('imageUpload')){

                $folderPath = public_path('images/landing/featured_work/photo');
                $fileCount = 0;

                if (File::exists($folderPath)) {
                    $files = File::files($folderPath);
                    $fileCount = count($files);
                }

                $files = $request->file('imageUpload');
                foreach ($files as $file) {
                    $fileName = time().'_'.++$fileCount.'.'.$file->getClientOriginalExtension();
                    $file->move($folderPath, $fileName);
                }
            }

        return redirect('/portfolio/featuredwork/photo');

    }
}
