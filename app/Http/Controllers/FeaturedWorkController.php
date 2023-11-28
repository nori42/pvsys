<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FeaturedWorkController extends Controller
{
    //
    public function index(){
        return view('pages.admin.portfolio.featuredwork',[
            'featuredPhoto' => Utilities::getFeaturedWorkPhoto()
        ]);
    }

    public function uploadimage(Request $request){

            $files = $request->file('imageUpload');
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

        return redirect('/portfolio/featuredwork');

    }
}
