<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<div class="container">
    <h2>Checkout</h2>
    <button id="checkout-button">Checkout</button>
</div>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    document.getElementById('checkout-button').addEventListener('click', async () => {
        const response = await fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });

        const sessionId = await response.json();
        const result = await stripe.redirectToCheckout({ sessionId: sessionId.id });

        if (result.error) {
            alert(result.error.message);
        }
    });
</script>
</body>
</html>
