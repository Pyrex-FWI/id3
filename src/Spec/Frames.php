<?php

namespace Cpyree\Id3\Spec;

class Frames
{
    const album = 'TALB';
    const albumArtist = 'TPE2';
    const albumSortOrder = 'TSOA';
    const arranger = 'TPE4';
    const artist = 'TPE1';
    const audioDelay = 'TDLY';
    const audioLength = 'TLEN';
    const audioSize = 'TSIZ';
    const author = 'TOLY';
    const bpm = 'TBPM';
    const composer = 'TCOM';
    const conductor = 'TPE3';
    const copyright = 'TCOP';
    const date = 'TDAT';
    const discNumber = 'TPOS';
    const encodedBy = 'TENC';
    const encodingSettings = 'TSSE';
    const filename = 'TOFN';
    const fileOwner = 'TOWN';
    const fileType = 'TFLT';
    const genre = 'TCON';
    const grouping = 'TIT1';
    const initialKey = 'TKEY';
    const isrc = 'TSRC';
    const itunesAlbumSortOrder = 'TSO2';
    const itunesCompilationFlag = 'TCMP';
    const itunesComposerSortOrder = 'TSOC';
    const language = 'TLAN';
    const lyricist = 'TEXT';
    const mediaType = 'TMED';
    const mood = 'TMOO';
    const organization = 'TPUB';
    const originalAlbum = 'TOAL';
    const originalArtist = 'TOPE';
    const originalYear = 'TORY';
    const performerSortOrder = 'TSOP';
    const producedNotice = 'TPRO';
    const radioOwner = 'TRSO';
    const radioStationName = 'TRSN';
    const recordingDates = 'TRDA';
    const setSubtitle = 'TSST';
    const time = 'TIME';
    const title = 'TIT2';
    const titleSortOrder = 'TSOT';
    const track = 'TRCK';
    const version = 'TIT3';
    const year = 'TYER';
    const encodingTime = 'TDEN';
    const originalReleaseTime = 'TDOR';
    const releaseTime = 'TDRL';
    const taggingTime = 'TDTG';
    const wwwArtist = 'WOAR';
    const wwwCommercialInfo = 'WCOM';
    const wwwCopyright = 'WCOP';
    const wwwFileInfo = 'WOAF';
    const wwwPayment = 'WPAY';
    const wwwPublisher = 'WPUB';
    const wwwRadio = 'WORS';
    const wwwSource = 'WOAS';

    /**
     * Return all possible keys that reference artist information.
     *
     * @return array
     */
    public static function getArtistFrames()
    {
        return [
            self::artist,
            self::originalArtist,
            self::albumArtist,
        ];
    }

    /**
     * Return all possible keys that reference album information.
     *
     * @return array
     */
    public static function getAlbumFrames()
    {
        return [
            self::album,
            self::originalAlbum,
        ];
    }

    /**
     * Return all possible keys that reference title information.
     *
     * @return array
     */
    public static function getTitleFrames()
    {
        return [
            self::title,
            self::titleSortOrder,
            self::setSubtitle,
        ];
    }

    public static function getGenreFrames()
    {
        return [
            self::genre,
        ];
    }
}
