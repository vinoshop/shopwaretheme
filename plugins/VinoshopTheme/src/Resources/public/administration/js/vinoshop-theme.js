!function(e){var r={};function t(n){if(r[n])return r[n].exports;var o=r[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,t),o.l=!0,o.exports}t.m=e,t.c=r,t.d=function(e,r,n){t.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:n})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,r){if(1&r&&(e=t(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(t.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var o in e)t.d(n,o,function(r){return e[r]}.bind(null,o));return n},t.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(r,"a",r),r},t.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},t.p="/bundles/administration/",t(t.s="ZcZH")}({"E/dr":function(e,r,t){var n=t("rekb");"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);(0,t("SZ7m").default)("ef747602",n,!0,{})},RLbQ:function(e,r){e.exports='{% block sw_cms_block_product_with_winzer_three_column_preview %}\r\n    <div class="sw-cms-preview-product-with-winzer-three-column">\r\n        <sw-cms-product-box-preview></sw-cms-product-box-preview>\r\n        <sw-cms-product-box-preview></sw-cms-product-box-preview>\r\n        <sw-cms-product-box-preview></sw-cms-product-box-preview>\r\n    </div>\r\n{% endblock %}'},SZ7m:function(e,r,t){"use strict";function n(e,r){for(var t=[],n={},o=0;o<r.length;o++){var i=r[o],s=i[0],c={id:e+":"+o,css:i[1],media:i[2],sourceMap:i[3]};n[s]?n[s].parts.push(c):t.push(n[s]={id:s,parts:[c]})}return t}t.r(r),t.d(r,"default",(function(){return m}));var o="undefined"!=typeof document;if("undefined"!=typeof DEBUG&&DEBUG&&!o)throw new Error("vue-style-loader cannot be used in a non-browser environment. Use { target: 'node' } in your Webpack config to indicate a server-rendering environment.");var i={},s=o&&(document.head||document.getElementsByTagName("head")[0]),c=null,a=0,u=!1,l=function(){},d=null,p="data-vue-ssr-id",f="undefined"!=typeof navigator&&/msie [6-9]\b/.test(navigator.userAgent.toLowerCase());function m(e,r,t,o){u=t,d=o||{};var s=n(e,r);return h(s),function(r){for(var t=[],o=0;o<s.length;o++){var c=s[o];(a=i[c.id]).refs--,t.push(a)}r?h(s=n(e,r)):s=[];for(o=0;o<t.length;o++){var a;if(0===(a=t[o]).refs){for(var u=0;u<a.parts.length;u++)a.parts[u]();delete i[a.id]}}}}function h(e){for(var r=0;r<e.length;r++){var t=e[r],n=i[t.id];if(n){n.refs++;for(var o=0;o<n.parts.length;o++)n.parts[o](t.parts[o]);for(;o<t.parts.length;o++)n.parts.push(b(t.parts[o]));n.parts.length>t.parts.length&&(n.parts.length=t.parts.length)}else{var s=[];for(o=0;o<t.parts.length;o++)s.push(b(t.parts[o]));i[t.id]={id:t.id,refs:1,parts:s}}}}function v(){var e=document.createElement("style");return e.type="text/css",s.appendChild(e),e}function b(e){var r,t,n=document.querySelector("style["+p+'~="'+e.id+'"]');if(n){if(u)return l;n.parentNode.removeChild(n)}if(f){var o=a++;n=c||(c=v()),r=y.bind(null,n,o,!1),t=y.bind(null,n,o,!0)}else n=v(),r=x.bind(null,n),t=function(){n.parentNode.removeChild(n)};return r(e),function(n){if(n){if(n.css===e.css&&n.media===e.media&&n.sourceMap===e.sourceMap)return;r(e=n)}else t()}}var w,g=(w=[],function(e,r){return w[e]=r,w.filter(Boolean).join("\n")});function y(e,r,t,n){var o=t?"":n.css;if(e.styleSheet)e.styleSheet.cssText=g(r,o);else{var i=document.createTextNode(o),s=e.childNodes;s[r]&&e.removeChild(s[r]),s.length?e.insertBefore(i,s[r]):e.appendChild(i)}}function x(e,r){var t=r.css,n=r.media,o=r.sourceMap;if(n&&e.setAttribute("media",n),d.ssrId&&e.setAttribute(p,r.id),o&&(t+="\n/*# sourceURL="+o.sources[0]+" */",t+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(o))))+" */"),e.styleSheet)e.styleSheet.cssText=t;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(t))}}},ZcZH:function(e,r,t){"use strict";t.r(r);var n=t("rLD+"),o=t.n(n);t("E/dr");Shopware.Component.register("sw-cms-block-product-with-winzer-three-column",{template:o.a});var i=t("RLbQ"),s=t.n(i);t("lBef");Shopware.Component.register("sw-cms-preview-product-three-column",{template:s.a}),Shopware.Service("cmsService").registerCmsBlock({name:"product-with-winzer-three-column",category:"commerce",label:"Three products including the manufacturers name",component:"sw-cms-block-product-with-winzer-three-column",previewComponent:"sw-cms-preview-product-with-winzer-three-column",defaultConfig:{marginBottom:"20px",marginTop:"20px",marginLeft:"20px",marginRight:"20px",sizingMode:"boxed"},slots:{manufacturer:"entity",left:"product-box",center:"product-box",right:"product-box"}})},hi3e:function(e,r,t){},lBef:function(e,r,t){var n=t("hi3e");"string"==typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);(0,t("SZ7m").default)("ac1d8bec",n,!0,{})},"rLD+":function(e,r){e.exports='{% block sw_cms_block_product_with_winzer_three_column %}\r\n    <div class="sw-cms-block-product-with-winzer-three-column">\r\n        <slot name="manufacturer"></slot>\r\n        <slot name="left"></slot>\r\n        <slot name="center"></slot>\r\n        <slot name="right"></slot>\r\n    </div>\r\n{% endblock %}'},rekb:function(e,r,t){}});