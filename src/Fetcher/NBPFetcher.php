<?php

namespace App\Fetcher;

use App\Handler\ErrorHandler;
use DateTime;
use Exception;

class NBPFetcher
{
    use ErrorHandler;

    private string $url = 'https://api.nbp.pl/api/exchangerates/tables/a/';
    private string $date;

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function fetch(): array
    {
        try {
            $date = $this->date ?? (new DateTime())->format('Y-m-d');
            $this->url .= $date . '?format=json';
            $outcome = json_decode(file_get_contents($this->url), true)[0];
            return is_array($outcome) ? $outcome : [];
        } catch (Exception $e) {
            $this->addNamedError('Request error', $e->getMessage());
            return [];
        }
    }
}