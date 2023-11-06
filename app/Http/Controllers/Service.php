<?php
namespace App\Http\Controllers;


class Service {
    public $name;
    public $type;
    public $imagePath;

    public function __construct($name, $type, $imageFileName)
    {   
        $imageFolder = null;
        $imageName = strtolower($imageFileName);
        switch (str_replace('_',' ',$type)) {
            case 'corporate events':
                $imageFolder = 'corporate_events';
                break;
            case 'commercial shoots':
                $imageFolder = 'commercial_shoots';
                break;
            case 'portraits':
                $imageFolder = 'portraits';
                break;
            case 'social events':
                $imageFolder = 'social_events';
                break;
            case 'weddings':
                $imageFolder = 'weddings';
                break;
        }


        $this->name = $name;
        $this->type = str_replace('_',' ',$type);
        $this->imagePath = "images/services/{$imageFolder}/{$imageName}.png";
    }
}