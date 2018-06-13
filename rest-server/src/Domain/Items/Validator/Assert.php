<?php declare(strict_types=1);

namespace App\Domain\Items\Validator;

use Assert\Assert as BaseAssert;

/**
 * Class Assert
 * @package Microservice\Domain\AccountSettings
 */
class Assert extends BaseAssert
{
    protected static $assertionClass = Assertion::class;
}
