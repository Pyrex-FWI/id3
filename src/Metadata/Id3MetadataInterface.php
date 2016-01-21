<?php

namespace Cpyree\Id3\Metadata;

interface Id3MetadataInterface
{
    /**
     * @return \SplFileInfo
     */
    public function getFile();
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     *
     * @return Id3MetadataBase
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getArtist();

    /**
     * @param string $artist
     *
     * @return Id3MetadataBase
     */
    public function setArtist($artist);

    /**
     * @return string
     */
    public function getAlbum();

    /**
     * @param string $album
     *
     * @return Id3MetadataBase
     */
    public function setAlbum($album);

    /**
     * @return array
     */
    public function getAllArtists();

    /**
     * @param array $artists
     *
     * @return Id3MetadataBase
     */
    public function setAllArtists($artists);

    /**
     * @return string
     */
    public function getGenre();

    /**
     * @param string $genre
     *
     * @return Id3MetadataBase
     */
    public function setGenre($genre);

    /**
     * @return array
     */
    public function getAllGenres();

    /**
     * @param array $genres
     *
     * @return Id3MetadataBase
     */
    public function setAllGenres($genres);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     *
     * @return Id3MetadataBase
     */
    public function setComment($comment);

    /**
     * @return int
     */
    public function getYear();

    /**
     * @param int $year
     *
     * @return Id3MetadataBase
     */
    public function setYear($year);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param
     * string $key
     *
     * @return Id3MetadataBase
     */
    public function setKey($key);

    /**
     * @return string
     */
    public function getBpm();

    /**
     * @param
     * string $bpm
     *
     * @return Id3MetadataBase
     */
    public function setBpm($bpm);

    /**
     * Time in seconds.
     *
     * @return int
     */
    public function getTimeDuration();

    /**
     * @param $time
     *
     * @return $this
     */
    public function setTimeDuration($time);
}
