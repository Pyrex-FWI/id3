<?php

namespace Cpyree\Id3\Test;


class Helper
{
	public static function getSampeMp3File()
	{
		return __DIR__ . '/toddle.mp3';
	}

	public static function getWrongMp3File()
	{
		return __DIR__ . '/wrong_file.mp3';
	}

	public static function getMediainfoPath()
	{
		return '/usr/bin/mediainfo';
	}

	public static function getEyed3Path()
	{
		return '/usr/local/bin/eyeD3';
	}

}