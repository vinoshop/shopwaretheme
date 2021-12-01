import Plugin from 'src/plugin-system/plugin.class';

export default class HeaderPlugin extends Plugin {
    init() {
        let header = document.getElementsByClassName("header-main")[0];

        this.el.addEventListener("click", () => document.body.classList.add("mobile-nav-open"));
        document.getElementsByClassName("btn-close-mobile-nav-overview")[0]
            .addEventListener("click", () => document.body.classList.remove("mobile-nav-open"));

        let searchOverlay = document.getElementsByClassName("search-overlay")[0];
        [...header.getElementsByClassName("search-menu")].forEach(x => x.addEventListener("click", () => {
            searchOverlay.classList.add("search-visible");
        }));
        searchOverlay.addEventListener("click", event => {
            searchOverlay.classList.remove("search-visible")
        })
        document.getElementsByClassName("header-search-form")[0].addEventListener("click", event => {
            event.stopPropagation();
        })
    }
}