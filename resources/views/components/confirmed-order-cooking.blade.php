<div class="text-sm mb-5">
    <div class="font-bold mb-4">
        <div class="flex justify-between border-b p-2">
            <div>Nomor Transaksi</div>
            <div>#{{ $no_transaksi }}</div>
        </div>
        <div class="flex justify-between border-b p-2">
            <div>Nama Customer</div>
            <div>{{ $nama_customer }}</div>
        </div>
    </div>
    <div >
       @foreach ($orders as $order)
       <div >
            <div>{{ $loop->index + 1 }}. {{ $order }}</div>
        </div>
       @endforeach
    </div>
</div>