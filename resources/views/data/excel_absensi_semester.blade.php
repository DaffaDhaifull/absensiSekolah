<table border="0" style="border-collapse: collapse;">
    <tr>
        <td colspan="{{ 4 + (count($bulanTerpilih)*4) + 4 }}" style="text-align:center; font-weight:bold; font-size:14pt;">
            {{ $sekolah}}
        </td>
    </tr>
    <tr>
        <td colspan="{{ 4 + (count($bulanTerpilih)*4) + 4 }}" style="text-align:center;">
            Kelas: {{ $kelas->nama_kelas ?? '-' }} &nbsp;|&nbsp; Wali Kelas: {{ $kelas->users->name ?? '-' }}
        </td>
    </tr>
    <tr>
        <td colspan="{{ 4 + (count($bulanTerpilih)*4) + 4 }}" style="text-align:center;">
            Periode: {{ \Carbon\Carbon::parse($tanggal_range[0])->format('d M Y') }}
            s/d {{ \Carbon\Carbon::parse(end($tanggal_range))->format('d M Y') }}
        </td>
    </tr>
</table>

<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th rowspan="2" style="border:1px solid #000; text-align:center;"><b>NO</b></th>
            <th rowspan="2" style="border:1px solid #000; text-align:center;"><b>NIS</b></th>
            <th rowspan="2" style="border:1px solid #000; text-align:center; width:300px;"><b>Nama Siswa</b></th>
            <th rowspan="2" style="border:1px solid #000; text-align:center;"><b>JK</b></th>

            @php
                $bulanGrup = collect($tanggal_range)->groupBy(fn($tgl) => \Carbon\Carbon::parse($tgl)->translatedFormat('F Y'));
            @endphp
            @foreach ($bulanTerpilih as $bulan)
                <th colspan="4" style="border:1px solid #000; text-align:center;">
                    <b>{{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}</b>
                </th>
            @endforeach


            <th colspan="4" style="border:1px solid #000; text-align:center;"><b>Total</b></th>
        </tr>
        <tr>

            @foreach ($bulanTerpilih as $bulan)
                <th style="border:1px solid #000; text-align:center; width:30px;">H</th>
                <th style="border:1px solid #000; text-align:center; width:30px;">S</th>
                <th style="border:1px solid #000; text-align:center; width:30px;">I</th>
                <th style="border:1px solid #000; text-align:center; width:30px;">A</th>
            @endforeach

            <th style="border:1px solid #000; text-align:center;">Hadir</th>
            <th style="border:1px solid #000; text-align:center;">Sakit</th>
            <th style="border:1px solid #000; text-align:center;">Ijin</th>
            <th style="border:1px solid #000; text-align:center;">Alpa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $s)
            @php
                $status = $absensi[$s->nis] ?? [];
                $counts = array_count_values($status); //digunakan untuk menghitung berapa kali nilai muncul dalam sebuah array.
            @endphp
            <tr>
                <td style="border:1px solid #000; text-align:center;">{{ $loop->iteration }}</td>
                <td style="border:1px solid #000; text-align:center; widht: 150px;">{{ $s->nis }}</td>
                <td style="border:1px solid #000; width:300px;">{{ $s->nama_siswa }}</td>
                <td style="border:1px solid #000; text-align:center;">
                    {{ $s->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }}
                </td>

                @php
                    $total = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
                @endphp

                @foreach ($bulanTerpilih as $bulan)
                    @php
                        $r = $rekapBulanan[$s->nis][$bulan] ?? ['H'=>0,'S'=>0,'I'=>0,'A'=>0];
                        $total['H'] += $r['H'];
                        $total['S'] += $r['S'];
                        $total['I'] += $r['I'];
                        $total['A'] += $r['A'];
                    @endphp
                    <td style="border:1px solid #000; text-align:center; width:30px;">{{ $r['H'] ?: '-' }}</td>
                    <td style="border:1px solid #000; text-align:center; width:30px;">{{ $r['S'] ?: '-' }}</td>
                    <td style="border:1px solid #000; text-align:center; width:30px;">{{ $r['I'] ?: '-' }}</td>
                    <td style="border:1px solid #000; text-align:center; width:30px;">{{ $r['A'] ?: '-' }}</td>
                @endforeach

                <td style="border:1px solid #000; text-align:center;">{{ $total['H'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $total['S'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $total['I'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $total['A'] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
