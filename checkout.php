<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <button id="cart-view" disabled><img src="assets/logo/cart-2.svg" alt="Cart" /></button>
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
                <li><a href="shop.html?category=tops">TOPS</a></li>
                <li><a href="shop.html?category=jackets">JACKETS</a></li>
                <li><a href="shop.html?category=bottoms">BOTTOMS</a></li>
                <li><a href="shop.html?category=dresses">DRESSES</a></li>
                <li><a href="shop.html?category=accessories">ACCESSORIES</a></li>
                <li><a href="shop.html?category=footwear">FOOTWEAR</a></li>
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
                <button class="checkout deca">Check out</button>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="c-checkout">
                <h1>Checkout</h1>
                <form method="post" id="checkoutform">
                    <div class="left-side">
                        <div class="upper-header">Customer Information</div>
                        <div class="box">
                            <label for="fn">Full Name</label>
                            <input type="text" name="fname" id="fname" required>
                        </div>
                        <div class="box">
                            <label for="contact">Contact Number</label>
                            <input type="tel" name="contact" id="contact" required>
                        </div>
                        <div class="box">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" required></textarea>
                        </div>
                        <div class="box">
                            <label>Payment Method</label>
                            <div class="payment">
                                <input type="radio" name="payment" id="payment" value="cod" checked>
                                <label for="payment">Cash on Delivery (COD)</label>
                            </div>
                        </div>
                    </div>
                    <div class="right-side">
                        <div class="upper">
                            <div class="upper-header">
                                <i class="fa fa-shopping-cart"></i>
                                <section>Your Order</section>
                            </div>
                            <div class="o-display">
                                <div class="order">
                                    <div class="l-display">
                                        <h3>name</h3>
                                        <p>description</p>
                                        <p class="price">Price</p>
                                        <p>qty</p>
                                    </div>
                                    <div class="r-display">
                                        <button type="button">-</button>
                                        <span>2</span>
                                        <button type="button">+</button>
                                    </div>
                                </div>
                                <div class="order">
                                    <div class="l-display">
                                        <h3>name</h3>
                                        <p>description</p>
                                        <p class="price">Price</p>
                                        <p>qty</p>
                                    </div>
                                    <div class="r-display">
                                        <button type="button">-</button>
                                        <span>2</span>
                                        <button type="button">+</button>
                                    </div>
                                </div>
                                <div class="order">
                                    <div class="l-display">
                                        <h3>name</h3>
                                        <p>description</p>
                                        <p class="price">Price</p>
                                        <p>qty</p>
                                    </div>
                                    <div class="r-display">
                                        <button type="button">-</button>
                                        <span>2</span>
                                        <button type="button">+</button>
                                    </div>
                                </div>
                                <div class="order">
                                    <div class="l-display">
                                        <h3>name</h3>
                                        <p>description</p>
                                        <p class="price">Price</p>
                                        <p>qty</p>
                                    </div>
                                    <div class="r-display">
                                        <button type="button">-</button>
                                        <span>2</span>
                                        <button type="button">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="summary">
                            <h4>Order Summary</h4>
                            <div class="summary-items">
                            </div>
                            <div class="summary-total">
                                <div class="title">Total: </div>
                                <div class="total">₱100</div>
                            </div>
                            <button type="submit"> Place order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
<script src="scripts/cart.js"></script>
<script src="scripts/app.js"></script>
<script src="scripts/checkout.js"></script>

</html>