const sidebar = document.getElementById("sidebar");
let background = document.getElementById("black-background");
var opened = false;

const setActive = (active) => {
  if (active) {
    document.getElementById("sidebar-bg").classList.add("active");
    document.getElementById("sidebar").classList.add("active");
  } else {
    document.getElementById("sidebar-bg").classList.remove("active");
    document.getElementById("sidebar").classList.remove("active");
  }
};

function setBlackBackground(active) {
  if (!background) {
    return;
  }
  if (active) {
    background.classList.add("active");
  } else {
    background.classList.remove("active");
  }
}

// Todo : Gawin lahat to sa magiging sidebar.
function initializeSidebar(id) {
  let sidebar = document.getElementById(id);
  if (!sidebar) {
    console.log(id, " sidebbar doesn't exist");
    return;
  }

  let open = document.getElementById(sidebar.getAttribute("open"));
  let close = document.getElementById(sidebar.getAttribute("close"));

  open.addEventListener("click", function () {
    sidebar.classList.add("active");
    setBlackBackground(true);
  });

  function onClose() {
    sidebar.classList.remove("active");
    setBlackBackground(false);
  }

  close.addEventListener("click", onClose);
  if (background) {
    background.addEventListener("click", onClose);
  }
}

function carousel() {
  const container = document.getElementById("carousel-images");
  const items = document.querySelectorAll("#carousel-item");
  const buttonContainer = document.getElementById("carousel-buttons");

  console.log(container, items, buttonContainer);
  if (!container || !items || !buttonContainer) {
    return;
  }

  let currentIndex = 0;
  let direction = 1;

  items.forEach((item, index) => {
    const dot = document.createElement("span");
    dot.classList.add("carousel-dot");
    if (index === 0) dot.classList.add("active");
    dot.addEventListener("click", () => {
      container.scrollTo({
        left: item.offsetLeft,
        behavior: "smooth",
      });
      currentIndex = index;
      direction = 1;
    });
    buttonContainer.appendChild(dot);
  });

  container.addEventListener("scroll", () => {
    const scrollLeft = container.scrollLeft;
    const itemWidth = items[0].offsetWidth + 20;
    const activeIndex = Math.round(scrollLeft / itemWidth);

    document.querySelectorAll(".carousel-dot").forEach((dot, i) => {
      dot.classList.toggle("active", i === activeIndex);
    });

    currentIndex = activeIndex;
  });

  setInterval(() => {
    if (currentIndex === items.length - 1) {
      direction = -1;
    } else if (currentIndex === 0) {
      direction = 1;
    }

    currentIndex += direction;

    container.scrollTo({
      left: items[currentIndex].offsetLeft,
      behavior: "smooth",
    });

    document.querySelectorAll(".carousel-dot").forEach((dot, i) => {
      dot.classList.toggle("active", i === currentIndex);
    });
  }, 5000);
}

const sidebarOpen = document.getElementById("sidebar-open");
const sidebarClose = document.getElementById("sidebar-close");
const sidebarBg = document.getElementById("sidebar-bg");
if (sidebarOpen) {
  sidebarOpen.addEventListener("click", function () {
    setActive(true);
  });
}

if (sidebarBg) {
  sidebarBg.addEventListener("click", function () {
    setActive(false);
  });
}

if (sidebarClose) {
  sidebarClose.addEventListener("click", function () {
    setActive(false);
  });
}

const loader = document.getElementById("loader");

if (loader) {
  if (document.readyState !== "complete" || document.readyState !== "interactive") {
    loader.classList.add("active");
  }
  const loading = () => {
    setTimeout(() => {
      loader.classList.add("hide");
    }, 1000);
    setTimeout(() => {
      loader.classList.remove("active");
    }, 1200);
  };
  window.addEventListener("load", loading);
}

// FROM THE WEB
const debounce = (fn) => {
  // This holds the requestAnimationFrame reference, so we can cancel it if we wish
  let frame;

  // The debounce function returns a new function that can receive a variable number of arguments
  return (...params) => {
    // If the frame variable has been defined, clear it now, and queue for next frame
    if (frame) {
      cancelAnimationFrame(frame);
    }

    // Queue our function call for the next frame
    frame = requestAnimationFrame(() => {
      // Call our function and pass any params we received
      fn(...params);
    });
  };
};

// Reads out the scroll position and stores it in the data attribute
// so we can use it in our stylesheets
const storeScroll = () => {
  if (window.scrollY > 10) {
    document.getElementById("navigation").classList.add("active");
  } else {
    document.getElementById("navigation").classList.remove("active");
  }
};

document.addEventListener("scroll", debounce(storeScroll));

// Update scroll position for first time
storeScroll();
initializeSidebar("side-bar-filter");
carousel();
initializeSidebar("sidebar-cart");
