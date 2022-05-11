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
     * @var EntityRepository
     */
    private $manufacturerRepository; //manufacturer Repository, mit dem auf die Datenbank Tabelle vom Winzer zugegriffen wird

    public function __construct(EntityRepository $manufacturerRepository)
    {
        $this->manufacturerRepository = $manufacturerRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductEvents::PRODUCT_LOADED_EVENT => 'onProductsLoaded'  //das verwendete Event, wenn ein Produkt geladen wird
        ];
    }

    //sobald das Produkt geladen wurde, wird diese methode ausgeführt
    public function onProductsLoaded(EntityLoadedEvent $event) {
        foreach($event->getEntities() as $entity) {
            if ($entity->getManufacturerId() == null)
                continue;
            //search criteria
            $criteria = new Criteria([$entity->getManufacturerId()]);

            //manufacturer wird gesucht
            /** @var ProductManufacturerEntity $currentManufacturer */
            $currentManufacturer = $this->manufacturerRepository
                ->search($criteria, $event->getContext())
                ->get($entity->getManufacturerId());

            //wenn der manufacturer nicht null ist wird dem produkt der manufacturer hinzugefügt
            if ($currentManufacturer != null)
                $entity->setManufacturer($currentManufacturer);
        }
    }
}
