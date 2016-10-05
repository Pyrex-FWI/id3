<?php

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Helper;
use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Class MediainfoWrapper
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
class MediainfoWrapper extends BinWrapperBase implements BinWrapperInterface
{
    private $rawReadOutput;

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function read(Id3MetadataInterface $id3Metadata)
    {
        if (!$this->supportRead($id3Metadata)) {
            throw new \Exception(sprintf('Read not supported for %s', $id3Metadata->getFile()->getRealPath()));
        }

        $cmd = $this->getCommand($id3Metadata->getFile()->getRealPath());
        $this->logger->info(sprintf('cmd is %s', $cmd));
        $out = shell_exec($cmd);
        $out = substr($out, strpos($out, '<?xml'), strlen($out));

        $simpleXMLElement = @simplexml_load_string($out);
        if (! $simpleXMLElement instanceof  \SimpleXMLElement) {
            return false;
        }
        if ($simpleXMLElement->attributes('ref') == $id3Metadata->getFile()->getRealPath()) {
            /* @var \SimpleXMLElement $simpleXMLElement */
            $this->rawReadOutput = $simpleXMLElement->File[0]->track[0];
            if ($this->getFileSize() > 0) {
                $this->normalize($id3Metadata);

                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return exec(sprintf('%s --Version', $this->binPath));
    }

    /**
     * @var string
     *
     * @return string
     */
    public function getCommand($file)
    {
        return sprintf('%s --Full --Output=XML %s 2>&1', $this->binPath, escapeshellarg($file));
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForRead()
    {
        return [Helper::getFlacExt(), Helper::getMp3Ext(), Helper::getMp4Ext()];
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function write(Id3MetadataInterface $id3Metadata)
    {
        // TODO: Implement write() method.
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForWrite()
    {
        return [];
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     */
    private function normalize(Id3MetadataInterface $id3Metadata)
    {
        $id3Metadata->setTitle($this->get('Title'));
        $id3Metadata->setArtist($this->get('Performer'));
        $id3Metadata->setAlbum($this->get('Album'));
        $id3Metadata->setGenre($this->get('Genre'));
        $id3Metadata->setYear($this->extractYear($this->get('Original_Released_date')? $this->get('Original_Released_date') : $this->get('Recorded_date')));
        $id3Metadata->setComment($this->get('Comment'));
        $id3Metadata->setBpm($this->get('BPM'));
        $id3Metadata->setTimeDuration($this->getDuration());
    }

    /**
     * To check UTC 2014-10- 7.
     *
     * @param $rawRecordedDate
     *
     * @return int
     */
    private function extractYear($rawRecordedDate)
    {
        preg_match_all('/^(...)?\s?(?P<year>\d{4})(\-\s?\d{1,2}\-\s?\d{1,2})?$/', $rawRecordedDate, $match_all);
        if (isset($match_all['year'][0])) {
            return intval($match_all['year'][0]);
        }
    }

    /**
     * @return string
     */
    private function get($tagName)
    {
        if ($this->rawReadOutput->{$tagName}) {
            return $this->rawReadOutput->{$tagName}->__toString();
        }
    }

    /**
     * @return float
     */
    private function getDuration()
    {
        if ($this->rawReadOutput->Duration[0]) {
            return $this->rawReadOutput->Duration[0]->__toString() / 1000;
        }
    }

    /**
     * @return int
     */
    private function getFileSize()
    {
        if ($this->rawReadOutput->File_size[0]) {
            return intval($this->rawReadOutput->File_size[0]->__toString());
        }
    }
}
