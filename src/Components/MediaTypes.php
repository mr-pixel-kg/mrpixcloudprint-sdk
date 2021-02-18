<?php

namespace Mrpix\CloudPrintSDK\Components;

class MediaTypes
{
    const TEXT_PLAIN = 'text/plain';
    const TEXT_VND_STAR_MARKUP = 'text/vnd.star.markup';
    const APPLICATION_VND_STAR_STARPRNT = 'application/vnd.star.starprnt';
    const IMAGE_PNG = 'image/png';

    // MimeType | FileEnding
    const MEDIATYPE_MAP = [
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

    const ALLOWED_INPUT_MEDIATYPES = [
        self::TEXT_PLAIN,
        self::TEXT_VND_STAR_MARKUP,
        self::IMAGE_PNG
    ];

    public static function getFileExtension(string $mediaType) : ?string
    {
        if(in_array($mediaType, array_keys(self::MEDIATYPE_MAP))){
            return self::MEDIATYPE_MAP[$mediaType]['ext'];
        }else{
            return null;
        }
    }

    public static function getDescription(string $mediaType) : ?string
    {
        if(in_array($mediaType, array_keys(self::MEDIATYPE_MAP))){
            return self::MEDIATYPE_MAP[$mediaType]['desc'];
        }else{
            return null;
        }
    }

    public static function isAllowedInputMediaType(string $mediaType) : bool
    {
        return in_array($mediaType, self::ALLOWED_INPUT_MEDIATYPES);
    }
}