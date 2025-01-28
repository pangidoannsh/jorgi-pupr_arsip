@if (isset($tembusan))
    <div>
        <div>Tembusan kepada Yth,</div>
        <ol style="margin-left: -20px">
            @php
                // Ambil jumlah tembusan
                $tembusanCount = count($tembusan ?? []);
                // Hitung kekurangan jika tembusan kurang dari 4
                $emptyCount = max(0, 4 - $tembusanCount);
            @endphp

            @foreach ($tembusan as $surat)
                <li>{{ $surat->user?->name }}</li>
            @endforeach

            {{-- Tambahkan item kosong jika kurang dari 4 --}}
            @for ($i = 0; $i < $emptyCount; $i++)
                <li>&nbsp;</li>
            @endfor
        </ol>
    </div>
@endif
