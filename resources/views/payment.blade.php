<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>

<h2>💳 Payment Page</h2>

<form id="payment-form">
    <label>Card Info:</label>
    <div id="card-element" style="border:1px solid #ccc; padding:10px;"></div>

    <br>

    <button id="submit">Pay Now</button>

    <p id="error-message" style="color:red;"></p>
</form>

<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");

    const elements = stripe.elements();
    const card = elements.create('card', {
    hidePostalCode: true
});
    card.mount('#card-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        document.getElementById('submit').disabled = true;

        try {
            // 🟢 طلب إنشاء order
            const response = awaitfetch("/web/orders", {
                method: "POST",
                credentials: "same-origin",
               headers: {
    "Content-Type": "application/json",
    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
},
                body: JSON.stringify({
                    address: "Test Address",
                    phone: "123456",
                    payment_method: "online"
                })
            });

            const data = await response.json();

            // 🔥 مهم جداً للتشخيص
            console.log("RESPONSE FROM BACKEND:", data);

            if (!response.ok) {
                alert("❌ Error from backend");
                document.getElementById('submit').disabled = false;
                return;
            }

            if (!data.client_secret) {
                alert("❌ client_secret missing");
                document.getElementById('submit').disabled = false;
                return;
            }

            // 🟢 تنفيذ الدفع
            const result = await stripe.confirmCardPayment(data.client_secret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: "Test User"
                    }
                }
            });

            if (result.error) {
                document.getElementById('error-message').innerText = result.error.message;
                document.getElementById('submit').disabled = false;
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    alert("✅ Payment Successful!");
                    window.location.href = "/success";
                }
            }

        } catch (error) {
            console.error("JS ERROR:", error);
            alert("❌ Something went wrong");
            document.getElementById('submit').disabled = false;
        }
    });
</script>

</body>
</html>