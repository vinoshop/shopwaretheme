<?php declare(strict_types=1);

namespace VinoshopTheme\Storefront\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Storefront\Page\Navigation\NavigationPageLoaderInterface;
use Shopware\Storefront\Pagelet\Menu\Offcanvas\MenuOffcanvasPageletLoaderInterface;
use Shopware\Core\Framework\Routing\Annotation\Since;
use Shopware\Storefront\Framework\Cache\Annotation\HttpCache;

/**
 * @RouteScope(scopes={"storefront"})
 */
class WinzerpageController extends StorefrontController
{
    private NavigationPageLoaderInterface $navigationPageLoader;
    private MenuOffcanvasPageletLoaderInterface $offcanvasLoader;
    private string $manufacturerId;

    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader,
        MenuOffcanvasPageletLoaderInterface $offcanvasLoader
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
        $this->offcanvasLoader = $offcanvasLoader;
    }

    /**
     * @Route("/winzer/{manufacturerId}", name="frontend.winzer", options={"seo"="true"}, methods={"GET"})
     */
    public function renderWinzer(Request $request, SalesChannelContext $context, string $manufacturerId): ?Response
    {
        $this->manufacturerId = $manufacturerId;
        $page = $this->navigationPageLoader->load($request, $context);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/winzerpage.html.twig',
            ['page' => $page, 'manufacturerId' => $manufacturerId],
        );
    }
}