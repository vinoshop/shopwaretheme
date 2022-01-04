import './component';
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
    name: 'product-with-winzer-three-column',
    category: 'commerce',
    label: 'Three products including the manufacturers name',
    component: 'sw-cms-block-product-with-winzer-three-column',
    previewComponent: 'sw-cms-preview-product-with-winzer-three-column',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed'
    },
    slots: {
        manufacturer: 'entity',
        left: 'product-box',
        center: 'product-box',
        right: 'product-box'
    }
});