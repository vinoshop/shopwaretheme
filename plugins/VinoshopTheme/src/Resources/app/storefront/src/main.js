import ProductPagePlugin from "./scripts/pages/product-page-plugin.plugin";
import NumberInputPlugin from "./scripts/number-input-plugin.plugin";
import HeaderPlugin from "./scripts/header-plugin.plugin";

const PluginManager = window.PluginManager;
PluginManager.register('ProductPagePlugin', ProductPagePlugin, '[data-product-page-plugin]');
PluginManager.register('NumberInputPlugin', NumberInputPlugin, '[data-number-input-plugin]');
PluginManager.register('NumberInputPlugin', HeaderPlugin, '[data-header-plugin]');

function getElementByXPath(xpath_identifier, elem) {
    return document.evaluate(
        xpath_identifier, elem, null,
        XPathResult.FIRST_ORDERED_NODE_TYPE, null
    ).singleNodeValue
}