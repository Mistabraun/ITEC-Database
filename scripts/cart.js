const cartlist = document.querySelector("#sidebar-cart .sidebar-list")

const ORDERS_API = "api/order.php"

function get_orders() {
    return fetch(ORDERS_API, {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    }).then((response) => response.json())
}

function remove_order(id) {
    return fetch(ORDERS_API, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ "id": id })
    }).then((response) => response.json())
}

function add_order(id, quantity) {
    return fetch(ORDERS_API, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ "id": id, "quantity": quantity })
    }).then((response) => response.json())
}

function format_price(price) {
    return parseFloat(price).toLocaleString(
        'en-PH',
        {
            style: 'currency',
            currency: 'PHP',
            maximumFractionDigits: 0,
        }
    )
}

function update_cart() {
    cartlist.innerHTML = ""
    get_orders().then((response) => {
        response.forEach(product => {
            console.log(product)
            const li = document.createElement("li")
            li.className = "cart-item"

            li.innerHTML = `
        <div class="cart-header">
            <h6 class="exa">${product.name}</h6>
            <button class="close">
                <img src="assets/logo/exit.svg" alt="" />
            </button>
        </div>
        <div class="cart-body">
            <div class="cart-count">
                <button class="cart-button minus">-</button>
                <span class="cart-quantity exa">${product.quantity}</span>
                <button class="cart-button plus">+</button>
            </div>
            <span class="price exa">${format_price(product.price)}
                </span>
        </div>`

            const priceElement = li.querySelector(".price")
            const countElement = li.querySelector(".cart-quantity")

            function onUpdate(response) {
                priceElement.innerHTML = format_price(response.price)
                countElement.innerHTML = response.quantity
            }

            const closeBtn = li.querySelector(".close")
            closeBtn.addEventListener("click", () => {
                remove_order(product.id).then((response) => {
                    if (!response.success) {
                        return
                    }
                    li.remove()
                    console.log("REMOVE")
                })

            })

            const decreaseBtn = li.querySelector(".minus")
            decreaseBtn.addEventListener("click", () => {
                add_order(product.id, -1).then((response) => {
                    if (!response.success) {
                        return
                    }
                    if (response.message.quantity <= 0) {
                        li.remove()
                    }
                    onUpdate(response.message)
                    console.log("DECREASE")
                })
            })

            const increasteBtn = li.querySelector(".plus")
            increasteBtn.addEventListener("click", () => {
                add_order(product.id, 1).then((response) => {
                    onUpdate(response.message)
                    console.log("INCREASE")
                })

            })

            cartlist.append(li)
        });

    })
}

update_cart()