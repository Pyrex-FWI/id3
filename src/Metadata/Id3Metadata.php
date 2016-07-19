<?php

namespace Sapar\Id3\Metadata;

/**
 * Class Id3Metadata
 * @package Sapar\Id3\Metadata
 */
class Id3Metadata extends Id3MetadataBase implements \JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON.
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        $json = array();
        foreach ($this as $key => $value) {
            if ($key == 'file') {
                $json[$key] = $this->file->getRealPath();
                continue;
            }
            $json[$key] = $value;
        }

        return $json;
    }
}
