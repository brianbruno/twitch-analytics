<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 17/03/2019
 * Time: 08:57
 */

namespace App\Http\Controllers\Chart;


abstract class Chart {

    protected $defaultColors = ['#263238', '#212121', '#3e2723', '#bf360c',
    '#e65100', '#ff6f00', '#f57f17', '#827717', '#33691e', '#1b5e20'];

    private $contador = 0;


    public function getBackgroundColor($name) {

        /*try {
            $cor = $this->defaultColors[$this->contador];
            $this->contador++;
        } catch (\Exception $e) {
            $cor = $this->random_color();
        }*/
        $cor = $this->random_color();

        return $cor;
    }

    private function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    private function random_color() {
        return '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }



}