<?php

namespace AppBundle\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class ProductRepository extends BaseProductRepository
{
    /**
     * {@inheritdoc}
     */
    public function findLatestByChannelAndTaxonCode(ChannelInterface $channel, $code, $count)
    {
        return $this->createQueryBuilder('o')
            ->innerJoin('o.channels', 'channel')
            ->addOrderBy('o.createdAt', 'desc')
            ->andWhere('o.enabled = true')
            ->andWhere('channel = :channel')
            ->innerJoin('o.associations', 'association')
            ->andWhere('association.id = :code')
            ->setParameter('channel', $channel)
            ->setParameter('code', $code)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }
}