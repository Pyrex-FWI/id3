<?php

namespace Cpyree\Id3\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3MetadataInterface;

class MediainfoWrapper extends BinWrapperBase implements BinWrapperInterface
{

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return exec(sprintf('%s --Version', $this->binPath ));
	}


	/**
	 * @var string $file
	 * @return string
	 */
	public function getCommand($file)
	{
		return sprintf('%s --Full --Output=XML %s', $this->binPath, $file);
	}


}