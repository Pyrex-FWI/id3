<?php

namespace Cpyree\Id3\Test\Reader\BinWrapper;


use Cpyree\Id3\Metadata\Id3Metadata;
use Cpyree\Id3\Wrapper\BinWrapper\MediainfoWrapper;
use Cpyree\Id3\Test\Helper;

class MediainfoWrapperTest extends \PHPUnit_Framework_TestCase
{

	public function testInit()
	{
		$mediaInfoWrapper = new  MediainfoWrapper();
		$mediaInfoWrapper->setBinPath('/usr/local/bin/mediainfo');
		$this->assertContains("MediaInfoLib", $mediaInfoWrapper->getVersion());

		$metaDataFile = new Id3Metadata(Helper::getSampeFileToodie());
		if ($mediaInfoWrapper->read($metaDataFile)) {
			$this->assertEquals('Nom du morceau', $metaDataFile->getTitle());
			$this->assertEquals('Artiste', $metaDataFile->getArtist());
			$this->assertEquals('Nom de l\'album', $metaDataFile->getAlbum());
			$this->assertEquals('Celtic', $metaDataFile->getGenre());
			$this->assertEquals('2003', $metaDataFile->getYear());
			$this->assertEquals('120', $metaDataFile->getBpm());
		}
	}
}
