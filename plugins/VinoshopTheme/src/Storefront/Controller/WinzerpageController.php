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
    private string $manufacturerId;
    private string $manufacturerName;
   

    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader,
        MenuOffcanvasPageletLoaderInterface $offcanvasLoader,
        EntityRepository $manufacturerRepository
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
        $this->offcanvasLoader = $offcanvasLoader;
        $this->manufacturerRepository = $manufacturerRepository;
    }

    /**
     * @Route("/winzer/{manufacturerName}/{manufacturerId}", name="frontend.winzer.winzer", options={"seo"="true"}, methods={"GET"})
     */
    public function renderOneWinzer(Request             $request,
                                    Context $context,
                                    SalesChannelContext $salesChannelContext,
                                    string              $manufacturerId
    ): ?Response
    {
        $this->manufacturerId = $manufacturerId;
        $page = $this->navigationPageLoader->load($request, $salesChannelContext);
        
        /** @var ProductManufacturerEntity $currentManufacturer */
        
        $criteria = new Criteria([$manufacturerId]);
        $criteria->addAssociation('products');
        $criteria->addAssociation('media');
        $criteria->addAssociation('products.cover');
        $criteria->addAssociation('products.prices');

        $winzer = $this->manufacturerRepository
            ->search($criteria, $context)
            ->get($manufacturerId);
        
        
        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/winzerpage.html.twig',
            ['page' => $page, 'manufacturerId' => $manufacturerId, 'manufacturer' => $winzer],
        );
    }

    /**
     * @Route("/winzer", name="frontend.winzer", options={"seo"="true"}, methods={"GET"})
     */
    public function renderAllWinzer(Request $request, SalesChannelContext $context): ?Response
    {
        $page = $this->navigationPageLoader->load($request, $context);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/allWinzer.html.twig',
            ['page' => $page, 'manufacturerId' => null],
        );
    }


}