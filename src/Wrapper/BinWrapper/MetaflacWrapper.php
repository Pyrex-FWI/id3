<?php

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Helper;
use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Class MetaflacWrapper
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
class MetaflacWrapper extends BinWrapperBase
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
            //@codeCoverageIgnoreStart
            throw new \Exception(sprintf('Read not supported for %s', $id3Metadata->getFile()->getRealPath()));
            //@codeCoverageIgnoreEnd
        }
        $result = false;

        $cmd = $this->getCommand($id3Metadata->getFile()->getRealPath());
        exec($cmd, $output, $return);

        if (!(bool)$return && preg_match_all("/^(?P<tag>[\w]*)=(?P<value>[\w\s\n\']*)$/m", implode(PHP_EOL, $output), $match)) {
            $this->rawReadOutput = array_combine($match['tag'], $match['value']);
            $id3Metadata
                ->setArtist($this->get('artist'))
                ->setAlbum($this->get('album'))
                ->setGenre($this->get('genre'))
                ->setComment($this->get('description'))
                ->setBpm($this->get('bpm'))
                ->setTitle($this->get('title'))
                ->setYear($this->get('date'))
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
        exec(sprintf('%s --v 2>&1 && true', $this->binPath), $output, $return_var);

        return implode(PHP_EOL, $output);
    }

    /**
     * @var string
     *
     * @return string
     */
    public function getCommand($file)
    {
        return sprintf('%s --export-tags-to=- %s', $this->binPath, $file);
    }

    /**
     * @return array
     */
    public function getSupportedExtensionsForWrite()
    {
        return [Helper::getFlacExt()];
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

        $cmd = (sprintf('%s  %s %s &> /dev/null', $this->binPath, escapeshellarg($id3Metadata->getFile()->getRealPath()), $this->buildCmdPart($id3Metadata)));
        exec($cmd, $output, $return_var);

        return !(bool)$return_var;
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
        return null !== $id3Metadata->getArtist() ? sprintf("--remove-tag=ARTIST --set-tag=%s", escapeshellarg('ARTIST='.$id3Metadata->getArtist())) : null;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function albumUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return null !== $id3Metadata->getAlbum() ? sprintf(" --remove-tag=ALBUM --set-tag=%s", escapeshellarg("ALBUM=".$id3Metadata->getAlbum())) : null;
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function titleUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return null !== $id3Metadata->getTitle() ? sprintf(" --remove-tag=TITLE --set-tag=%s", escapeshellarg('TITLE='.$id3Metadata->getTitle())) : null;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function genreUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return null !== $id3Metadata->getGenre() ? sprintf(" --remove-first-tag=GENRE --set-tag=%s", escapeshellarg('GENRE='.$id3Metadata->getGenre())) : null;
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function yearUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return null !== $id3Metadata->getYear() ? sprintf(" --remove-tag=DATE --set-tag=%s", escapeshellarg('DATE='.$id3Metadata->getYear())) : null;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function commentUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return  null !== $id3Metadata->getComment() ? sprintf(" --remove-tag=DESCRIPTION --set-tag=%s", escapeshellarg('DESCRIPTION='.$id3Metadata->getComment())) : null;
    }

    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return string
     */
    private function bpmUpdateCmd(Id3MetadataInterface $id3Metadata)
    {
        return null !== $id3Metadata->getBpm() ? sprintf(" --remove-tag=BPM --set-tag=%s", escapeshellarg('BPM='.$id3Metadata->getBpm())) : null;
    }

    /**
     * @param $key
     * @return null
     */
    private function get($key)
    {
        $key = strtoupper($key);
        return isset($this->rawReadOutput[$key]) ?  $this->rawReadOutput[$key] : null;
    }
}
