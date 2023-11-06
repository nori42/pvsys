<?php
namespace App\Http\Controllers;


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
}