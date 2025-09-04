<?php

namespace JohnPaulMontilla\Scrappa\Exceptions;

class ScrappaResponseException extends ScrappaException
{
    public static function invalidJson(string $message): self
    {
        return new self("Invalid JSON response: {$message}");
    }
}
