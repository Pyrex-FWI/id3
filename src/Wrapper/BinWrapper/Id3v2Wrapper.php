<?php

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Helper;
use Sapar\Id3\Metadata\Id3MetadataInterface;
use Sapar\Id3\Spec\Frames;

/**
 * Class Id3v2Wrapper
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
class Id3v2Wrapper extends BinWrapperBase
{
    private $rawReadOutput;

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function read(Id3MetadataInterface $id3Metadata)
    {
        if (!$this->supportRead($id3Metadata)) {
            //@codeCoverageIgnoreStart
            throw new \InvalidArgumentException(sprintf('Read not supported for %s', $id3Metadata->getFile()->getRealPath()));
            //@codeCoverageIgnoreEnd
        }

        $result = false;
        $cmd = $this->getCommand($id3Metadata->getFile()->getRealPath());
        $this->rawReadOutput = trim(shell_exec($cmd));
        preg_match_all('/^(?P<frame>\w{4})(\s\([^:\n]*:?\s?)?:\s+(\([^:\n]*:?\s?)?(?P<value>[^:]*$)/m', $this->rawReadOutput, $out);
        $this->rawReadOutput = array_combine($out['frame'], $out['value']);
        if (count($this->rawReadOutput) > 1) {
            $this->normalize($id3Metadata);

            $result = true;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        exec(sprintf('%s --v', $this->binPath), $out);

        return implode(PHP_EOL, $out);
    }

    /**
     * @var string
     *
     * @return string
     */
    public function getCommand($file)
    {
        return sprintf('%s -l %s 2>&1', $this->binPath, escapeshellarg($file));
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForRead()
    {
        return [Helper::getMp3Ext(), Helper::getMp4Ext()];
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function write(Id3MetadataInterface $id3Metadata)
    {
        if (!$this->supportWrite($id3Metadata)) {
            //@codeCoverageIgnoreStart
            throw new \InvalidArgumentException(sprintf('Write not supported for %s', '' + $id3Metadata->getFile()->getRealPath()));
            //@codeCoverageIgnoreEnd
        }

        $cmd = (sprintf('%s  %s %s', $this->binPath, escapeshellarg($id3Metadata->getFile()->getRealPath()), $this->buildCmdPart($id3Metadata)));
        exec($cmd, $output, $return_var);

        return !(boolval($return_var));
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForWrite()
    {
        return $this->getSupportedExtensionsForRead();
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     */
    private function normalize(Id3MetadataInterface $id3Metadata)
    {
        $id3Metadata->setTitle($this->get('TIT2'));
        $id3Metadata->setArtist($this->get('TPE1'));
        $id3Metadata->setAlbum($this->get('TALB'));
        $id3Metadata->setGenre(preg_replace('/\s\(\d{2,3}\)/', '', $this->get('TCON')));
        $id3Metadata->setYear($this->get('TYER'));
        $id3Metadata->setComment($this->get('COMM'));
        $id3Metadata->setBpm($this->get('TBPM'));
        $id3Metadata->setTimeDuration($this->getDuration());
    }

    /**
     * @return string
     */
    private function get($tagName)
    {
        $result = null;
        if (isset($this->rawReadOutput[$tagName]) ) {
            $result = $this->rawReadOutput[$tagName];
        }
        return $result;
    }

    /**
     * @return float
     */
    private function getDuration()
    {
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function buildCmdPart(Id3MetadataInterface $id3Metadata)
    {
        return
            $this->artistUpdateCmd($id3Metadata).
            $this->albumUpdateCmd($id3Metadata).
            $this->titleUpdateCmd($id3Metadata).
            $this->genreUpdateCmd($id3Metadata).
            $this->yearUpdateCmd($id3Metadata).
            $this->commentUpdateCmd($id3Metadata).
            $this->bpmUpdateCmd($id3Metadata);
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function artistUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !== $id3Metadata->getArtist()) {
            $result = sprintf(" -a '%s'", $id3Metadata->getArtist());
        }
        return $result;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function albumUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !== $id3Metadata->getAlbum()) {
            $result = sprintf(' -A %s', escapeshellarg($id3Metadata->getAlbum()));
        }
        return $result;
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function titleUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !== $id3Metadata->getTitle()) {
            $result =  sprintf(' -t %s', escapeshellarg($id3Metadata->getTitle()));
        }
        return $result;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function genreUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !== $id3Metadata->getGenre()) {
            $result = sprintf(' -g %s', escapeshellarg($id3Metadata->getGenre()));
        }
        return $result;
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function yearUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !== $id3Metadata->getYear()) {
            $result = sprintf(' -y %s', escapeshellarg($id3Metadata->getYear()));
        }
        return $result;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function commentUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !==$id3Metadata->getComment()) {
            $result = sprintf(' -c %s', escapeshellarg($id3Metadata->getComment()));
        }
        return $result;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function bpmUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        $result = null;
        if (null !==$id3Metadata->getBpm()) {
            $result = sprintf(' --%s %s', Frames::bpm, escapeshellarg($id3Metadata->getBpm()));
        }
        return $result;
    }
}
