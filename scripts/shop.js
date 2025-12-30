const productsBody = document.getElementById("products-body");
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const searchElement = document.getElementById("search");

const GENDERS = ["Men", "Women"];
const CATEGORY = "tops";
const JSONPATH = "/json/products.json";

function capitalizeFirstLetter(word) {
  if (!word) return "";
  return word.charAt(0).toUpperCase() + word.slice(1);
}

function loadProducts() {
  fetch(JSONPATH)
    .then((response) => {
      if (!response.ok) {
        console.log("dsa");
        throw new Error("Failed to load product data");
      }
      return response.json();
    })
    .then((data) => {
      handleURLParams(data);
    });
}

function getGenders(param) {
  if (!param) {
    return GENDERS;
  }
  return param
    .toLowerCase()
    .split(",")
    .map((g) => g.trim())
    .filter((g) => g === "men" || g === "women")
    .map((g) => (g === "men" ? "men" : "women"));
}

function removeByValue(arr, value) {
  return arr.filter((item) => item !== value);
}

function handleURLParams(productsJSON) {
  console.log(productsJSON);
  let category = urlParams.get("category") || CATEGORY;
  let filters = {
    gender: ["men", "women"],
    stock: ["stock", "out-of-stock"],
    price: [0, 10000000],
    sizes: [],
  };

  let filtered = [];

  function display() {
    productsBody.innerHTML = "";
    filtered.forEach(function (value) {
      productsBody.insertAdjacentHTML(
        "beforeend",
        `<button class="card">
              <img class="card-image" src="${value["images"][0]}" alt="${value["name"]}">
              <div class="card-description">
                <span class="deca">${value["name"]} </span>
                <h4 class="peta">₱${value["price"].toLocaleString()}</h4>
              </div>
            </button>`
      );
      console.log(value);
    });
  }

  function filterStocks(categoryItems) {
    let filtered = [];
    // console.log(filters.stock.length)
    if (filters.stock.length == 2) {
      categoryItems.forEach((value) => {
        filtered.push(value);
      });
    } else {
      let hasStock = filters.stock[0] == "stock";
      categoryItems.forEach((value) => {
        if (hasStock) {
          if (value["stock"] > 0) {
            filtered.push(value);
          }
        } else {
          if (value["stock"] <= 0) {
            filtered.push(value);
          }
        }
        // if ((hasStock && value["stock"] > 0) || value["stock"] <= 0) {
        //   filtered.push(value);
        // }
      });
    }
    return filtered;
  }

  function filterPrice(categoryItems) {
    let filtered = [];

    categoryItems.forEach((value) => {
      let price = value["price"];
      if (price >= filters.price[0] && price <= filters.price[1]) {
        filtered.push(value);
      }
    });
    return filtered;
  }

  function isSubset(a, b) {
    return b.every((val) => a.includes(val));
  }

  function filterSizes(categoryItems) {
    if (filters.sizes.length == 0) {
      return categoryItems;
    }

    let filtered = [];
    categoryItems.forEach((value) => {
      if (isSubset(value["sizes"], filters.sizes)) {
        filtered.push(value);
      }
    });
    return filtered;
  }

  function filterItems() {
    filtered = [];
    filters.gender.forEach((genderJson) => {
      const genderItems = productsJSON[genderJson];
      const categoryItems = genderItems[category];
      console.log(categoryItems);
      if (categoryItems) {
        filterSizes(filterPrice(filterStocks(categoryItems))).forEach(function (value) {
          filtered.push(value);
        });
      }
    });
    // console.log(filtered);
    display();
  }

  function onChecked(query, defaultValue) {
    let checked = [];
    document.querySelectorAll("#" + query).forEach(function (element) {
      element.addEventListener("change", function () {
        if (this.checked) {
          checked.push(this.value);
        } else {
          checked = removeByValue(checked, this.value);
        }
        filters[query] = (checked.length === 0 && defaultValue) || checked;
        filterItems();
      });
    });
  }

  function onPriceChanged(id, index, defaultVal) {
    let input = document.getElementById(id);
    input.addEventListener("input", function () {
      filters.price[index] = this.value || defaultVal;
      filterItems();
    });
  }

  onChecked("gender", filters.gender);
  onChecked("stock", filters.stock);
  onChecked("sizes", filters.sizes);
  onPriceChanged("min", 0, 0);
  onPriceChanged("max", 1, 10000000);

  filterItems();
}

loadProducts();
