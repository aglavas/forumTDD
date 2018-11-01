<?php
/**
 * Created by PhpStorm.
 * User: andrija
 * Date: 3/24/18
 * Time: 9:56 AM
 */

use App\Fetch_Task;

class Fetch_Test extends \PHPUnit\Framework\TestCase
{

    public static $cssDir = 'public/css/vendors/';
    public static $jsDir = 'public/js/vendors/';

    protected $fetch;

    public function setUp()
    {
        $stub = $this->createMock(\App\Asset::class);

        $stub->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue('psuedo content'));

        $this->fetch = new Fetch_Task($stub);
    }

    public function tearDown()
    {
//        $filesystem = new Illuminate\Filesystem\Filesystem();
//        $filesystem->cleanDirectory(static::$jsDir);
//        $filesystem->cleanDirectory(static::$cssDir);
    }

    public function testStoresListOfAssets()
    {
        $this->assertClassHasStaticAttribute('paths', Fetch_Task::class);
        $this->assertArrayHasKey('jquery', Fetch_Task::$paths);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionIfNoAssetIsProvided()
    {
        $this->fetch->run();
        $this->expectException(InvalidArgumentException::class);
    }


    public function testDownloadsAssetIfFound()
    {
        $this->fetch->run(['jquery']);
        $this->assertFileExists(static::$jsDir . 'jquery.js');
    }

    public function testSavesAssetsToProperDirectory()
    {
        $this->fetch->run(['jquery']);
        $this->assertFileExists(static::$jsDir . 'jquery.js');

        $this->fetch->run(['normalize']);
        $this->assertFileExists(static::$cssDir . 'normalize.css');
    }


    public function testNotifiesUserUponCompletion()
    {
        $this->fetch->run(['jquery']);
        $this->expectOutputString('Your asset has been generated.');

    }


    public function testNotifiesUserIfAssetIsNotRecognized()
    {
        $this->fetch->run(['blabla']);
        $this->expectOutputString('Unknown asset.');

    }

}