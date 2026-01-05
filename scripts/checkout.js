const displayContainer = document.querySelector(".o-display")
const summaryContainer = document.querySelector(".summary-items");
const checkoutForm = document.getElementById("checkoutform")

const items = {}

const CHECKOUT_URL = "api/checkout.php"

function onCheckout(form) {
    const formData = new FormData(form)
    const data = Object.fromEntries(formData.entries());
    data["orders"] = Object.keys(items)

    const body = JSON.stringify(data)

    fetch(CHECKOUT_URL, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: body
    })
        .then(response => response.json())
        .then((response => {
            if (!response.success) {
                return
            }

            const success = document.querySelector(".c-checkout .success")
            success.style.display = "flex"

            setTimeout(() => {
                window.location = "/shop.php"
            }, 3000);

        }))

}

function display_orders() {
    displayContainer.innerHTML = ""

    function calculate_total() {
        let total = 0;

        Object.values(items).forEach((price) => {
            total += price;
        })
        return total
    }

    return get_orders()
        .then((response) => {
            response.forEach(product => {
                items[product.id] = parseFloat(product.price)

                const div = document.createElement("div")
                div.className = "order"
                div.innerHTML = `
                <div class="l-display">
                        <h3 id="name">${product.name}</h3>
                        <p class="price">${format_price(product.price)}</p>
                        <p class="quantity">x${product.quantity}</p>
                    </div>
                    <div class="r-display">
                        <button type="button">-</button>
                        <span>${product.quantity}</span>
                        <button type="button">+</button>
                    </div>
                    `

                const minusBtn = div.querySelector("button:first-child");
                const plusBtn = div.querySelector("button:last-child");
                const qtySpan = div.querySelector(".r-display span");

                const summary = document.createElement("div");
                summary.className = "s";
                summary.innerHTML = `
                        <div>${product.name} × ${product.quantity}</div>
                        <div>${format_price(product.price)}</div>
                    `;

                summaryContainer.append(summary)


                function updateTotal() {
                    const totalElement = document.querySelector(".summary-total .total")
                    const prices = document.querySelectorAll(".l-display .price")

                    console.log(items)
                    totalElement.innerHTML = format_price(calculate_total())

                }

                function updateSummary(response) {
                    if (response.quantity <= 0) {
                        summary.remove()
                    }
                    summary.innerHTML = `
                        <div>${product.name} × ${response.quantity}</div>
                        <div>${format_price(response.price)}</div>
                    `;

                }

                function onUpdate(product) {
                    const price = div.querySelector(".price")
                    const quantity = div.querySelector(".quantity")

                    console.log(items)

                    if (product.price) {
                        items[product.id] = parseFloat(product.price) // update yung price before para updated yung total
                    }


                    price.innerHTML = format_price(product.price)
                    quantity.innerHTML = "x" + product.quantity
                    qtySpan.innerHTML = product.quantity

                    updateTotal()
                    updateSummary(product)
                }

                minusBtn.addEventListener("click", () => {
                    add_order(product.id, -1).then((response) => {
                        if (!response.success) {
                            return
                        }
                        if (response.message.quantity <= 0) {
                            div.remove()
                            delete items[product.id]
                        }

                        onUpdate(response.message)


                    })
                })

                plusBtn.addEventListener("click", () => {
                    add_order(product.id, 1).then((response) => {
                        if (!response.success) {
                            return
                        }

                        if (response.message.quantity <= 0) {
                            summary.remove()
                            delete items[product.id]
                        }

                        onUpdate(response.message)

                    })
                })

                displayContainer.append(div)
                updateTotal()
            })
        })

}

display_orders().then(() => {
    checkoutForm.addEventListener("submit", (e) => {
        e.preventDefault()
        onCheckout(e.target)
    })
})
