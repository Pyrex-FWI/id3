<?php

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Helper;
use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Class Eyed3Wrapper
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
class Eyed3Wrapper extends BinWrapperBase
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
        $result = false;
        //@codeCoverageIgnoreStart
        if (!$this->supportRead($id3Metadata)) {
            throw new \Exception('Read not supported for %s', $id3Metadata->getFile()->getRealPath());
        } //@codeCoverageIgnoreEnd
        $cmd = $this->getCommand($id3Metadata->getFile()->getRealPath());
        exec($cmd, $output, $return);

        if (!boolval($return)) {
            $this->rawReadOutput = implode(PHP_EOL, $output);

            $id3Metadata
                ->setArtist($this->getFromRegex('/^artist:\s(?P<artist>.*)$/m', 'artist'))
                ->setAlbum($this->getFromRegex('/^album:\s(?P<album>.*)$/m', 'album'))
                ->setGenre($this->getFromRegex('/genre:\s(?P<genre>.*)\s\(.*\)$/m', 'genre'))
                ->setComment($this->getFromRegex('/^Comment:\s.*?\n^(?P<comment>.*)$/m', 'comment'))
                ->setBpm($this->getFromRegex('/^BPM:\s(?P<bpm>\d{1,3})$/m', 'bpm'))
                ->setTitle($this->getFromRegex('/^title:\s(?P<title>.*)$/m', 'title'))
                ->setYear($this->getFromRegex('/^recording\sdate:\s(?P<recording_date>\d{4})$/m', 'recording_date'))
            ;

            $result = true;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        exec(sprintf('%s --version 2>&1 && true', $this->binPath), $output, $return_var);

        return implode(PHP_EOL, $output);
    }

    /**
     * @var string
     *
     * @return string
     */
    public function getCommand($file)
    {
        return sprintf('%s --no-color --v2 %s 2> /dev/null', $this->binPath, $file);
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForWrite()
    {
        return [Helper::getMp3Ext(), Helper::getMp4Ext()];
    }

    /**
     * /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function write(Id3MetadataInterface $id3Metadata)
    {
        if (!$this->supportWrite($id3Metadata)) {
            //@codeCoverageIgnoreStart
            throw new \Exception('Write not supported for %s', $id3Metadata->getFile()->getRealPath());
            //@codeCoverageIgnoreEnd
        }

        $cmd = (sprintf('%s --log-level critical  --quiet %s %s &> /dev/null && echo $?', $this->binPath, escapeshellarg($id3Metadata->getFile()->getRealPath()), $this->buildCmdPart($id3Metadata)));
        exec($cmd, $output, $return_var);

        return !(boolval($return_var));
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForRead()
    {
        return $this->getSupportedExtensionsForWrite();
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

        if (!is_null($id3Metadata->getArtist())) {
            $result = sprintf(" --artist '%s'", $id3Metadata->getArtist());
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

        if (!is_null($id3Metadata->getAlbum())) {
            $result = sprintf(' --album %s', escapeshellarg($id3Metadata->getAlbum()));
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

        if (!is_null($id3Metadata->getTitle())) {
            $result =  sprintf(' --title %s', escapeshellarg($id3Metadata->getTitle()));
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

        if (!is_null($id3Metadata->getGenre())) {
            $result = sprintf(' --genre %s', escapeshellarg($id3Metadata->getGenre()));
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

        if (!is_null($id3Metadata->getYear())) {
            $result = sprintf(' --release-year %1$s --orig-release-date=%1$s', escapeshellarg($id3Metadata->getYear()));
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

        if (!is_null($id3Metadata->getComment())) {
            $result = sprintf(' --comment %s', escapeshellarg($id3Metadata->getComment()));
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

        if (!is_null($id3Metadata->getBpm())) {
            $result =  sprintf(' --bpm %s', escapeshellarg($id3Metadata->getBpm()));
        }
        return $result;
    }

    /**
     * @param $patern
     * @param $namedSubMask
     * @return null
     */
    private function getFromRegex($patern, $namedSubMask)
    {
        preg_match_all($patern, $this->rawReadOutput, $match);

        return isset($match[$namedSubMask][0]) ? $match[$namedSubMask][0] : null;
    }
}
