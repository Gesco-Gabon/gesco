<?php declare(strict_types=1);

namespace Gesco\Helper;

class IdentityHelper
{
    protected const ID = ["CNI", "PASS", "AN", "CS"];

    public static function getValidIdentities(): array
    {
        return self::ID;
    }
}