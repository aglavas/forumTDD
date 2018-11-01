<?php
/**
 * Created by PhpStorm.
 * User: andrija
 * Date: 3/24/18
 * Time: 10:00 AM
 */

namespace App;




use League\Flysystem\Filesystem;



class Fetch_Task
{
    protected $asset, $file;

    public static $cssDir = 'public/css/vendors/';
    public static $jsDir = 'public/js/vendors/';


    public static $paths = [
        'jquery' => 'http://code.jquery.com/jquery.js',
        'normalize' => 'https://raw.github.com/necolas/normalize.css/master/normalize.css'
    ];

    public function __construct(Asset $file = null)
    {
        if( ! is_null($file) )
        {
            $this->file = $file;
        } else {
            $this->file = new Asset;
        }

    }

    public function run($query = null)
    {
        if( !$query )
        {
            throw new \InvalidArgumentException('Please pass an asset to download');
        }

        $this->asset = strtolower($query[0]);

        // if recognized, then fetch it and create a file

        if ( $this->recognizesAsset($this->asset))
        {
           $content = $this->file->fetch(static::$paths[$this->asset]);

           $this->createFile($this->asset, $content);

           echo 'Your asset has been generated.';
        }
        else
        {
            echo 'Unknown asset.';
        }

        //echo not found to user
    }

    public function recognizesAsset($asset)
    {
        return array_key_exists($asset, static::$paths);
    }

//    public function fetch($assetPath)
//    {
//        return file_get_contents($assetPath);
//    }

    public function createFile($asset, $content)
    {
        $fileExtensions = pathinfo(static::$paths[$asset], PATHINFO_EXTENSION);

        $filesystem = new \Illuminate\Filesystem\Filesystem();

        if( $fileExtensions == 'js')
        {
            $path = static::$jsDir . "{$asset}.{$fileExtensions}";
        } elseif ($fileExtensions == 'css') {
            $path = static::$cssDir . "{$asset}.{$fileExtensions}";
        }

        $filesystem->makeDirectory(dirname($path),0755,true, true);

        $filesystem->put($path, $content);

    }

}