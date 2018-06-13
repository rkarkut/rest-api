<?php
namespace Tests\Unit\Domain\Items;

use App\Domain\Items\CreateItemCommand;
use App\Domain\Items\ItemsException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

/**
 * Class CreateItemCommandTest
 * @package Tests\Unit\Domain\Items
 */
class CreateItemCommandTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCreateCommandFromRequest()
    {
        $name = 'foo';
        $amount = 4;

        $params = ['name' => $name, 'amount' => $amount];

        $command = CreateItemCommand::createFromRequest($params);

        self::assertEquals($name, $command->getName());
        self::assertEquals($amount, $command->getAmount());
    }

    /**
     * @test
     * @dataProvider getIncorrectParamsProvider
     */
    public function shouldThrowExceptionWhenIncorrectParams($name, $amount)
    {
        $this->expectException(ItemsException::class);

        $command = new CreateItemCommand($name, $amount);

        self::assertEquals($name, $command->getName());
        self::assertEquals($amount, $command->getAmount());
    }

    /**
     * @return array
     */
    public function getIncorrectParamsProvider(): array
    {
        return [
            ['', 9],
            ['foo', null]
        ];
    }
}
