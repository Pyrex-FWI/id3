<?php

namespace Cpyree\Id3\Test\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3Metadata;
use Cpyree\Id3\Wrapper\BinWrapper\Eyed3Wrapper;
use Cpyree\Id3\Wrapper\BinWrapper\MediainfoWrapper;
use Cpyree\Id3\Test\Helper;

class Eyed3WrapperTest extends \PHPUnit_Framework_TestCase
{
	public static $originalFile;
	public static $backupFile;

	/**
	 * @var Eyed3Wrapper
	 */
	private $eyed3Wrapper;

	protected function setUp()
	{
		$this->eyed3Wrapper = new Eyed3Wrapper();
	}

	protected function tearDown()
	{

	}

	public static function setUpBeforeClass()
	{
		self::$originalFile = Helper::getSampleMp3File();
		self::$backupFile = Helper::getSampleMp3File().".back";
		copy(self::$originalFile, self::$backupFile);
	}

	public static function tearDownAfterClass()
	{
		unlink(self::$originalFile);
		copy(self::$backupFile, self::$originalFile);
		unlink(self::$backupFile);
	}



	public function testInit()
	{
		$eyed3 = new Eyed3Wrapper();
		$eyed3->setBinPath(Helper::getEyed3Path());
	}

	public function testWrite()
	{
		$this->eyed3Wrapper->setBinPath(Helper::getEyed3Path());

		$writeData = [
			'artist'=> 'Artist',
			'title' => 'Title',
			'album' => 'l\'album',
			'genre' => 'Dance Hall',
			'year' 	=> 2011,
			'comm'	=> 'Test comment',
			'bpm'	=> '122',
		];

		$metaDataFile = new Id3Metadata(Helper::getSampleMp3File());
		$metaDataFile->setArtist($writeData['artist']);
		$metaDataFile->setAlbum($writeData['album']);
		$metaDataFile->setTitle($writeData['title']);
		$metaDataFile->setGenre($writeData['genre']);
		$metaDataFile->setYear($writeData['year']);
		$metaDataFile->setComment($writeData['comm']);
		$metaDataFile->setBpm($writeData['bpm']);

		$this->assertTrue($this->eyed3Wrapper->write($metaDataFile));

		$metaDataFile = new Id3Metadata(Helper::getSampleMp3File());
		$this->assertTrue($this->eyed3Wrapper->read($metaDataFile));
		$this->assertEquals($writeData['album'], $metaDataFile->getAlbum());
		$this->assertEquals($writeData['title'], $metaDataFile->getTitle());
		$this->assertEquals($writeData['genre'], $metaDataFile->getGenre());
		$this->assertEquals($writeData['comm'], $metaDataFile->getComment());
		$this->assertEquals($writeData['bpm'], $metaDataFile->getBpm());

	}

	public function testGetVersion()
	{
		$this->eyed3Wrapper->setBinPath(Helper::getEyed3Path());
		$this->assertContains('eyeD3', $this->eyed3Wrapper->getVersion());
	}
}
