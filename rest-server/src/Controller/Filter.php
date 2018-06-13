<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Filter
 * @package App\Controller
 */
class Filter
{
    /** @var bool */
    private $availableItems;

    /** @var int */
    private $minAmount = 0;

    /**
     * @param bool $availableItems
     * @param int $minAmount
     */
    public function __construct(bool $availableItems, int $minAmount)
    {
        $this->availableItems = $availableItems;
        $this->minAmount = $minAmount;
    }

    /**
     * @param Request $request
     * @return Filter
     */
    public static function createFromRequest(Request $request): Filter
    {
        $query = $request->get('filter');
        return new self(
            (isset($query['available']) && 'true' == $query['available']) ? true : false,
            isset($query['minAmount']) ? (int) $query['minAmount'] : 0
        );
    }

    /**
     * @return bool
     */
    public function isAvailableItems(): bool
    {
        return $this->availableItems;
    }

    /**
     * @return int
     */
    public function getMinAmount(): int
    {
        return $this->minAmount;
    }
}
