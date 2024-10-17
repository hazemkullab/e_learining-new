@extends('front.master')
@section('title', 'Homepage| ' . env('APP_NAME'))

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="page-header-content">
                        <h1>Checkout</h1>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="list-inline-item">/</li>
                            <li class="list-inline-item">
                                Checkout
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="site-main woocommerce single single-product page-wrapper">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://js.stripe.com/v3/"></script>
        <!--shop category start-->
        <section class="space-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('website.buy_course_thanks',$course->id) }}" method="POST" id="payment-form">
                            @csrf
                            <div class="form-group">
                                <label for="card-element">Credit or Debit Card</label>
                                <div id="card-element" class="form-control">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit Payment</button>
                        </form>
                        <script>
                            var stripe = Stripe('{{ env('STRIPE_KEY') }}');
                            var elements = stripe.elements();

                            var style = {
                                base: {
                                    color: "#32325d",
                                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                    fontSmoothing: "antialiased",
                                    fontSize: "16px",
                                    lineHeight: "24px",
                                    '::placeholder': {
                                        color: '#aab7c4'
                                    }
                                },
                                invalid: {
                                    color: '#fa755a',
                                    iconColor: '#fa755a'
                                }
                            };

                            var card = elements.create('card', {style: style});
                            card.mount('#card-element');

                            card.on('change', function(event) {
                                var displayError = document.getElementById('card-errors');
                                if (event.error) {
                                    displayError.textContent = event.error.message;
                                } else {
                                    displayError.textContent = '';
                                }
                            });

                            var form = document.getElementById('payment-form');
                            form.addEventListener('submit', function(event) {
                                event.preventDefault();
                                stripe.createToken(card).then(function(result) {
                                    if (result.error) {
                                        var errorElement = document.getElementById('card-errors');
                                        errorElement.textContent = result.error.message;
                                    } else {
                                        var hiddenInput = document.createElement('input');
                                        hiddenInput.setAttribute('type', 'hidden');
                                        hiddenInput.setAttribute('name', 'stripeToken');
                                        hiddenInput.setAttribute('value', result.token.id);
                                        form.appendChild(hiddenInput);
                                        form.submit();
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="col-md-5">
                        <div id="order_review" class="woocommerce-checkout-review-order w-100">
                            <h3 id="order_review_heading">Your order</h3>
                            <table class="shop_table woocommerce-checkout-review-order-table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cart_item">
                                        <td class="product-name">
                                            Beanie with Logo&nbsp;
                                            <strong class="product-quantity">× 2</strong>
                                        </td>
                                        <td class="product-total">
                                            <span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">৳&nbsp;</span>36.00</span>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>



                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="woocommerce-Price-amount amount"><span
                                                        class="woocommerce-Price-currencySymbol">৳&nbsp;</span>54.00</span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
