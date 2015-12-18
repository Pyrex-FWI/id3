<?php

namespace Cpyree\Id3\Reader;

use Cpyree\Id3\Metadata\Id3MetadataInterface;

interface Id3ReaderInterface {

	/**
	 * @param Id3MetadataInterface  $id3Metadata
	 * @return bool
	 */
	public function read(Id3MetadataInterface $id3Metadata);

	/**
	 * @param Id3MetadataInterface $id3Metadata
	 * @return bool
	 */
	public function supportRead(Id3MetadataInterface $id3Metadata);

	/**
	 * @return array
	 */
	public function getSupportedExtensionsForRead();

}