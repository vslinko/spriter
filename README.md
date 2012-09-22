# Spriter

PHP library for compiling css sprites

## Installation

Spriter is distributed by [composer](http://getcomposer.org).
You must install composer before you can install spriter.

If you have composer installed than run in your project root:

```
composer.phar require rithis/spriter:@dev
```

## Usage

### Spriter console

Composer installs spriter console in your project.
Now you can simple create you sprite: 

```
./vendor/bin/spriter css --recursive web/images --output web
```

That command recursively scans directory `web/images` for images
and write result sprite files in `web/sprite.png` and `web/sprite.css`.
