document.addEventListener("DOMContentLoaded", () => {
    const orders = document.querySelectorAll(".order");
    const summaryContainer = document.querySelector(".summary");

    function parsePrice(text) {
        return Number(text.replace(/[^\d.]/g, ""));
    }

    function updateSummary() {
        summaryContainer.innerHTML = "";

        orders.forEach(order => {
            const name = order.querySelector("h3").textContent;
            const priceText = order.querySelector(".price").textContent;
            const qty = Number(order.querySelector(".r-display span").textContent);

            if (qty === 0) return;

            const price = parsePrice(priceText);
            const total = price * qty;

            const row = document.createElement("div");
            row.className = "s";
            row.innerHTML = `
        <div>${name} × ${qty}</div>
        <div>₱${total.toFixed(2)}</div>
      `;

            summaryContainer.appendChild(row);
        });
    }

    orders.forEach(order => {
        const minusBtn = order.querySelector("button:first-child");
        const plusBtn = order.querySelector("button:last-child");
        const qtySpan = order.querySelector(".r-display span");

        minusBtn.addEventListener("click", () => {
            let qty = Number(qtySpan.textContent);
            if (qty > 0) {
                qtySpan.textContent = qty - 1;
                updateSummary();
            }
        });

        plusBtn.addEventListener("click", () => {
            let qty = Number(qtySpan.textContent);
            qtySpan.textContent = qty + 1;
            updateSummary();
        });
    });

    updateSummary();
});

document.addEventListener("DOMContentLoaded", () => {
    const cart = document.querySelector(".cart-count");
    if (!cart) return;

    const minusBtn = cart.querySelector(".cart-button:first-child");
    const plusBtn = cart.querySelector(".cart-button:last-child");
    const countSpan = cart.querySelector(".cart-count.exa");

    plusBtn.addEventListener("click", () => {
        countSpan.textContent = Number(countSpan.textContent) + 1;
    });

    minusBtn.addEventListener("click", () => {
        const current = Number(countSpan.textContent);
        if (current > 1) {
            countSpan.textContent = current - 1;
        }
    });
});