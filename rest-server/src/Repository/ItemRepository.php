<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Item::class);
    }

    /**
     * @param Criteria $criteria
     * @return Collection
     */
    public function getAllItems(Criteria $criteria)
    {
        return $this->matching($criteria);
    }

    /**
     * @param Item $item
     */
    public function persistItem(Item $item)
    {
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Item $item
     */
    public function removeItem(Item $item)
    {
        $this->getEntityManager()->remove($item);
        $this->getEntityManager()->flush();
    }
}
