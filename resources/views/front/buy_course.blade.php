@extends('front.master')
@section('title', 'Homepage| ' . env('APP_NAME'))

@section('content')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://js.stripe.com/v3/"></script>
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
        <!--shop category start-->
        <section class="space-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('website.buy_course_thanks', $course->id) }}" method="POST"
                            id="payment-form">
                            @csrf

                            <button class="btn btn-primary" type="submit">Submit Payment</button>
                        </form>
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
                                        <td class="product-name"> {{ $course->trans_name }} </td>
                                        <td class="product-total">
                                            <span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">৳&nbsp;</span>{{ $course->price }}</span>
                                        </td>
                                    </tr>
                                    <tr class="cart_item">
                                        <td class="product-name"> discount </td>
                                        <td class="product-total">
                                            <span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">৳&nbsp;</span>{{ $course->discount }}%</span>
                                        </td>
                                    </tr>

                                </tbody>
                                <tfoot>



                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="woocommerce-Price-amount amount"><span
                                                        class="woocommerce-Price-currencySymbol">৳&nbsp;</span>{{ $total }}</span></strong>
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
