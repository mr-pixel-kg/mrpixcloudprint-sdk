<?php

namespace Mrpix\CloudPrintSDK\Tests\Components;

use Mrpix\CloudPrintSDK\Components\MediaTypes;
use PHPUnit\Framework\TestCase;

class MediaTypesTest extends TestCase
{
    public function testGetFileExtension()
    {
        self::assertSame('txt', MediaTypes::getFileExtension(MediaTypes::TEXT_PLAIN));
        self::assertSame('png', MediaTypes::getFileExtension(MediaTypes::IMAGE_PNG));
        self::assertSame('stm', MediaTypes::getFileExtension(MediaTypes::TEXT_VND_STAR_MARKUP));
        self::assertSame('bin', MediaTypes::getFileExtension(MediaTypes::APPLICATION_VND_STAR_STARPRNT));
        self::assertNull(MediaTypes::getFileExtension('application/zip'));
    }

    public function testGetDescription()
    {
        self::assertSame('Portable Network Graphics', MediaTypes::getDescription(MediaTypes::IMAGE_PNG));
        self::assertSame('Compiled StarPRNT Document', MediaTypes::getDescription(MediaTypes::APPLICATION_VND_STAR_STARPRNT));
        self::assertNull(MediaTypes::getDescription('application/zip'));
    }

    public function testIsAllowedInputMediaType()
    {
        self::assertTrue(MediaTypes::isAllowedInputMediaType(MediaTypes::TEXT_PLAIN));
        self::assertTrue(MediaTypes::isAllowedInputMediaType(MediaTypes::TEXT_VND_STAR_MARKUP));
        self::assertTrue(MediaTypes::isAllowedInputMediaType(MediaTypes::IMAGE_PNG));
        self::assertFalse(MediaTypes::isAllowedInputMediaType(MediaTypes::APPLICATION_VND_STAR_STARPRNT));
        self::assertFalse(MediaTypes::isAllowedInputMediaType('image/jpeg'));
    }
}