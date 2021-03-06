<?php

namespace Blogger\BlogBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatest($limit, $offset, $userID)
    {
        $queryBuilder = $this->createQueryBuilder('post');

        if ($userID != null)
        {
            $queryBuilder
                ->where('post.user = ' . $userID)
                -> orderBy('post.id', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit);
        }
        else {
            $queryBuilder
                -> orderBy('post.id', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit);
        }


        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

}
