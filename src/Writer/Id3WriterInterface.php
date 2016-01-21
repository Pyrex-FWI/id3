<?php

namespace Cpyree\Id3\Writer;

use Cpyree\Id3\Metadata\Id3MetadataInterface;

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
