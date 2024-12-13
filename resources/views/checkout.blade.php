<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Checkout</title>  
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>  
</head>  
<body>  
    <h1>Checkout Page</h1>  
    <form id="payment-form" method="POST" action="{{ route('payment.make') }}">  
        @csrf  
        <input type="hidden" name="snap_token" id="snap-token">  
        <button type="button" id="pay-button">Bayar</button>  
    </form>  

    <script>  
        document.getElementById('pay-button').addEventListener('click', function (e) {  
            e.preventDefault();  

            fetch('{{ route("payment.make") }}', {  
                method: 'POST',  
                headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': '{{ csrf_token() }}' },  
                body: JSON.stringify({  
                    total_price: 10000, // Ubah sesuai total belanja  
                    cart_items: [1], // Sertakan data keranjang  
                    name: "Nama Pembeli",  
                    email: "email@example.com",  
                    phone: "08123456789",  
                }),  
            })  
                .then(response => response.json())  
                .then(data => {  
                    snap.pay(data.snap_token, {  
                        // Callback jika selesai bayar  
                        onSuccess: function (result) {  
                            alert("Pembayaran sukses! " + JSON.stringify(result));  
                        },  
                        onPending: function (result) {  
                            alert("Pembayaran pending: " + JSON.stringify(result));  
                        },  
                        onError: function (result) {  
                            alert("Pembayaran gagal: " + JSON.stringify(result));  
                        },  
                    });  
                });  
        });  
    </script>  
</body>  
</html>