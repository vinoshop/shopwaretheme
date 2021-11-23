import Plugin from 'src/plugin-system/plugin.class';

export default class NumberInputPlugin extends Plugin {
    init() {
        const el = this.el;
        const input = el.getElementsByClassName("elem-input")[0];
        input.addEventListener("input", () => {
            console.log(input.value.replaceAll(/[^\d]/g, ''), input.value)
            if (input.value.replaceAll(/[^\d]/g, '') !== input.value)
                input.value = input.value.replaceAll(/[^\d]/g, '');
        })
        el.getElementsByClassName("elem-input-number-increase")[0]
            .addEventListener("click", () => input.value = Math.min(Number(input.value) + 1, input.getAttribute("max")));
        el.getElementsByClassName("elem-input-number-decrease")[0]
            .addEventListener("click", () => input.value = Math.max(Number(input.value) - 1, input.getAttribute("min")));
    }
}