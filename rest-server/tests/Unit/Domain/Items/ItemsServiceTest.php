<?php
namespace Tests\Unit\Domain\Items;
use App\Controller\Filter;
use App\Domain\Items\CreateItemCommand;
use App\Domain\Items\ItemsCollection;
use App\Domain\Items\ItemsService;
use App\Entity\Item;
use App\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class ItemsServiceTest
 * @package Tests\Unit\Domain\Items
 */
class ItemsServiceTest extends TestCase
{
    /** @var ItemRepository | \PHPUnit_Framework_MockObject_MockObject */
    private $itemsRepositoryMock;

    public function setUp()
    {
        $this->itemsRepositoryMock = $this->getMockBuilder(ItemRepository::class)->disableOriginalConstructor()->getMock();
    }

    /**
     * @test
     */
    public function shouldGetAllItems()
    {
        $id = 4;
        $name = 'foo';
        $amount = 3;

        $this->itemsRepositoryMock->expects($this->once())->method('getAllItems')->willReturn([new Item($id, $name, $amount)]);
        $filter = new Filter(false, 0);

        $service = new ItemsService($this->itemsRepositoryMock);
        $items = $service->getAllItems($filter);

        self::assertInstanceOf(ItemsCollection::class, $items);

        /** @var Item $item */
        $item = $items[0];

        self::assertEquals($id, $item->getId());
        self::assertEquals($name, $item->getName());
        self::assertEquals($amount, $item->getAmount());
    }

    /**
     * @test
     */
    public function shouldCreateItem()
    {
        $name = 'foo';
        $amount = 3;

        $this->itemsRepositoryMock->expects($this->once())->method('persistItem')->willReturn(null);

        $service = new ItemsService($this->itemsRepositoryMock);
        $item = $service->createItem(new CreateItemCommand(
            $name, $amount
        ));

        self::assertInstanceOf(Item::class, $item);
        self::assertEquals($name, $item->getName());
        self::assertEquals($amount, $item->getAmount());
    }

    /**
     * @test
     */
    public function shouldUpdateItem()
    {
        $id = 4;
        $name = 'foo';
        $amount = 3;

        $this->itemsRepositoryMock->expects($this->once())->method('find')->willReturn(new Item($id, $name, $amount));

        $service = new ItemsService($this->itemsRepositoryMock);
        $item = $service->updateItem($id, new CreateItemCommand(
            $name, $amount
        ));

        self::assertInstanceOf(Item::class, $item);
        self::assertEquals($id, $item->getId());
        self::assertEquals($name, $item->getName());
        self::assertEquals($amount, $item->getAmount());
    }

    /**
     * @test
     */
    public function shouldDeleteItem()
    {
        $id = 4;
        $name = 'foo';
        $amount = 3;

        $this->itemsRepositoryMock->method('persistItem')->willReturn(null);


        $this->itemsRepositoryMock->expects($this->once())->method('find')->willReturn(new Item($id, $name, $amount));

        $service = new ItemsService($this->itemsRepositoryMock);
        $service->deleteItem($id);
    }
}
