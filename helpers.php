<?php

declare(strict_types=1);

namespace App\helpers;

// font pixel size for tag cloud
function tagSize (?int $count): int {
    if ($count <= 2) {
        return 10;
    } elseif ($count <= 5) {
        return 12;
    } elseif ($count <= 10) {
        return 14;
    } elseif ($count <= 15) {
        return 16;
    } elseif ($count <= 20) {
        return 18;
    } elseif ($count <= 25) {
        return 20;
    } elseif ($count <= 30) {
        return 22;
    } elseif ($count > 30) {
        return 24;
    }

    return 16;
}

