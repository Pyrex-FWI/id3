<?php
/**
 * @author Christophe Pyree <christophe.pyree[at]gmail.com>
 * Date: 17/12/15
 */

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Metadata\Id3MetadataInterface;

/**
 * Class BinWrapperBase
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
abstract class BinWrapperBase implements  BinWrapperInterface
{
    protected $binPath;

    /**
     * @param string $binPath
     *
     * @return MediainfoWrapper
     *
     * @throws \Exception
     */
    public function setBinPath($binPath)
    {
        if ((!file_exists($binPath)  || !is_executable($binPath)) && strstr($binPath, ' ') === false) {
            throw new \Exception(sprintf('%s not exist // or not executable', $binPath));
        }

        $this->binPath = $binPath;

        return $this;
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function supportRead(Id3MetadataInterface $id3Metadata)
    {
        return in_array($id3Metadata->getFile()->getExtension(), $this->getSupportedExtensionsForRead());
    }
    /**
     * @param Id3MetadataInterface $id3Metadata
     *
     * @return bool
     */
    public function supportWrite(Id3MetadataInterface $id3Metadata)
    {
        return in_array($id3Metadata->getFile()->getExtension(), $this->getSupportedExtensionsForWrite());
    }
}
