const productsBody = document.getElementById("products-body");
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const CATEGORY = "Tops";
const API = "/api/shop.php";

if (!urlParams.get("category")) {
    urlParams.append("category", CATEGORY);
}

function getItems() {

    let url = API + "?" + urlParams.toString();

    return fetch(url, {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    }).then(function (response) { return response.json(); });
}

function displayItems(value) {
    const images = JSON.parse(value["images"]);


    productsBody.insertAdjacentHTML(
        "beforeend",
        `<button class="card">
         <a href="/product.php?id=${value["id"]}">
              <img class="card-image" src="${images[0]}" alt="${value["name"]}" id="hoverable" data-url-target="${images[1]}">
              </a>
              <div class="card-description">
                <span class="deca">${value["name"]} </span>
                <h4 class="peta">₱${value["price"].toLocaleString()}</h4>
               
              </div>
            </button>`
    );
}

function loadItems() {
    productsBody.innerHTML = "";
    getItems().then((json) => {
        json.forEach(value => {
            displayItems(value);
        });
    })
}


function onChecked(id, param) {
    const elements = document.querySelectorAll("#" + id)
    elements.forEach(child => {
        child.addEventListener("changed", function (e) {
            if (!this.checked) {
                urlParams.delete(param)
            } else if (this.checked && !urlParams.get(param)) {
                urlParams.set(param, this.value)
            }
        })
    });
}


function deb(fn, delay = 100) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), delay);
    };
}

//wag muna mag hover
function hoverableItems() {
    let hoverables = document.querySelectorAll("#hoverable");

    hoverables.forEach(child => {
        let hoverImage = child.getAttribute("data-url-target");
        let originalImage = child.src;

        child.addEventListener("mouseenter", (event => {
            child.src = hoverImage
        }))


        child.addEventListener("mouseleave", (event => {
            child.src = originalImage
        }))

    })

}





loadItems()