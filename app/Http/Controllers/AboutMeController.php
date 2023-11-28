<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AboutMeController extends Controller
{
    //
    public function index(){
        
    $jsonFilePath = public_path('aboutme.json');

    $jsonContent = File::get($jsonFilePath);

    $data = json_decode($jsonContent,true);

        return view('pages.admin.portfolio.aboutme',[
            'aboutme' => $data
        ]);
    }

    public function updateAboutMe(Request $request){
        $jsonFilePath = public_path('aboutme.json');

        $newJsonContent = json_encode(['description' => $request->aboutMe],JSON_PRETTY_PRINT);

        file_put_contents($jsonFilePath,$newJsonContent);

        $jsonContent = File::get($jsonFilePath);

        $data = json_decode($jsonContent,true);

        return view('pages.admin.portfolio.aboutme',[
            'aboutme' => $data
        ]);
    }
}
