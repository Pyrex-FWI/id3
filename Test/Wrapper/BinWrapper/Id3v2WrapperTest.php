<?php

namespace Sapar\Id3\Test\Wrapper\BinWrapper;


use Sapar\Id3\Metadata\Id3Metadata;
use Sapar\Id3\Test\Helper;
use Sapar\Id3\Wrapper\BinWrapper\Id3v2Wrapper;

class Id3v2WrapperTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var Id3v2Wrapper
	 */
	private $id3v2Wrapper;

	protected function setUp()
	{
		$this->id3v2Wrapper = $this->getMediainfoWrapper();
		$this->id3v2Wrapper->setBinPath(Helper::getId3v2Path());
	}

	/**
	 * @return Id3v2Wrapper
	 */
	public function getMediainfoWrapper()
	{
		return new  Id3v2Wrapper();
	}
	/**
	 * @expectedException \Exception
	 */
	public function testDummyFileException()
	{
		new Id3Metadata('non_exist_dummy.flac');
	}

	/**
	 * @expectedException \Exception
	 */
	public function testNotExistBinException()
	{
		$this->id3v2Wrapper->setBinPath('xxnotxxexist');
	}


	public function testWrongMp3FileException()
	{
		$metaDataFile = new Id3Metadata(Helper::getWrongMp3File());
		$this->assertFalse($this->id3v2Wrapper->read($metaDataFile));
	}


	public function testRead()
	{
		$this->id3v2Wrapper->setBinPath(Helper::getId3v2Path());
		$this->assertContains("Uses id3lib", $this->id3v2Wrapper->getVersion());

		$metaDataFile = new Id3Metadata(Helper::getSampleMp3File());
		if ($this->id3v2Wrapper->read($metaDataFile)) {
			$this->assertEquals('Nom du morceau', $metaDataFile->getTitle());
			$this->assertEquals('Artiste', $metaDataFile->getArtist());
			$this->assertEquals('Nom de l\'album', $metaDataFile->getAlbum());
			$this->assertEquals('Celtic', $metaDataFile->getGenre());
			$this->assertEquals('2003', $metaDataFile->getYear());
			$this->assertEquals('120', $metaDataFile->getBpm());
		}

		$this->assertTrue($this->id3v2Wrapper->supportRead($metaDataFile));

	}


	public function testWrite()
	{
		$this->id3v2Wrapper->setBinPath(Helper::getId3v2Path());

		$writeData = [
			'title' => 'Title',
			'artist'=> 'Artist',
			'album' => 'l\'album',
			'genre' => 'Dance Hall',
			'year' 	=> 2011,
			'comm'	=> 'Test comment',
			'bpm'	=> '122',

		];
		Helper::backupFile(Helper::getSampleMp3File());
		$metaDataFile = new Id3Metadata(Helper::getSampleMp3File());

		$metaDataFile->setAlbum($writeData['album']);
		$metaDataFile->setArtist($writeData['artist']);
		$metaDataFile->setTitle($writeData['title']);
		$metaDataFile->setGenre($writeData['genre']);
		$metaDataFile->setYear($writeData['year']);
		$metaDataFile->setComment($writeData['comm']);
		$metaDataFile->setBpm($writeData['bpm']);
		$this->assertTrue($this->id3v2Wrapper->write($metaDataFile));

		$metaDataFile = new Id3Metadata(Helper::getSampleMp3File());
		$this->assertTrue($this->id3v2Wrapper->read($metaDataFile));
		$this->assertEquals($writeData['album'], $metaDataFile->getAlbum());
		$this->assertEquals($writeData['title'], $metaDataFile->getTitle());
		$this->assertEquals($writeData['genre'], $metaDataFile->getGenre());
		$this->assertEquals($writeData['comm'], $metaDataFile->getComment());
		$this->assertEquals($writeData['bpm'], $metaDataFile->getBpm());

		Helper::restoreFile(Helper::getSampleMp3File());
	}
}
