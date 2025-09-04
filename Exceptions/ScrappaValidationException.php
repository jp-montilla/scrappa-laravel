<?php

namespace JohnPaulMontilla\Scrappa\Exceptions;

class ScrappaValidationException extends ScrappaException
{
    public static function missingParameter(string $param): self
    {
        return new self("The parameter [{$param}] is required.");
    }
}
