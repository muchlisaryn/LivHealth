


<div class="text-sm">
    <div class="font-bold mb-4">
       
        <div class="flex justify-between">
            <div>Status Pembayaran</div>
            <div>{{ $status_payment }}</div>
        </div>
    </div>
    <div >
        <div class="flex justify-between">
            <div>{{ $programs_name }} ({{ $programs_duration }} Days )</div>
            <div>Rp. {{ number_format($order_total, 0, ',', '.') }}</div>
        </div>
        <div class="flex justify-between">
            <div>Ongkos Kirim</div>
            <div>Rp. {{ number_format($shipping_price, 0, ',', '.') }}</div>
        </div>
        <div class="border-b border-dashed my-2"></div>
        <div class="flex justify-between font-bold">
            <div>Total</div>
            <div>Rp. {{ number_format($sub_total, 0, ',', '.') }}</div>
        </div>
    </div>
</div>
