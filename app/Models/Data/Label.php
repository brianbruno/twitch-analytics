<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 16/03/2019
 * Time: 22:55
 */

namespace App\Models\Data;


use Illuminate\Database\Eloquent\Model;

class Label extends Model {

    protected $table = 'data_labels';

    public static function getIdLabel($name, $value) {
        $label = self::where('name', '=', $name)->where('value', '=', $value)->first();

        if (empty($label)) {
            $label = new Label();
            $label->name = $name;
            $label->value = $value;
            $label->save();
        }

        $id = $label->id;

        return $id;
    }

}