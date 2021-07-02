<?php

namespace App\Fetcher;

use App\Handler\ErrorHandler;
use DateTime;
use Exception;

class NBPFetcher
{
    use ErrorHandler;

    private string $url = 'https://api.nbp.pl/api/exchangerates/tables/a/';

    public function fetch(): array
    {
        try {
            $today = (new DateTime())->format('Y-m-d');
            $this->url .= $today . '?format=json';
            return json_decode(file_get_contents($this->url), true)[0];
        } catch (Exception $e) {
            $this->addNamedError('Request error', $e->getMessage());
            return [];
        }
    }
}