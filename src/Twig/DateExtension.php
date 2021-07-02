<?php

namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('get_stringed_date', [$this, 'getStringedDate']),
        ];
    }

    public function getStringedDate(DateTime $date): string
    {
        $lastUpdated = $date->format('Y-m-d');
        $today = (new DateTime())->format('Y-m-d');
        $tomorrow = (new DateTime())->format('Y-m-d');
        $yesterday = (new DateTime())->format('Y-m-d');


        if ($lastUpdated === $today) {
            return 'dzisiaj';
        }
        if ($lastUpdated === $tomorrow) {
            return 'jutro';
        }
        if ($lastUpdated === $yesterday) {
            return 'wczoraj';
        }
        return $date->format('d.m.Y');
    }

}