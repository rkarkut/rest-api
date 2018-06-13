<?php declare(strict_types=1);

namespace App\Controller\Presenter;

use App\Domain\Items\ItemsCollection;
use App\Entity\Item;

/**
 * Class ItemPresenter
 * @package App\Controller\Presenter
 */
class ItemPresenter
{
    /** @var Item */
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return array
     */
    public function present(): array
    {
        return [
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'amount' => $this->item->getAmount()
        ];
    }
}
