<?php
/**
 *
 * @author Christophe Pyree <christophe.pyree[at]gmail.com>
 * Date: 17/12/15
 *
 */

namespace Cpyree\Id3\Wrapper\BinWrapper;


use Cpyree\Id3\Metadata\Id3MetadataInterface;

abstract class BinWrapperBase implements  BinWrapperInterface
{
	protected $binPath;
	private $rawReadOutput;
	/**
	 * @param Id3MetadataInterface $id3Metadata
	 * @return bool
	 */
	public function read(Id3MetadataInterface $id3Metadata)
	{
		$out = shell_exec($this->getCommand($id3Metadata->getFile()->getRealPath()));
		if ($out) {
			/** @var \SimpleXMLElement $simpleXMLElement */
			$simpleXMLElement = simplexml_load_string($out);
			$this->rawReadOutput = $simpleXMLElement->File[0]->track[0];
			//dump($this->rawReadOutput);
			$this->normalize($id3Metadata);
			return true;
		}

		return false;
	}

	/**
	 * @param Id3MetadataInterface $id3Metadata
	 * @return bool
	 */
	public function supportRead(Id3MetadataInterface $id3Metadata)
	{
		dump("supportRead not yet implemented");
	}

	/**
	 * @return array
	 */
	public function getSupportedExtensionsForRead()
	{
		// TODO: Implement getSupportedExtensionsForRead() method.
	}

	/**
	 * @param Id3MetadataInterface $id3Metadata
	 * @return bool
	 */
	public function write(Id3MetadataInterface $id3Metadata)
	{
		// TODO: Implement write() method.
	}

	/**
	 * @param array $id3Metadata
	 * @return bool
	 */
	public function supportWrite(Id3MetadataInterface $id3Metadata)
	{
		// TODO: Implement supportWrite() method.
	}

	/**
	 * @return array
	 */
	public function getSupportedExtensionsForWrite()
	{
		// TODO: Implement getSupportedExtensionsForWrite() method.
	}

	/**
	 * @param string $binPath
	 * @return MediainfoWrapper
	 * @throws \Exception
	 */
	public function setBinPath($binPath)
	{
		if (!is_file($binPath) || !is_executable($binPath)) {
			throw new \Exception(sprintf('% not exist or not executable', $binPath));
		}

		$this->binPath = $binPath;

		return $this;
	}

	/**
	 * @return string
	 */
	private function getTitle()
	{
		return $this->rawReadOutput->Title->__toString();
	}
	private function get($tagName)
	{
		return $this->rawReadOutput->{$tagName}->__toString();
	}
	private function normalize(Id3MetadataInterface $id3Metadata)
	{
		$id3Metadata->setTitle($this->get('Title'));
		$id3Metadata->setArtist($this->get('Performer'));
		$id3Metadata->setAlbum($this->get('Album'));
		$id3Metadata->setGenre($this->get('Genre'));
		$id3Metadata->setYear($this->get('Recorded_date'));
		$id3Metadata->setComment($this->get('Comment'));
		$id3Metadata->setBpm($this->get('BPM'));
	}
}