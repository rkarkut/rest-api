<?php declare(strict_types=1);

namespace App\Domain\Items\Validator;

use App\Domain\Items\ItemsException;
use Assert\Assertion as BaseAssertion;

/**
 * Class Assertion
 * @package Microservice\Domain\AccountSettings
 */
class Assertion extends BaseAssertion
{
    protected static $exceptionClass = ItemsException::class;
}
