<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
        return view('pages.client.landing',['services' => $services->groupBy('type')]);
        
    }
}
