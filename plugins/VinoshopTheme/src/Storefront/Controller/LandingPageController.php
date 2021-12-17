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
class LandingPageController extends StorefrontController
{
    private NavigationPageLoaderInterface $navigationPageLoader;
    private MenuOffcanvasPageletLoaderInterface $offcanvasLoader;

    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader,
        MenuOffcanvasPageletLoaderInterface $offcanvasLoader
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
        $this->offcanvasLoader = $offcanvasLoader;
    }


    /**
     * @Route("/test", name="frontend.landing.page", options={"seo"="true"}, methods={"GET"})
     */
    public function renderHomepage(Request $request, SalesChannelContext $context): ?Response
    {
        $page = $this->navigationPageLoader->load($request, $context);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/content/landingpage.html.twig',
            ['page' => $page],
        );
    }
}