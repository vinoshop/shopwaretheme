<?php
declare(strict_types=1);

namespace VinoshopTheme\Storefront\Service;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\CountResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Content\Product\ProductEvents;
use Shopware\Storefront\Page\LandingPage\LandingPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntitySearchedEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;

class AddManufacturerToHomePageProducts implements EventSubscriberInterface
{
    /**
     * @var SalesChannelRepositoryInterface
     */
    private $productRepository;
    /**
     * @var EntityRepository
     */
    private $manufacturerRepository;

    public function __construct(SalesChannelRepositoryInterface $productRepository, EntityRepository $manufacturerRepository)
    {
        $this->productRepository = $productRepository;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_LOADED_EVENT => 'onProductsLoaded'
        ];
    }

    public function onProductsLoaded(EntityLoadedEvent $event)
    {
        //$event->getCriteria()->addAssociation('manufacturer');
        // var_dump($event->getIds()); 
        // var_dump($event->getEntities());
        foreach($event->getEntities() as $entity) {
            if ($entity->getManufacturerId() == null)
                continue;

            $criteria = new Criteria([$entity->getManufacturerId()]);

            /** @var ProductManufacturerEntity $currentManufacturer */
            $currentManufacturer = $this->manufacturerRepository
                ->search($criteria, $event->getContext())
                ->get($entity->getManufacturerId());

            if ($currentManufacturer != null)
            {
                $entity->setManufacturer($currentManufacturer);
            }

            //var_dump($entity->manufacturer);

        }

        // var_dump($event->getEvents());
        // die();
    }

}
