<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>


    <link rel="stylesheet" href="styles/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <div class="c-checkout">

            <h1>Checkout</h1>

            <div>

                <div class="left-side">
                    <div class="upper-header">Customer Information</div>

                    <div class="box">
                        <label for="fn">Fullname</label>
                        <input type="text" name="fn" id="fn">
                    </div>

                    <div class="box">
                        <label for="pn">Phone Number</label>
                        <input type="text" name="pn" id="pn">
                    </div>

                    <div class="box">
                        <label for="address">Address</label>

                        <textarea name="" id=""></textarea>
                    </div>

                    <div class="box">
                        <label>Payment Method</label>

                        <div class="cod">
                            <input type="radio" name="pm" id="pm" value="cod" checked>
                            <label for="pm">Cash on Delivery (COD)</label>
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

                    <div class="o-summary">
                        <section>Order Summary</section>
                        <div class="summary">
                            <div class="s">
                                <div>item x qty</div>
                                <div>total price</div>
                            </div>
                            <div class="s">
                                <div>item x qty</div>
                                <div>total price</div>
                            </div>
                            <div class="s">
                                <div>item x qty</div>
                                <div>total price</div>
                            </div>
                            <div class="s">
                                <div>item x qty</div>
                                <div>total price</div>
                            </div>
                        </div>
                        <button type="button"> Place order</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="scripts/checkout.js"></script>

</html>