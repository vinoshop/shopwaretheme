import Plugin from 'src/plugin-system/plugin.class';

export default class HeaderPlugin extends Plugin {
    init() {
        let header = document.getElementsByClassName("header-main")[0];

        this.el.addEventListener("click", () => document.body.classList.add("mobile-nav-open"));
        document.getElementsByClassName("btn-close-mobile-nav-overview")[0]
            .addEventListener("click", () => document.body.classList.remove("mobile-nav-open"));

        [...header.getElementsByClassName("search-menu")].forEach(x => x.addEventListener("click", () => {
            if (header.classList.contains("search-visible"))
                header.classList.remove("search-visible");
            else
                header.classList.add("search-visible");
        }));

        [...header.getElementsByClassName("header-search-form")].forEach(x => x.addEventListener("click", event => {
            event.stopPropagation();
        }));
    }
}