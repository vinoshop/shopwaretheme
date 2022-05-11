<?php declare(strict_types=1);

namespace VinoshopTheme\Storefront\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Storefront\Page\Navigation\NavigationPageLoaderInterface;
use Shopware\Storefront\Pagelet\Menu\Offcanvas\MenuOffcanvasPageletLoaderInterface;
use Shopware\Core\Framework\Routing\Annotation\Since;
use Shopware\Storefront\Framework\Cache\Annotation\HttpCache;

use VinoshopTheme\Storefront\Service\GetWinzerData;

/**
 * @RouteScope(scopes={"storefront"})
 */
class WinzerpageController extends StorefrontController
{
    private NavigationPageLoaderInterface $navigationPageLoader;
    private MenuOffcanvasPageletLoaderInterface $offcanvasLoader;
    private EntityRepository $manufacturerRepository;
    private string $slug;


    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader,
        MenuOffcanvasPageletLoaderInterface $offcanvasLoader,
        EntityRepository                    $manufacturerRepository
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
        $this->offcanvasLoader = $offcanvasLoader;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    /**
     * @Route("/winzer/{slug}", name="frontend.winzer.winzer", options={"seo"="true"}, methods={"GET"})
     */
    public function renderOneWinzer(Request             $request,
                                    Context             $context,
                                    SalesChannelContext $salesChannelContext,
                                    string              $slug
    ): ?Response
    {


        $this->slug = $slug;
        $page = $this->navigationPageLoader->load($request, $salesChannelContext);

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('customFields.vs_winzer_slug', $slug));
        $criteria->addAssociation('products');
        $criteria->addAssociation('media');
        $criteria->addAssociation('products.cover');

        /** @var ProductManufacturerEntity $currentManufacturer */
        $currentManufacturer = $this->manufacturerRepository
            ->search($criteria, $context);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/winzerpage.html.twig',
            ['page' => $page, 'manufacturer' => $currentManufacturer],
        );
    }

    /**
     * @Route("/winzer", name="frontend.winzer",
     *     options={"seo"="true"}, methods={"GET"})
     */
    public function renderAllWinzer(Request             $request,
                                    SalesChannelContext $salesChannelContext, Context $context): ?Response
    {
        $page = $this->navigationPageLoader
            ->load($request, $salesChannelContext);

        $criteria = new Criteria();
        $criteria->addAssociation('media');
        $criteria->addAssociation('customFields');

        /** @var ProductManufacturerEntity $currentManufacturer */
        $currentManufacturer = $this->manufacturerRepository->search($criteria, $context);

        return $this->renderStorefront('@Vinoshopheme/storefront/page/winzer/allWinzer.html.twig',
            ['page' => $page, 'manufacturers' => $currentManufacturer],
        );
    }


}