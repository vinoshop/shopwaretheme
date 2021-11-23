import Plugin from 'src/plugin-system/plugin.class';

export default class ProductPagePlugin extends Plugin {
    init() {
        const tabHeaders = document.getElementsByClassName("product-detail-tabs-headers")[0].children;
        let active = null;

        for (let header of tabHeaders) {
            if (header.classList.contains("active"))
                active = header;
            header.addEventListener("click", () => {
                if (header.classList.contains("active"))
                    return;
                active.classList.remove("active");
                document.getElementById(active.getAttribute("data-content-id")).classList.remove("active");

                active = header;
                header.classList.add("active");
                document.getElementById(header.getAttribute("data-content-id")).classList.add("active");
            });

            const productImagesSmall = document.getElementsByClassName("product-detail-images-small")[0].children;
            let activeImage = null;
            for (let img of productImagesSmall) {
                if (img.classList.contains("active"))
                    activeImage = img;

                img.addEventListener("click", () => {
                    if (img.classList.contains("active"))
                        return;
                    activeImage.classList.remove("active");
                    activeImage = img;
                    img.classList.add("active");
                    document.getElementsByClassName("product-detail-image-big")[0].setAttribute("src", img.getAttribute("src"));
                })
            }

        }

    }
}