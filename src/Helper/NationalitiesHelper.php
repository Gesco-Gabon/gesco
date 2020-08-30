<?php declare(strict_types=1);

namespace Gesco\Helper;

use Symfony\Component\Serializer\SerializerInterface;

class NationalitiesHelper
{
    private static SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return string[]|array
     */
    public static function getNationalities()
    {
        $file = file_get_contents(__DIR__ . '/../Provider/Nationalities.json');
        if ($file) {
            return \json_decode($file, true);
        }

        return [];
    }
}