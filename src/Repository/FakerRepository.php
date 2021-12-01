<?php

namespace App\Repository;


    
use App\Entity\Blog;
use App\Entity\Compte;
use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;

class FakerRepository
{
    /**
     * Variable $this->_em.
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Void __construct().
     *
     * @param EntityManagerInterface $em comment
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function findCategorie(): ?Categories
    {
        return $this->em->createQueryBuilder()
            ->select('C')
            ->from(Categories::class, 'C')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findBlog(): ?Blog
    {
        return $this->em->createQueryBuilder()
            ->select('B')
            ->from(Blog::class, 'B')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findCompte(): ?Compte
    {
        return $this->em->createQueryBuilder()
            ->select('C')
            ->from(Compte::class, 'C')
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}