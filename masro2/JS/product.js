const checkboxes = document.querySelectorAll(".form-checkbox");
const products = document.querySelectorAll(".product");
const checkedBoxes = {};
checkboxes.forEach(checkbox => {
    checkbox.addEventListener("change", function () {
        if (this.checked) {
            checkedBoxes[this.id + ""] = this.id;
        } else {
            delete checkedBoxes[this.id + ""];
        }
        products.forEach(product => {
            if (Object.keys(checkedBoxes).length === 0) {
                product.classList.remove("hide");
            } else if (product.dataset.category in checkedBoxes) {
                product.classList.remove("hide");
            } else {
                product.classList.add("hide");
            }
        });
    });
});
// Range Input

const parent = document.querySelector(".range-slider");

const rangeS = parent.querySelectorAll("input[type=range]"),
    minMaxSpan = parent.parentElement.querySelectorAll("span");

rangeS.forEach((el) => {
    el.addEventListener("input", () => {
        let slide1 = parseFloat(rangeS[0].value),
            slide2 = parseFloat(rangeS[1].value);

        if (slide1 > slide2) {
            [slide1, slide2] = [slide2, slide1];
        }

        minMaxSpan[0].textContent = slide1;
        minMaxSpan[1].textContent = slide2;
        products.forEach(product => {
            const price = Math.ceil(parseFloat(product.dataset.price));

            if (price >= slide1 && price <= slide2) {
                product.classList.remove("hide");
            } else {
                product.classList.add("hide");
            }
        });
    });
});


// End of Range Input