<?php
namespace App\Http\Controllers;


class Utilities {
    
    public static function getCategory($category) {
        switch ($category){
            case 'corporateevents':
                return 'Corporate Events';
            case 'commercialshoots':
                return 'Commercial Shoots';
            case 'potraits':
                return 'Potraits';
            case 'socialevents':
                return 'Social Events';
            case 'weddings':
                return 'Weddings';
            default:
                return 'Null';
        }
    }
}