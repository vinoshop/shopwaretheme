<?php
declare(strict_types=1);

namespace VinoshopTheme\Storefront\Service;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;


class GetWinzerData extends EntityRepository
{
    private EntityRepositoryInterface $winzerRepository;

    public function __construct(EntityRepositoryInterface $winzerRepository)
    {
        $this->winzerRepository = $winzerRepository;
    }

    public function getData(SalesChannelContext $context, string $manufacturerId)
    {

        return $this->winzerRepository->search(new Criteria([$manufacturerId]), $context)->first();

    }
}