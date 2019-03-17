<?php
/**
 * Created by PhpStorm.
 * User: brian
 * Date: 16/03/2019
 * Time: 22:55
 */

namespace App\Models\Data;


use Illuminate\Database\Eloquent\Model;

class Channel extends Model {

    protected $table = 'data_channels';

    public static function getIdChannel($channel, $run) {
        $id = $channel->_id;
        $channelBd = self::where('_id', '=', $id)->first();

        if (empty($channelBd)) {
            $channelBd = new Channel();
            $channelBd->_id = $id;
            $channelBd->display_name = $channel->display_name;
            $channelBd->mature = $channel->mature;
            $channelBd->status = empty($channel->status) ? '' : $channel->status;
            $channelBd->broadcaster_language = $channel->broadcaster_language;
            $channelBd->name = $channel->name;
            $channelBd->followers = $channel->followers;
            $channelBd->id_run = $run->id;
            $channelBd->save();
        }

        $id = $channelBd->id;

        return $id;
    }
}