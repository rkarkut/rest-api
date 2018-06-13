<?php declare(strict_types=1);

namespace App\Controller\Presenter;

use App\Domain\Items\ItemsCollection;
use App\Entity\Item;

/**
 * Class ItemsPresenter
 * @package App\Controller\Presenter
 */
class ItemsPresenter
{
    /** @var ItemsCollection */
    private $itemsCollection;

    public function __construct($itemsCollection)
    {
        $this->itemsCollection = $itemsCollection;
    }

    /**
     * @return array
     */
    public function present(): array
    {
        $items = [];

        /** @var Item $item */
        foreach ($this->itemsCollection as $item) {
            $items[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'amount' => $item->getAmount()
            ];
        }

        return ['items' => $items];
    }
}
