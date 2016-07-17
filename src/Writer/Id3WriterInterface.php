<?php

namespace Sapar\Id3\Writer;

use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Interface Id3WriterInterface
 * @package Sapar\Id3\Writer
 */
interface Id3WriterInterface
{
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function write(Id3MetadataInterface $id3Metadata);

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function supportWrite(Id3MetadataInterface $id3Metadata);

    /**
     * @return array
     */
    public function getSupportedExtensionsForWrite();
}
