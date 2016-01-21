<?php
/**
 * @author Christophe Pyree <christophe.pyree[at]gmail.com>
 */

namespace Cpyree\Id3\Wrapper;

use Cpyree\Id3\Reader\Id3ReaderInterface;
use Cpyree\Id3\Writer\Id3WriterInterface;

interface Id3WrapperInterface extends Id3ReaderInterface, Id3WriterInterface
{
}
