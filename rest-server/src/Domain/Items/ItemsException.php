<?php declare(strict_types=1);

namespace App\Domain\Items;

/**
 * Class ItemsException
 * @package App\Domain\Items
 */
class ItemsException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
