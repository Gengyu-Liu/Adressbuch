<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('highlight', [$this, 'highlightKeyword']),
        ];
    }

    public function highlightKeyword($value, $keyword)
    {
        $value = preg_replace("/($keyword)/i", '<span style="background-color:#FFFF00;">$1</span>', $value);
        return $value;
    }
}
