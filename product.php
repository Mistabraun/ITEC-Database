<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles/style.css" />
  <link rel="stylesheet" href="styles/shop.css" />
  <link rel="stylesheet" href="styles/product.css">
  <title>Document</title>
</head>

<body>
  <div class="loader" id="loader">
    <div class="wrapper">
      <!-- <div class="spinner"></div> -->
      <h1 class="zetta">LOADING</h1>
    </div>
  </div>

  <div class="black-background" id="black-background"></div>

  <header>
    <nav id="navigation" color="white">
      <div class="nav-menu nav-black">
        <button class="nav-button" id="sidebar-open">
          <img src="assets/logo/menu.svg" alt="" style="color: wheat" />
        </button>
      </div>

      <h1 class="nav-title nav-black zetta"><a href="/">ACMO</a></h1>

      <ul class="nav-links">
        <li class="nav-black">
          <a href="/login.php"><img src="assets/logo/user.svg" alt="User" /></a>
        </li>

        <li class="nav-black">
          <a href="/shop.php"><img src="assets/logo/shop.svg" alt="Shop" /></a>
        </li>
        <li>
          <button id="cart-view"><img src="assets/logo/cart-2.svg" alt="Cart" /></button>
        </li>

        <?php
        session_start();
        if (isset($_SESSION['email'])) {
          echo '<li><button id="signout"><img src="assets/logo/login-svgrepo-com.svg" alt="Sign out" /></button></li>';
        }
        ?>

      </ul>
    </nav>

    <div class="sidebar-bg" id="sidebar-bg"></div>

    <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <button id="sidebar-close"><img src="assets/logo/exit.svg" alt="" /></button>
        <div class="search-wrapper">
          <input class="search" type="text" placeholder="SEARCH" />
          <button>
            <img src="assets/logo/search.svg" alt="" />
          </button>
        </div>
      </div>

      <ul class="sidebar-list">
        <!-- <li><a href="">NEW ARRIVALS</a></li> -->
        <li><a href="shop.php?category=tops">TOPS</a></li>
        <li><a href="shop.php?category=jackets">JACKETS</a></li>
        <li><a href="shop.php?category=bottoms">BOTTOMS</a></li>
        <li><a href="shop.php?category=dresses">DRESSES</a></li>
        <li><a href="shop.php?category=accessories">ACCESSORIES</a></li>
        <li><a href="shop.php?category=footwear">FOOTWEAR</a></li>
        <li><a href="" class="last">VIEW ALL</a></li>
      </ul>
    </div>
    <div class="sidebar" id="sidebar-cart" open="cart-view" close="sidebar-cart-close" target="right">
      <div class="sidebar-header">
        <h2>CART</h2>
        <button id="sidebar-cart-close"><img src="assets/logo/exit.svg" alt="" /></button>
      </div>

      <ul class="sidebar-list">
        <li class="cart-item">
          <div class="cart-header">
            <h6 class="exa">Graphic Cropped Shirt</h6>
            <button class="close"><img src="assets/logo/exit.svg" alt="" /></button>
          </div>
          <div class="cart-body">
            <div class="cart-count">
              <button class="cart-button">-</button>
              <span class="cart-count exa">1</span>
              <button class="cart-button">+</button>
            </div>
            <span class="price exa" id="cart-price">₱549.00</span>
          </div>
        </li>
      </ul>
      <div class="sidebar-footer">
        <div class="header deca">
          <h4 class="exa">TOTAL</h4>
          <span>₱100.00</span>
        </div>
        <span class="description deca">Shipping and discount codes are calculated at checkout.</span>
        <button class="checkout deca" onclick="document.location='checkout.html'">Check out</button>
      </div>
    </div>
  </header>
  <main class="main-container">
    <a href="/shop.php" class="more deca"> Continue Shopping </a>
    <div class="container">
      <div class="image-container">
        <img id="product-image-1" src="assets/products/men/tops/beige winter coat (1).jpg">

      </div>
      <div class="image-container">
        <img id="product-image-2" src="assets/products/men/tops/Early 2024 (1).jpg">
      </div>
      <form class=" details" id="add-to-cart">
        <h1 id="product-title">Product Title</h1>
        <div id="product-price" class="price">Product Price</div>

        <p class="deca">Please choose the desired size from the available options, and indicate the quantity you'd like to purchase. Ensure you select the correct size and quantity before proceeding to checkout.</p>

        <div class="form-content">
          <h4 class="title">SIZE</h4>
          <div class="form-input" id="size-selection">
            <input type="radio" id="Extra Small" name="size" value="Extra Small" class="box" checked>
            <label for="Extra Small" class="box">Extra Small</label>
            <input type="radio" id="Small" name="size" value="Small" class=" box">
            <label for="Small" class="box">Small</label>
            <input type="radio" id="Meidum" name="size" value="Meidum" class=" box">
            <label for="Meidum" class="box">Medium</label>
            <input type="radio" id="Large" name="size" value="Large" class="box">
            <label for="Large" class="box">Large</label>

          </div>
        </div>
        <div class="form-content">
          <div class="title ">QUANTITY</div>
          <input type="number" id="quantity" name="quantity" value="1" min="1">
        </div>

        <div class="lower-button">
          <!-- <button class="buy" onclick="window.location.href='checkout.html'">Buy</button> -->

          <button class="add-cart">Add to cart</button>
        </div>
    </div>
    </form>

  </main>


  <footer class="footer" style="margin-top: 3rem">
    <ul class="footer-section">
      <h1>ACMO</h1>
      <li>Angeles, Janro S.</li>
      <li>Ansuas, Arliesienne A.</li>
      <li>Caudilla, Justine Carl C.</li>
      <li>Mico, Vladimir L.</li>
      <li>Odiongan, John Evan M.</li>
    </ul>

    <ul class="footer-section">
      <h1>Information</h1>
      <li><a href="http://bsit1-1-contacts.com" target="_blank">Contact Us</a></li>
      <li><a href="http://bsit1-1-aboutus.com" target="_blank">About Us</a></li>
      <li><a href="http://bsit1-1-faqs.com" target="_blank">FAQ's</a></li>
      <li><a href="http://bsit1-1-paymentoption.com" target="_blank">Payment Option</a></li>
    </ul>

    <ul class="footer-section">
      <li><a href="http://bsit1-1-return.com" target="_blank">Return &amp; Exchange</a></li>
      <li><a href="http://bsit1-1-shipping-delivery.com" target="_blank">Shipping &amp; Delivery</a></li>
      <li><a href="http://bsit1-1-size-guide.com" target="_blank">Size Guide</a></li>
      <li><a href="http://bsit1-1-bulk-orders.com" target="_blank">Bulk Orders</a></li>
    </ul>

    <ul class="footer-section">
      <li><a href="http://bsit1-1-privacy-policy.com" target="_blank">Privacy Policy</a></li>
      <li><a href="http://bsit1-1-terms-of-services.com" target="_blank">Terms of Services</a></li>
      <li><a href="http://bsit1-1-feedback.com" target="_blank">Feedback</a></li>
      <li><a href="http://bsit1-1-information.com" target="_blank">Information</a></li>
    </ul>
  </footer>
</body>
<script src="scripts/app.js"></script>
<script src="scripts/cart.js"></script>
<script src="scripts/shop.js"></script>
<script src="scripts/auth.js"></script>
<script src="scripts/product.js"></script>

</html>