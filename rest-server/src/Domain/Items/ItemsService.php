<?php declare(strict_types=1);

namespace App\Domain\Items;

use App\Controller\Filter;
use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\Criteria;

/**
 * Class ItemsService
 * @package App\Domain\Items
 */
class ItemsService
{
    /** @var ItemRepository */
    private $itemsRepository;

    /**
     * @param ItemRepository $repository
     */
    public function __construct(ItemRepository $repository)
    {
        $this->itemsRepository = $repository;
    }

    /**
     * @param Filter $filter
     * @return ItemsCollection
     */
    public function getAllItems(Filter $filter): ItemsCollection
    {
        $collection = new ItemsCollection();

        $criteria = new Criteria();

        if ($filter->isAvailableItems()) {

            if ($filter->getMinAmount() > 0) {
                $criteria->where($criteria->expr()->gt('amount', $filter->getMinAmount()));
            } else {
                $criteria->where($criteria->expr()->gt('amount', 0));
            }
        } else {
            $criteria->where($criteria->expr()->eq('amount', 0));
        }

        $items = $this->itemsRepository->getAllItems($criteria);

        if (empty($items)) {
            return $collection;
        }

        foreach ($items as $item) {
            $collection->push($item);
        }

        return $collection;
    }

    /**
     * @param CreateItemCommand $createItemCommand
     * @return Item
     */
    public function createItem(CreateItemCommand $createItemCommand): Item
    {
        $item = new Item(
            0,
            $createItemCommand->getName(),
            $createItemCommand->getAmount()
        );

        $this->itemsRepository->persistItem($item);
        return $item;
    }

    /**
     * @param int $id
     */
    public function deleteItem(int $id): void
    {
        $item = $this->itemsRepository->find($id);

        if (empty($item)) {
            return;
        }

        $this->itemsRepository->removeItem($item);
    }

    /**
     * @param int $id
     * @param CreateItemCommand $command
     * @return Item
     * @throws ItemsException
     */
    public function updateItem(int $id, CreateItemCommand $command): Item
    {
        $item = $this->itemsRepository->find($id);

        if(empty($item)) {
            throw ItemsException::createWhenItemNotFound();
        }

        $item->setName($command->getName());
        $item->setAmount($command->getAmount());

        $this->itemsRepository->persistItem($item);
        return $item;
    }
}
