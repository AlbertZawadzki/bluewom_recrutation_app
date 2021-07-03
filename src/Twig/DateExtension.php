<?php

namespace App\Twig;

use DateInterval;
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
        $tomorrow = (new DateTime())->add(new DateInterval(60 * 60 * 24))->format('Y-m-d');
        $afterTomorrow = (new DateTime())->add(new DateInterval(60 * 60 * 24 * 2))->format('Y-m-d');
        $yesterday = (new DateTime())->sub(new DateInterval(60 * 60 * 24))->format('Y-m-d');
        $preYesterday = (new DateTime())->sub(new DateInterval(60 * 60 * 24 * 2))->format('Y-m-d');

        if ($lastUpdated === $today) {
            return 'dzisiaj';
        }
        if ($lastUpdated === $afterTomorrow) {
            return 'pojutrze';
        }
        if ($lastUpdated === $tomorrow) {
            return 'jutro';
        }
        if ($lastUpdated === $yesterday) {
            return 'wczoraj';
        }
        if ($lastUpdated === $preYesterday) {
            return 'przedwczoraj';
        }

        return $date->format('d.m.Y');
    }

}