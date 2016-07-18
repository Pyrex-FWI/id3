<?php

namespace Sapar\Id3\Test\Bench;

use Sapar\Id3\Metadata\Id3Metadata;
use Sapar\Id3\Test\Helper;
use Sapar\Id3\Wrapper\BinWrapper\Eyed3Wrapper;
use Sapar\Id3\Wrapper\BinWrapper\MediainfoWrapper;

class ReadTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MediainfoWrapper
     */
    public static $mediainfo;
    /**
     * @var Eyed3Wrapper
     */
    public static $eyed3;

    /**
     * @var Id3Metadata
     */
    public static $id3meta;



    public static function setUpBeforeClass()
    {
        self::$id3meta = new \Sapar\Id3\Metadata\Id3Metadata(Helper::getSampleMp3File());
        self::$eyed3= new \Sapar\Id3\Wrapper\BinWrapper\Eyed3Wrapper();
        self::$eyed3->setBinPath(Helper::getEyed3Path());

        self::$mediainfo = new \Sapar\Id3\Wrapper\BinWrapper\MediainfoWrapper();
        self::$mediainfo->setBinPath(Helper::getMediainfoPath());

    }

    /**
     * @group eyed3-read
     * @throws Exception
     */
    public function testReadEyed3()
    {
        self::$eyed3->read(self::$id3meta);
    }
    /**
     * @group mediainfo-read
     * @throws Exception
     */
    public function testReadMediainfo()
    {
        self::$mediainfo->read(self::$id3meta);
    }
}
