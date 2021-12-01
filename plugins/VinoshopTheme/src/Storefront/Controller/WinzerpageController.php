<?php declare(strict_types=1);

namespace VinoshopTheme\Storefront\Controller;

use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"storefront"})
 */
class WinzerpageController extends StorefrontController
{
    /**
     * @Route("/winzer", name="frontend.winzer", methods={"GET"})
     */
    public function renderWinzerpage(): Response
    {
        return $this->renderStorefront('@VinoshopTheme/storefront/page/winzer/winzerpage.html.twig', [
            'example' => 'Hello world'
        ]);
    }
}