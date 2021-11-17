import ProductPagePlugin from "./scripts/pages/product-page-plugin.plugin";
import NumberInputPlugin from "./scripts/number-input-plugin.plugin";

const PluginManager = window.PluginManager;
PluginManager.register('ProductPagePlugin', ProductPagePlugin, '[data-product-page-plugin]');
PluginManager.register('NumberInputPlugin', NumberInputPlugin, '[data-number-input-plugin]');
