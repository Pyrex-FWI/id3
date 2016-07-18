<?php

namespace Sapar\Id3\Wrapper\BinWrapper;

use Sapar\Id3\Wrapper\Id3WrapperInterface;

/**
 * Interface BinWrapperInterface
 * @package Sapar\Id3\Wrapper\BinWrapper
 */
interface BinWrapperInterface extends Id3WrapperInterface
{
    /**
     * @return string
     */
    public function getVersion();

    /**
     * @var string
     *
     * @return BinWrapperInterface
     */
    public function setBinPath($binPath);

    /**
     * @var string
     *
     * @return string
     */
    public function getCommand($file);
}
