// @ts-check

/**
 * @type {HTMLElement | null}
 */
const display = document.querySelector(".default-form");

if (display) {
    for (let i = 1; i <= 50; i++) {
        /**
         * @type {HTMLInputElement}
         */
        const input = document.createElement("input");
        input.type = "text";
        input.name = `a${i}`;
        input.value = `${i}`;

        /**
         * @type {HTMLBRElement}
         */
        const br = document.createElement("br");

        display.appendChild(input);
        display.appendChild(br);
    }
}