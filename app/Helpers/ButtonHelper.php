<?php
namespace App\Helpers;
 
class ButtonHelper {
    public static function datatable_button($type,$option){
        if($type=='delete'){
            return '<button class="btn btn-transparent btn-sm p-1 btn-delete text-danger" data-target="#modal-delete" title="'.$option['title'].'" data-link="'.$option['href'].'" data-nickname="'.$option['nickname'].'" '.$option['additional-attribute'].'><i class="fa-fw '.$option['icon'].'"></i></button>';
        }else{
            return '<a href="'.$option['href'].'" class="btn btn-transparent btn-sm p-1" title="'.$option['title'].'"><i class="fa-fw '.$option['icon'].'"></i></a>';
        }
    }
}