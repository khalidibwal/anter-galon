<form id="payForm" action="{{ route('payment.method') }}" method="GET">
    @csrf
</form>

<script>
    document.getElementById('payForm').submit();
</script>

<p>Memproses pembayaran...</p>
