<?php

namespace JohnPaulMontilla\Scrappa\Exceptions;

class ScrappaRequestException extends ScrappaException
{
    public static function curlError(string $error): self
    {
        return new self("cURL error: {$error}");
    }

    public static function httpError(int $status, string $response = ''): self
    {
        return new self("API request failed with status {$status}: {$response}", $status);
    }
}
