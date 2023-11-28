<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\File;

class Utilities {
    
    public static function getCategory($category) {
        switch ($category){
            case 'corporate_events':
                return 'Corporate Events';
            case 'commercial_shoots':
                return 'Commercial Shoots';
            case 'potraits':
                return 'Potraits';
            case 'social_events':
                return 'Social Events';
            case 'weddings':
                return 'Weddings';
            default:
                return 'Null';
        }
    }


    public static function getServices(){
        $folderPath = public_path('images/services');

        $items = File::allFiles($folderPath);

        $images = [];
        
        foreach($items as $item){
            $filePath = str_replace("\\","/",'images/services/'.$item->getRelativePathname());
            $folderName = pathinfo($item->getPath())['filename'];
            $service_type = ucwords(str_replace('_',' ',$folderName));
            $name = ucwords(str_replace('_',' ',$item->getFilenameWithoutExtension()));
            $images[$folderName][] = ['name' => $name, 'type' => $service_type, 'imagePath' => $filePath];
        }

        return $images;
    }

    public static function getAlbumPhoto(){
        $folderPath = public_path('images/albums');

        $items = File::allFiles($folderPath);

        $images = [];

        foreach($items as $item){
            $filePath = str_replace("\\","/",'images/albums/'.$item->getRelativePathname());
            $folderName = pathinfo($item->getPath())['filename'];
            $images[$folderName][] = $filePath;
        }

        return $images;

    }

    public static function getFeaturedWorkPhoto(){
        $folderPath = public_path('images/landing/featured_work/photo');

        $items = File::allFiles($folderPath);

        $images = [];

        foreach($items as $item){
            $filePath = 'images/landing/featured_work/photo/'.$item->getRelativePathname();
            array_push($images,$filePath);
        }

        return $images;
    }

    public static function getBookingSessionCount($sessionType) {
        $bookingCount = Booking::where('session_type',$sessionType)->whereNot('status','pending')->count();
        return [
            'session' => $sessionType,
            'count' => $bookingCount
        ];
    }
}