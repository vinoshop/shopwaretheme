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
use Shopware\Core\Framework\Struct\Struct;


/**
 * @RouteScope(scopes={"storefront"})
 */
class LegalPagesController extends StorefrontController
{
    private NavigationPageLoaderInterface $navigationPageLoader;

    public function __construct(
        NavigationPageLoaderInterface       $navigationPageLoader
    )
    {
        $this->navigationPageLoader = $navigationPageLoader;
    }

    /**
     * @Route("/legal/agb", name="frontend.legal.agb", options={"seo"="true"}, methods={"GET"})
     */
    public function agbPage(Request $request, SalesChannelContext $context): ?Response
    {
        $page = $this->navigationPageLoader->load($request, $context);
        $legalPageOptions = new LegalPageOptions("AGBs", $context->getSalesChannel()->getCustomFields()["vs_legal_agbs"]);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/legal/index.html.twig',
            [
                'page' => $page,
                'legalPageOptions' => $legalPageOptions
            ],
        );
    }

    /**
     * @Route("/legal/datenschutz", name="frontend.legal.datenschutz", options={"seo"="true"}, methods={"GET"})
     */
    public function datenschutzPage(Request $request, SalesChannelContext $context): ?Response
    {
        $page = $this->navigationPageLoader->load($request, $context);
        $legalPageOptions = new LegalPageOptions("Datenschutz", $context->getSalesChannel()->getCustomFields()["vs_legal_datenschutz"]);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/legal/index.html.twig',
            [
                'page' => $page,
                'legalPageOptions' => $legalPageOptions
            ],
        );
    }

    /**
     * @Route("/legal/impressum", name="frontend.legal.impressum", options={"seo"="true"}, methods={"GET"})
     */
    public function impressumPagePage(Request $request, SalesChannelContext $context): ?Response
    {
        $page = $this->navigationPageLoader->load($request, $context);
        $legalPageOptions = new LegalPageOptions("Impressum", $context->getSalesChannel()->getCustomFields()["vs_legal_impressum"]);

        return $this->renderStorefront('@VinoshopTheme/storefront/page/legal/index.html.twig',
            [
                'page' => $page,
                'legalPageOptions' => $legalPageOptions
            ],
        );
    }
}

class LegalPageOptions extends Struct {
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * LegalPageOptions constructor.
     * @param $title
     * @param $content
     */
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }




}