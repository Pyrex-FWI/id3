<?php

namespace Cpyree\Id3\Wrapper\BinWrapper;


use Cpyree\Id3\Wrapper\Id3WrapperInterface;

interface BinWrapperInterface extends Id3WrapperInterface
{

	/**
	 * @return string
	 */
	public function getVersion();

	/**
	 * @var string $binPath
	 * @return BinWrapperInterface
	 */
	public function setBinPath($binPath);

	/**
	 * @var string $file
	 * @return string
	 */
	public function getCommand($file);
}