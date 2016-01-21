

# id3 Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://travis-ci.org/Pyrex-FWI/id3.svg?branch=master)](https://travis-ci.org/Pyrex-FWI/id3)

The package lays the basis for the simple manipulation of ID3 tags.

You can define readers and writers to manipulate the metadata in read or write. 

| Bin readers       | Available | Read | Write | Mp3 | Mp4 | Flac |
|:----------------- |:---------:|:----:|:-----:|:---:|:---:|:----:|
| [Mediainfo](https://mediaarea.net/en/MediaInfo)  | ✓ | ✓ |   | ✓ | ✓ | ✓ |
| [EyeD3](http//eyed3.nicfit.net)                  | ✓ | ✓ | ✓ | ✓ | - | - |
| [Id3v2](http://id3lib.sourceforge.net/)          | ✓ | ✓ | ✓ | ✓ | - | - |


## Usages

### Read Id3 Tags

```php
<?php

class MyClass
{

    public function readId3()
    {
        $mp3OrFlacFile = '/path/to/file';
        
        /** @var Cpyree\Id3\Metadata\Id3MetadataInterface */
        $id3Metadata = new Cpyree\Metadata\Id3Metadata($mp3OrFlacFile);
        
        /** @var Cpyree\Wrapper\BinWrapper\BinWrapperInterface */
        $mediaInfoWrapper = new Cpyree\Wrapper\BinWrapper\MediainfoWrapper();
        $mediaInfoWrapper->setBin('/usr/local/bin/mediainfo');
        
		if ($mediaInfoWrapper->read($metaDataFile)) {
			$metaDataFile->getTitle();
			$metaDataFile->getArtist();
			$metaDataFile->getAlbum();
			$metaDataFile->getGenre();
			$metaDataFile->getYear();
			$metaDataFile->getBpm();
			$metaDataFile->getTimeDuration();
		}
    }

}
```

### Write Id3 Tags

```php
<?php

class MyClass
{

    public function writeId3()
    {
        $mp3OrFlacFile = '/path/to/file';
        
        /** @var Cpyree\Id3\Metadata\Id3MetadataInterface */
        $id3Metadata = new Cpyree\Metadata\Id3Metadata($mp3OrFlacFile);
		$id3Metadata->setAlbum('album');
		$id3Metadata->setTitle('title');
		$id3Metadata->setGenre('genre');
		$id3Metadata->setYear(2016);
		$id3Metadata->setComment('comment');
		$id3Metadata->setBpm(120);
		
        /** @var Cpyree\Wrapper\BinWrapper\BinWrapperInterface */
        $id3v2wrapper = new Cpyree\Wrapper\BinWrapper\Id3v2Wrapper();
        $id3v2wrapper->setBin('/usr/local/bin/id3v2');
        
		if ($mediaInfoReader->write($metaDataFile)) {
			//it's done!
		}
    }
```

### Create custom Wrapper

```php
<?php

class MyClass
{

}
```


## Tests

Make sure you have mediainfo available at location /usr/bin/mediainfo.


Make sure you have eyeD3 available at location /usr/local/bin/eyeD3


Bench:
phpunit --group eyed3-read --repeat 100
phpunit --group mediainfo-read --repeat 100