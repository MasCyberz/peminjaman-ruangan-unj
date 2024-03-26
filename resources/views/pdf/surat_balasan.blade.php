<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Balasan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header,
        footer,
        main {
            width: 80%;
            margin: 0 auto;
        }

        main {
            margin-bottom: 20px;
        }

        footer {
            text-align: right;
        }

        footer p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <header style="display: flex; width: 100%;">
        {{-- <div class="logo">
            <img src="{{asset('img/logo.png')}}" alt="" width="120">
        </div> --}}
        <div style="text-align: center">
            <h1>Universitas Negeri Jakarta</h1>
            <p>UPT TIK</p>
            <p>Jalan R.Mangun Muka Raya No.11 RT.11 RW.14, Rawamangun Kec.Pulogadung, Jakarta 13220</p>
        </div>
    </header>
    <hr>
    <main>
        <p style="text-align: right">{{ $tanggal }}</p>
        <p>Kepada Mahasiswa/Peminjam,</p>
        <p>{{ $namaPeminjam }}</p>
        <p><strong>Perihal:</strong> Konfirmasi Permohonan Penggunaan Ruang</p>
        <p>Dengan hormat,</p>
        <p>Kami mengucapkan terima kasih atas permohonan Anda untuk menggunakan ruang-ruang di UPT TIK. Setelah
            mempertimbangkan dengan seksama, kami ingin memberikan konfirmasi sebagai berikut:</p>
        <p>Detail Surat yang diajukan :</p>
        <ul>
            <li>Nomor Surat: {{ $nomorSurat }}</li>
            <li>Asal Surat: {{ $asalSurat }}</li>
            <li>Jumlah Ruang: {{ $jmlRuang }}</li>
            <li>Jumlah PC: {{ $jmlPc }}</li>
            <li>Tanggal: {{ \Carbon\Carbon::parse($mulaiDipinjam)->format('d F Y') }} -
                {{ \Carbon\Carbon::parse($selesaiDipinjam)->format('d F Y') }}</li>
        </ul>

        {{-- <p>Dengan segala pertimbangan maka surat tersebut <strong
                style="text-transform: uppercase;">{{ $status }}</strong>.</p> --}}

        @php

            // Memeriksa apakah status surat adalah 'Diterima' di tabel pivot ruangans
            $statusDiterima = $surat->ruangans->contains(function ($ruangan) {
                return $ruangan->pivot->status === 'diterima';
            });

            // Memeriksa apakah status surat adalah 'Ditolak' di tabel pivot ruangans
            $statusDitolak = $surat->ruangans->contains(function ($ruangan) {
                return $ruangan->pivot->status === 'ditolak';
            });
        @endphp

        @if ($statusDiterima)
            <p>Surat Anda telah <strong style="text-transform: uppercase">diterima</strong>. Anda telah diberikan izin
                untuk menggunakan ruang-ruang di
                UPT TIK.</p>
        @elseif ($statusSurat === 'ditolak' || $statusDitolak)
            <p>Surat Anda telah <strong style="text-transform: uppercase">ditolak</strong>. Mohon maaf, izin untuk
                menggunakan ruang-ruang di UPT TIK
                tidak dapat diberikan.</p>
                @if ($statusSurat === 'ditolak')
                <p>Alasan ditolak : {{ $alasanSurat }}</p>
                @endif
                @if ($statusDitolak)
                <p>Alasan Ditolak : Ruangan yang dipilih hilang.</p>
                @endif
        @endif

        @if ($statusDiterima)
            <p>Selanjutnya, berikut rincian ruang yang telah disetujui untuk penggunaan:</p>
            <ul>
                @foreach ($ruangans as $ruangan)
                    <li>Ruang : {{ $ruangan->nomor_ruang }}</li>
                @endforeach
            </ul>
        @endif

        {{-- <p>Berikut rincian untuk ruangnya :</p>
        <ul>
            @foreach ($ruangans as $ruangan)
                <li>Ruang : {{ $ruangan->nomor_ruang }}</li>
            @endforeach
        </ul> --}}


        <p>Demikianlah konfirmasi dari kami. Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan, jangan
            ragu untuk menghubungi kami melalui nomor kontak yang tertera di bawah.</p>
    </main>
    <footer>
        <p>Hormat kami,</p>
        <br><br><br><br>
        <p><strong>Kepala UPT TIK</strong></p>
        <p>Universitas Negeri Jakarta</p>
        <p>Nomor kontak: 08123818238321</p>
    </footer>
</body>

</html>
