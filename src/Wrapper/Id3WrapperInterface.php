<?php
/**
 * @author Christophe Pyree <christophe.pyree[at]gmail.com>
 */

namespace Sapar\Id3\Wrapper;

use Sapar\Id3\Reader\Id3ReaderInterface;
use Sapar\Id3\Writer\Id3WriterInterface;

/**
 * Interface Id3WrapperInterface
 * @package Sapar\Id3\Wrapper
 */
interface Id3WrapperInterface extends Id3ReaderInterface, Id3WriterInterface
{
}
