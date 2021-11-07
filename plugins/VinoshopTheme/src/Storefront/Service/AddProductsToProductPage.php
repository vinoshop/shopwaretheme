<?php
declare(strict_types=1);

namespace VinoshopTheme\Storefront\Service;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\CountResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class AddProductsToProductPage implements EventSubscriberInterface
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
            ProductPageLoadedEvent::class => 'addProductLists'
        ];
    }

    public function addProductLists(ProductPageLoadedEvent $event): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('product.active', true));

        $manufacturerId = $event->getPage()->getProduct()->manufacturerId;
        $categoryId = $event->getPage()->getProduct()->getSEOCategory()->id;

        $manufacturerCriteria = new Criteria();
        $manufacturerCriteria->addFilter(new EqualsFilter('manufacturerId', $manufacturerId));
        $productsFromSameManufacturer = $this->productRepository->search($manufacturerCriteria, $event->getSalesChannelContext());
        $this->mapManufacturersToProducts($productsFromSameManufacturer, $event->getSalesChannelContext());

        $event->getPage()->addExtension('products_from_same_manufacturer', $productsFromSameManufacturer);

        $categoryCriteria = new Criteria();
        $categoryCriteria->addFilter(new EqualsFilter('categoryIds', $categoryId));
        $productsFromSameCategory = $this->productRepository->search($categoryCriteria, $event->getSalesChannelContext());
        $this->mapManufacturersToProducts($productsFromSameCategory, $event->getSalesChannelContext());


        $event->getPage()->addExtension('products_from_same_category', $productsFromSameCategory);
    }

    private function mapManufacturersToProducts($products, $context) {
        foreach ($products as $product) {

        }
    }
}