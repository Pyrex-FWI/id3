<?php

namespace Sapar\Id3\Reader;

use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Interface Id3ReaderInterface
 * @package Sapar\Id3\Reader
 */
interface Id3ReaderInterface
{
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function read(Id3MetadataInterface $id3Metadata);

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function supportRead(Id3MetadataInterface $id3Metadata);

    /**
     * @return array
     */
    public function getSupportedExtensionsForRead();
}
