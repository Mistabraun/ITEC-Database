const productImg1 = document.getElementById("product-image-1")
const productImg2 = document.getElementById("product-image-2")
const productTitle = document.getElementById("product-title")
const productPrice = document.getElementById("product-price")
const sizeSelection = document.getElementById("size-selection")
const addtocartForm = document.getElementById("add-to-cart")
const sidebarcart = document.getElementById("sidebar-cart")

const search = window.location.search
const url = new URLSearchParams(search)

const PRODUCT_URL = "api/product.php"
const CHECKOUT_URL = "api/order.php"

function getData() {
    return fetch(PRODUCT_URL + "?" + url.toString(), {
        method: "GET",
        headers: { "Content-Type": "application/json", }
    })
        .then((response) => response.json())
        .catch((error) => {
            console.error("Error:", error);
            throw error;
        });
}


function addDataToCart(response) {
    console.log(response)
}

function initialize(response) {
    const data = response.message
    productTitle.innerText = data.name
    productPrice.innerText = (data.price).toLocaleString(
        'en-US',
        {
            style: 'currency',
            currency: 'PHP',
            maximumFractionDigits: 0,
        })


    const images = JSON.parse(data.images)
    productImg2.src = images[0]
    productImg1.src = images[1]


    const sizes = JSON.parse(data.sizes)

    sizeSelection.innerHTML = "";
    sizes.forEach((element, index) => {
        const checked = index === 0 ? "checked" : "";

        sizeSelection.insertAdjacentHTML(
            "beforeend",
            `
        <input 
            type="radio" 
            id="${element}" 
            name="size" 
            value="${element}" 
            class="box"
            ${checked}
        >
        <label for="${element}" class="box">${element}</label>
        `
        );
    });

    let debounce = false

    addtocartForm.addEventListener("submit", (event => {
        event.preventDefault()
        if (debounce) {
            return
        }

        if (sidebarcart.classList.contains("active")) {
            return
        }

        debounce = true

        const form = event.target;
        const formData = new FormData(form);

        const id = url.get("id")
        formData.append("id", id)

        sidebarcart.classList.add("active");
        setBlackBackground(true);
        fetch(CHECKOUT_URL, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(Object.fromEntries(formData.entries()))
        })
            .then((response) => response.json())
            .then(addDataToCart)
            .finally(response => {
                formData.delete("id")
                setTimeout(() => {
                    debounce = false
                }, 500);

            })

    }))


}

getData().then((response) => {
    if (response.success) {
        initialize(response)
    } else {
        console.log(response.message)
        // window.location = "/shop.php"
    }
})
