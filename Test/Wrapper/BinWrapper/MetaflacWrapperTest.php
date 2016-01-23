<?php

namespace Cpyree\Id3\Test\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3Metadata;
use Cpyree\Id3\Wrapper\BinWrapper\Eyed3Wrapper;
use Cpyree\Id3\Wrapper\BinWrapper\MediainfoWrapper;
use Cpyree\Id3\Test\Helper;
use Cpyree\Id3\Wrapper\BinWrapper\MetaflacWrapper;

class MetaflacWrapperTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var MetaflacWrapper
	 */
	private $metaflacWrapper;

	protected function setUp()
	{
		$this->metaflacWrapper = $this->getMetafacWrapper();
		$this->metaflacWrapper->setBinPath(Helper::getMetaflacPath());
	}

	/**
	 * @return MetaflacWrapper
	 */
	public function getMetafacWrapper()
	{
		return new  MetaflacWrapper();
	}

	/**
	 * @expectedException \Exception
	 */
	public function testNotExistBinException()
	{
		$this->metaflacWrapper->setBinPath('xxnotxxexist');
	}



	public function testRead()
	{
		$this->metaflacWrapper->setBinPath(Helper::getMetaflacPath());
		$this->assertContains("metaflac", $this->metaflacWrapper->getVersion());

		$metaDataFile = new Id3Metadata(Helper::getSampleFlacFile());
		if ($this->metaflacWrapper->read($metaDataFile)) {
			$this->assertEquals('Flac title', $metaDataFile->getTitle());
			$this->assertEquals('Flac artist', $metaDataFile->getArtist());
			$this->assertEquals('Flac album', $metaDataFile->getAlbum());
			$this->assertEquals('Flac Genre', $metaDataFile->getGenre());
			$this->assertEquals('2000', $metaDataFile->getYear());
			$this->assertEquals('0', intval($metaDataFile->getBpm()));
		}

		$this->assertTrue($this->metaflacWrapper->supportRead($metaDataFile));

	}


	public function testWrite()
	{
		$this->metaflacWrapper->setBinPath(Helper::getMetaflacPath());

		$writeData = [
			'title' => 'Title',
			'album' => 'l\'album',
			'genre' => 'Dance Hall',
			'year' 	=> 2011,
			'comm'	=> 'Test comment',
			'bpm'	=> '122',

		];
		Helper::backupFile(Helper::getSampleFlacFile());
		$metaDataFile = new Id3Metadata(Helper::getSampleFlacFile());

		$metaDataFile->setAlbum($writeData['album']);
		$metaDataFile->setTitle($writeData['title']);
		$metaDataFile->setGenre($writeData['genre']);
		$metaDataFile->setYear($writeData['year']);
		$metaDataFile->setComment($writeData['comm']);
		$metaDataFile->setBpm($writeData['bpm']);
		$this->assertTrue($this->metaflacWrapper->write($metaDataFile));

		$metaDataFile = new Id3Metadata(Helper::getSampleFlacFile());
		$this->assertTrue($this->metaflacWrapper->read($metaDataFile));
		$this->assertEquals($writeData['album'], $metaDataFile->getAlbum());
		$this->assertEquals($writeData['title'], $metaDataFile->getTitle());
		$this->assertEquals($writeData['genre'], $metaDataFile->getGenre());
		$this->assertEquals($writeData['comm'], $metaDataFile->getComment());
		$this->assertEquals($writeData['bpm'], intval($metaDataFile->getBpm()));

		Helper::restoreFile(Helper::getSampleFlacFile());
	}
}
