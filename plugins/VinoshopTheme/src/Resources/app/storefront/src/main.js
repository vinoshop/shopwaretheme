import ProductPagePlugin from "./scripts/pages/product-page-plugin.plugin";

const PluginManager = window.PluginManager;
PluginManager.register('ProductPagePlugin', ProductPagePlugin, '[data-product-page-plugin]');