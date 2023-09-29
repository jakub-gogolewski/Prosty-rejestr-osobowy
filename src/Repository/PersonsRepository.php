<?php

namespace App\Repository;

use App\Entity\Persons;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Persons>
 *
 * @method Persons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Persons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Persons[]    findAll()
 * @method Persons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

 
class PersonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persons::class);
    }

    public function searchPersonsAndAddresses($searchTerm)
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p')
            ->leftJoin('p.Adress', 'a')
            ->where('p.name LIKE :searchTerm OR p.surname LIKE :searchTerm OR p.age LIKE :searchTerm OR p.sex LIKE :searchTerm OR a.postal LIKE :searchTerm OR a.city LIKE :searchTerm OR a.street LIKE :searchTerm OR a.street_number LIKE :searchTerm OR a.flat_number LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%');
    
        $persons = $qb->getQuery()->getResult();
    
        // Jeśli szukana fraza pasuje do "Brak adresów"
        if (stripos('Brak adresów', $searchTerm) !== false) {
            $personsWithoutAddresses = $this->createQueryBuilder('p')
                ->select('p')
                ->leftJoin('p.Adress', 'a')
                ->where('a.id IS NULL')
                ->getQuery()
                ->getResult();
                
            // Łączymy wyniki tak, aby uniknąć powtórzeń
            $persons = array_unique(array_merge($persons, $personsWithoutAddresses), SORT_REGULAR);
        }
    
        return $persons;
    }
    
    

//    /**
//     * @return Persons[] Returns an array of Persons objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Persons
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
