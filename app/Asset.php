<?php
/**
 * Created by PhpStorm.
 * User: andrija
 * Date: 3/24/18
 * Time: 12:23 PM
 */

namespace App;


class Asset {

    public function fetch($assetPath)
    {
        return file_get_contents($assetPath);
    }

}