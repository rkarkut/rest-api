<?php declare(strict_types=1);

namespace App\Domain\Items;

use App\Domain\Items\Validator\Assert;

/**
 * Class CreateItemCommand
 * @package App\Controller
 */
class CreateItemCommand
{
    /** @var string */
    private $name;

    /** @var int */
    private $amount;

    /**
     * @param string $name
     * @param int $amount
     * @throws ItemsException
     */
    public function __construct($name, $amount)
    {
        Assert::that($name)->string()->notBlank();
        Assert::that($amount)->integer()->notEmpty();

        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @param array $params
     * @return CreateItemCommand
     * @throws ItemsException
     */
    public static function createFromRequest(array $params): CreateItemCommand
    {
        $name = isset($params['name']) ? $params['name'] : null;
        $amount = isset($params['amount']) ? $params['amount'] : null;

        return new self($name, $amount);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
