<?php

namespace Mrpix\CloudPrintSDK\Components;

class MediaTypes
{
    public const TEXT_PLAIN = 'text/plain';
    public const TEXT_VND_STAR_MARKUP = 'text/vnd.star.markup';
    public const APPLICATION_VND_STAR_STARPRNT = 'application/vnd.star.starprnt';
    public const IMAGE_PNG = 'image/png';

    // MimeType | FileEnding
    public const MEDIATYPE_MAP = [
        'text/plain' => [
            'ext' => 'txt',
            'desc' => 'Plain Text'
        ],
        'image/png' => [
            'ext' => 'png',
            'desc' => 'Portable Network Graphics'
        ],
        'text/vnd.star.markup' => [
            'ext' => 'stm',
            'desc' => 'Star Document Markup'
        ],
        'application/vnd.star.starprnt' => [
            'ext' => 'bin',
            'desc' => 'Compiled StarPRNT Document'
        ]
    ];

    public const ALLOWED_INPUT_MEDIATYPES = [
        self::TEXT_PLAIN,
        self::TEXT_VND_STAR_MARKUP,
        self::IMAGE_PNG
    ];

    public static function getFileExtension(string $mediaType): ?string
    {
        if (array_key_exists($mediaType, self::MEDIATYPE_MAP)) {
            return self::MEDIATYPE_MAP[$mediaType]['ext'];
        } else {
            return null;
        }
    }

    public static function getDescription(string $mediaType): ?string
    {
        if (array_key_exists($mediaType, self::MEDIATYPE_MAP)) {
            return self::MEDIATYPE_MAP[$mediaType]['desc'];
        } else {
            return null;
        }
    }

    public static function isAllowedInputMediaType(string $mediaType): bool
    {
        return in_array($mediaType, self::ALLOWED_INPUT_MEDIATYPES);
    }
}
