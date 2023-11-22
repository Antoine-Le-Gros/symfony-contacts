<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }
    /**
     * @return Contact[]
     */
    public function search(string $text = ''): array
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->addSelect('category');
        if ('' !== $text) {
            $qb->where('UPPER(c.lastname) LIKE UPPER(:text)')
                ->orWhere('UPPER(c.firstname) LIKE UPPER(:text)')
                ->setParameter('text', '%'.$text.'%');
        }

        return $qb->orderBy('c.lastname', 'ASC')
                    ->addOrderBy('c.firstname', 'ASC')
                    ->getQuery()
                    ->execute();
    }

    public function findWithCategory(int $id): ?Contact
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.category', 'category')
            ->addSelect('category')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()[0];
    }
}
