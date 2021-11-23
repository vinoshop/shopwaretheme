import Plugin from 'src/plugin-system/plugin.class';

export default class HeaderPlugin extends Plugin {
    init() {
        this.el.addEventListener("click", () => document.body.classList.add("mobile-nav-open"));
        document.getElementsByClassName("btn-close-mobile-nav-overview")[0]
            .addEventListener("click", () => document.body.classList.remove("mobile-nav-open"));
    }
}