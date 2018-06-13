<?php declare(strict_types=1);

namespace App\Domain\Items;

use App\Entity\Item;
use Gamez\Illuminate\Support\TypedCollection;

/**
 * Class ItemsCollection
 * @package App\Domain\Items
 */
class ItemsCollection extends TypedCollection
{
    protected static $allowedTypes = [Item::class];
}
