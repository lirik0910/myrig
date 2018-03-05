<?php

namespace App\Model\Shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //protected $options_arr = [];

    public function category()
    {
        return $this->hasOne('App\Model\Shop\Category');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function options(){
        return $this->hasMany(ProductOption::class);
    }

    /*
     * Convert product options to array
     * @param (Object) $options Current product options
     * return array
     */
    public static function convertOptions($options)
    {
        $output = [];
        foreach($options as $option){
            if($option->name == 'image'){
                $output['images'][] = $option;
            }elseif (preg_match('/[а-яё]/iu', $option->name)){
                $output['characteristics'][] = $option;
            } else{
                $output[$option->name] = $option;
            }
        }
        return $output;
    }
}
