<?php
declare(strict_types=1);

namespace VinoshopTheme\Storefront\Service;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Aggregation\Metric\CountAggregation;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\Metric\CountResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Storefront\Page\LandingPage\LandingPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Struct\ArrayEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;

class AddProductsToHomepage implements EventSubscriberInterface
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
        $productId = $event->getPage()->getProduct()->parentId;
        $manufacturerId = $event->getPage()->getProduct()->manufacturerId;
        $categoryId = $event->getPage()->getProduct()->getSEOCategory()->id;

        $isMainVariantAndNotCurrentProduct = new MultiFilter(
            MultiFilter::CONNECTION_AND,
            [
                new EqualsFilter('parentId', null),
                new NotFilter(
                    NotFilter::CONNECTION_AND,
                    [ new EqualsFilter('id', $productId) ]
                )
            ]
        );

        $manufacturerCriteria = new Criteria();
        $manufacturerCriteria->addFilter(new EqualsFilter('manufacturerId', $manufacturerId));
        $manufacturerCriteria->addFilter($isMainVariantAndNotCurrentProduct);
        $manufacturerCriteria->addAssociation('manufacturer');
        $productsFromSameManufacturer = $this->productRepository->search($manufacturerCriteria, $event->getSalesChannelContext());

        $event->getPage()->addExtension('products_from_same_manufacturer', $productsFromSameManufacturer);

        $categoryCriteria = new Criteria();
        $categoryCriteria->addFilter(new EqualsFilter('categoryIds', $categoryId));
        $categoryCriteria->addFilter($isMainVariantAndNotCurrentProduct);
        $categoryCriteria->addAssociation('manufacturer');
        $productsFromSameCategory = $this->productRepository->search($categoryCriteria, $event->getSalesChannelContext());

        $event->getPage()->addExtension('products_from_same_category', $productsFromSameCategory);
    }
}