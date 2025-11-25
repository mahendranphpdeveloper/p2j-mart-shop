<?php

namespace App\Helpers;

class ColorHelper
{
    public static function hexToName($hex)
    {
        $map = [
            '#000000' => 'Black',
            '#FFFFFF' => 'White',
            '#FF0000' => 'Red',
            '#DB2929' => 'Red',
            '#C51B1B' => 'Dark Red',
            '#830BE5' => 'Purple',
            '#26F816' => 'Green',
            '#431CCE' => 'Blue',
            '#452121' => 'Brown',
            '#FFFF00' => 'Yellow',
            '#FFA500' => 'Orange',
            '#800080' => 'Violet',
            // Add more as needed
        ];

        $hex = strtoupper(trim($hex));
        return $map[$hex] ?? $hex; // Fallback to hex if no match
    }
}
