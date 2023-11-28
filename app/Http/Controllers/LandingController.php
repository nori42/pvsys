<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LandingController extends Controller
{
    //
    public function __invoke()
    {
        $serviceCategory = [
            'corporate_events' => ['CONFERENCES', 'CORPORATE PARTIES', 'PRODUCT LAUNCHES', 'SEMINARS', 'TEAM BUILDING ACTIVITIES'],
            'commercial_shoots' => ['ADVERTISING CAMPAIGNS', 'FASHION SHOOTS'],
            'portraits' => ['FAMILY PORTRAITS', 'LIFESTYLE PHOTOGRAPHY', 'PROFESSIONAL HEADSHOTS', 'SENIOR PORTRAITS'],
            'social_events' => ['ANNIVERSARIES', 'BABY SHOWER','CHRISTENING','BIRTHDAYS', 'GRADUATION'],
            'weddings' => ['BRIDAL SHOWERS', 'CEREMONIES', 'ENGAGEMENT PARTIES', 'RECEPTION','PRENUP','ULTIMATE WEDDING EXPERIENCE'],
        ];
    
        $serviceArr = array();
    
        foreach ($serviceCategory as $category => $services) {
            foreach ($services as $service) {
                array_push($serviceArr, new Service($service,$category,str_replace(' ','_',$service)));
            }
        }
    
        $services = collect($serviceArr);

        // About me
        $jsonFilePath = public_path('aboutme.json'); // Replace with your JSON file path

        $jsonContent = File::get($jsonFilePath);

        $data = json_decode($jsonContent,true);
    
        return view('pages.client.landing',[
            'services' => Utilities::getServices(),
            'aboutme' => $data['description'],
            'featuredPhoto' => Utilities::getFeaturedWorkPhoto(),
            'featuredVideo' => Utilities::getFeaturedWorkVideo()
        ]);
        
    }
}
