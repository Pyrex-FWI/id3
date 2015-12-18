<?php

namespace Cpyree\Id3\Test\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3Metadata;
use Cpyree\Id3\Wrapper\BinWrapper\MediainfoWrapper;
use Cpyree\Id3\Test\Helper;

class MediainfoWrapperTest extends \PHPUnit_Framework_TestCase
{

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
		$mediaInfoWrapper = new  MediainfoWrapper();
		$mediaInfoWrapper->setBinPath('xxnotxxexist');
	}


	public function testWrongMp3FileException()
	{
		$mediaInfoWrapper = new  MediainfoWrapper();
		$mediaInfoWrapper->setBinPath(Helper::getMediainfoPath());

		$metaDataFile = new Id3Metadata(Helper::getWrongMp3File());
		$this->assertFalse($mediaInfoWrapper->read($metaDataFile));
	}


	public function testInit()
	{
		$mediaInfoWrapper = new  MediainfoWrapper();
		$mediaInfoWrapper->setBinPath(Helper::getMediainfoPath());
		$this->assertContains("MediaInfoLib", $mediaInfoWrapper->getVersion());

		$metaDataFile = new Id3Metadata(Helper::getSampeMp3File());
		if ($mediaInfoWrapper->read($metaDataFile)) {
			$this->assertEquals('Nom du morceau', $metaDataFile->getTitle());
			$this->assertEquals('Artiste', $metaDataFile->getArtist());
			$this->assertEquals('Nom de l\'album', $metaDataFile->getAlbum());
			$this->assertEquals('Celtic', $metaDataFile->getGenre());
			$this->assertEquals('2003', $metaDataFile->getYear());
			$this->assertEquals('120', $metaDataFile->getBpm());
			$this->assertEquals('87.875', $metaDataFile->getTimeDuration());
		}

		$this->assertTrue($mediaInfoWrapper->supportRead($metaDataFile));
		$this->assertFalse($mediaInfoWrapper->supportWrite($metaDataFile));
		$mediaInfoWrapper->write($metaDataFile);
	}
}
