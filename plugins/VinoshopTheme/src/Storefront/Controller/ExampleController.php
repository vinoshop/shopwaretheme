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
class ExampleController extends StorefrontController
{
    /**
     * @Route("/a", name="frontend.example.example", methods={"GET"})
     */
    public function showExample(): Response
    {
        return $this->renderStorefront('@VinoshopTheme/storefront/page/landing-page/landingpage.html.twig', [
            'example' => 'Hello world'
        ]);
    }
}