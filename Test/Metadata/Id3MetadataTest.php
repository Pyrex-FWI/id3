<?php

namespace Sapar\Id3\Test\Metadata;


use Sapar\Id3\Test\Helper;
use Sapar\Id3\Metadata\Id3Metadata;
use Sapar\Id3\Metadata\Id3MetadataInterface;

class Id3MetadataTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
    }

    /**
     * @return Id3MetadataInterface
     */
    private function getId3MetadataInstance()
    {
        return new Id3Metadata(Helper::getSampleMp3File());
    }

    /**
     * @return array
     */
    public function id3MetadataProvider()
    {
        return [
            [ $this->getId3MetadataInstance() ]
        ];
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     * @dataProvider id3MetadataProvider
     */
    public function testInstance(Id3MetadataInterface $id3Metadata)
    {
        $this->assertInstanceOf('Sapar\Id3\Metadata\Id3MetadataInterface', $id3Metadata);
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     * @dataProvider id3MetadataProvider
     */
    public function testMethodsExistence(Id3MetadataInterface $id3Metadata)
    {
        $this->assertTrue(method_exists($id3Metadata,'setAllArtists'));
        $this->assertTrue(method_exists($id3Metadata,'getAllArtists'));
        $this->assertTrue(method_exists($id3Metadata,'setAllGenres'));
        $this->assertTrue(method_exists($id3Metadata,'getAllGenres'));
        $this->assertTrue(method_exists($id3Metadata,'setTitle'));
        $this->assertTrue(method_exists($id3Metadata,'getTitle'));
        $this->assertTrue(method_exists($id3Metadata,'setArtist'));
        $this->assertTrue(method_exists($id3Metadata,'getArtist'));
        $this->assertTrue(method_exists($id3Metadata,'setComment'));
        $this->assertTrue(method_exists($id3Metadata,'getComment'));
        $this->assertTrue(method_exists($id3Metadata,'setYear'));
        $this->assertTrue(method_exists($id3Metadata,'getYear'));
        $this->assertTrue(method_exists($id3Metadata,'setGenre'));
        $this->assertTrue(method_exists($id3Metadata,'getGenre'));
        $this->assertTrue(method_exists($id3Metadata,'setKey'));
        $this->assertTrue(method_exists($id3Metadata,'getKey'));
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     * @dataProvider id3MetadataProvider
     */
    public function testMethod(Id3MetadataInterface $id3Metadata)
    {
        $id3Metadata->setAllArtists(self::getArtists());
        $this->assertEquals(self::getArtists(), $id3Metadata->getAllArtists());
        $id3Metadata->setAllGenres(self::getGenres());
        $this->assertEquals(self::getGenres(), $id3Metadata->getAllGenres());
        $id3Metadata->setTitle(self::getTitle());
        $this->assertEquals(self::getTitle(), $id3Metadata->getTitle());
        $id3Metadata->setArtist(self::getArtists()[0]);
        $this->assertEquals(self::getArtists()[0], $id3Metadata->getArtist());
        $id3Metadata->setComment(self::getComment());
        $this->assertEquals(self::getComment(),$id3Metadata->getComment());
        $id3Metadata->setYear(self::getYear());
        $this->assertEquals(self::getYear(), $id3Metadata->getYear());
        $id3Metadata->setGenre(self::getGenres()[0]);
        $this->assertEquals(self::getGenres()[0], $id3Metadata->getGenre());
        $id3Metadata->setKey(self::getKey());
        $this->assertEquals(self::getKey(), $id3Metadata->getKey());
        $id3Metadata->setTimeDuration(self::getDuration());
        $this->assertEquals(self::getDuration(), $id3Metadata->getTimeDuration());
    }

    /**
     * @return array
     */
    public static function getGenres()
    {
        return ['Techno','House'];
    }

    /**
     * @return array
     */
    public static function getArtists()
    {
        return ['Aidonia', 'Slaï', 'Admiral T'];
    }

    /**
     * @return string
     */
    public static function getTitle()
    {
        return 'My song title';
    }

    public static function getComment()
    {
        return "My song comment and other some text";
    }

    public static function getYear()
    {
        return 2010;
    }

    public static function getKey()
    {
        return '2Bm';
    }

    /**
     * @return float
     */
    public static function getDuration()
    {
        return 850.50;
    }
}
