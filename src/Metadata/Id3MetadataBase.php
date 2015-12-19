<?php

namespace Cpyree\Id3\Metadata;


abstract class Id3MetadataBase implements Id3MetadataInterface
{

    /**
     * @var \SplFileInfo
     */
    protected $file;

    /**
     * @var string
     */
    private $album;

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $artist;
    /**
     * @var array
     */
    private $artists = [];
    /**
     * @var string
     */
    private $genre;
    /**
     * @var array
     */
    private $genres = [];
    /**
     * @var string
     */
    private $comment;
    /**
     * @var int
     */
    private $year;
    /**
     * @var string
     */
    private $key;
    /**
     * @var int
     */
    private $bpm;
    /**
     * @var int
     */
    private $duration;

    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \Exception(sprintf('%s not exist', $filePath));
        }
        $this->file = new  \SplFileInfo($filePath);
    }

    /**
     * @return \SplFileInfo
     */
    final public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Id3MetadataBase
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param string $artist
     * @return Id3MetadataBase
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllArtists()
    {
        return $this->artists;
    }

    /**
     * @param array $artists
     * @return Id3MetadataBase
     */
    public function setAllArtists($artists)
    {
        $this->artists = $artists;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     * @return Id3MetadataBase
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllGenres()
    {
        return $this->genres;
    }

    /**
     * @param array $genres
     * @return Id3MetadataBase
     */
    public function setAllGenres($genres)
    {
        $this->genres = $genres;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Id3MetadataBase
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Id3MetadataBase
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }
    /**
     * @return int
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @param int $bpm
     * @return Id3MetadataBase
     */
    public function setBpm($bpm)
    {
        $this->bpm = floatval($bpm);
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Id3MetadataBase
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param string $album
     * @return Id3MetadataBase
     */
    public function setAlbum($album)
    {
        $this->album = $album;
        return $this;

    }

    /**
     * Time in seconds
     * @return int
     */
    public function getTimeDuration()
    {
        return $this->duration;
    }

    /**
     * @param $time
     * @return $this
     */
    public function setTimeDuration($time)
    {
        $this->duration = $time;
    }

}