

# id3 Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)
[![Build Status](https://travis-ci.org/Pyrex-FWI/id3.svg?branch=master)](https://travis-ci.org/Pyrex-FWI/id3)


## Tests

Make sure you have mediainfo available at location /usr/bin/mediainfo.


Make sure you have eyeD3 available at location /usr/local/bin/eyeD3


Bench:
phpunit --group eyed3-read --repeat 100
phpunit --group mediainfo-read --repeat 100