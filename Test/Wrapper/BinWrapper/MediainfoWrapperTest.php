<?php

namespace Cpyree\Id3\Test\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3Metadata;
use Cpyree\Id3\Wrapper\BinWrapper\MediainfoWrapper;
use Cpyree\Id3\Test\Helper;

class MediainfoWrapperTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var MediainfoWrapper
	 */
	private $mediaInfoWrapper;

	protected function setUp()
	{
		$this->mediaInfoWrapper = $this->getMediainfoWrapper();
		$this->mediaInfoWrapper->setBinPath(Helper::getMediainfoPath());
	}

	/**
	 * @return MediainfoWrapper
	 */
	public function getMediainfoWrapper()
	{
		return new  MediainfoWrapper();
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
		$this->mediaInfoWrapper->setBinPath('xxnotxxexist');
	}


	public function testWrongMp3FileException()
	{
		$metaDataFile = new Id3Metadata(Helper::getWrongMp3File());
		$this->assertFalse($this->mediaInfoWrapper->read($metaDataFile));
	}


	public function testRead()
	{
		$this->mediaInfoWrapper->setBinPath(Helper::getMediainfoPath());
		$this->assertContains("MediaInfoLib", $this->mediaInfoWrapper->getVersion());

		$metaDataFile = new Id3Metadata(Helper::getSampeMp3File());
		if ($this->mediaInfoWrapper->read($metaDataFile)) {
			$this->assertEquals('Nom du morceau', $metaDataFile->getTitle());
			$this->assertEquals('Artiste', $metaDataFile->getArtist());
			$this->assertEquals('Nom de l\'album', $metaDataFile->getAlbum());
			$this->assertEquals('Celtic', $metaDataFile->getGenre());
			$this->assertEquals('2003', $metaDataFile->getYear());
			$this->assertEquals('120', $metaDataFile->getBpm());
			$this->assertEquals('87.875', $metaDataFile->getTimeDuration());
		}

		$this->assertTrue($this->mediaInfoWrapper->supportRead($metaDataFile));

	}

	public function testWrite()
	{
		$metaDataFile = new Id3Metadata(Helper::getSampeMp3File());
		$this->assertFalse($this->mediaInfoWrapper->supportWrite($metaDataFile));
		$this->mediaInfoWrapper->write($metaDataFile);
	}
}
