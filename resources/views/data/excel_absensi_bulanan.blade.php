<table border="0" style="border-collapse: collapse;">
    <tr>
        <td colspan="{{ 4 + count($tanggal_range) + 4 }}" style="text-align:center; font-weight:bold; font-size:14pt;">
            {{$sekolah}}
        </td>
    </tr>
    <tr>
        <td colspan="{{ 4 + count($tanggal_range) + 4 }}" style="text-align:center;">
            Kelas: {{ $kelas->nama_kelas ?? '-' }} &nbsp;|&nbsp; Wali Kelas: {{ $kelas->users->name ?? '-' }}
        </td>
    </tr>
    <tr>
        <td colspan="{{ 4 + count($tanggal_range) + 4 }}" style="text-align:center;">
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
            <th rowspan="2" style="border:1px solid #000; text-align:center; width:200px;"><b>Nama Siswa</b></th>
            <th rowspan="2" style="border:1px solid #000; text-align:center;"><b>JK</b></th>
            <th colspan="{{ count($tanggal_range) }}" style="border:1px solid #000; text-align:center;">
                <b>Bulan {{ \Carbon\Carbon::parse($tanggal_range[0])->translatedFormat('F Y') }}</b>
            </th>
            <th colspan="4" style="border:1px solid #000; text-align:center;"><b>Jumlah</b></th>
        </tr>
        <tr>
            @foreach($tanggal_range as $tgl)
                <th style="border:1px solid #000; text-align:center; width:30px;">
                    {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                </th>
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
                $counts = array_count_values($status);
            @endphp
            <tr>
                <td style="border:1px solid #000; text-align:center;">{{ $loop->iteration }}</td>
                <td style="border:1px solid #000; text-align:center; widht: 150px;">{{ $s->nis }}</td>
                <td style="border:1px solid #000; widht: 500px;">{{ $s->nama_siswa }}</td>
                <td style="border:1px solid #000; text-align:center;">
                    {{ $s->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }}
                </td>
                @foreach($tanggal_range as $tgl)
                    <td style="border:1px solid #000; text-align:center; width:30px;">
                        {{ $absensi[$s->nis][$tgl] ?? '' }}
                    </td>
                @endforeach
                <td style="border:1px solid #000; text-align:center;">{{ $counts['H'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $counts['S'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $counts['I'] ?? '-' }}</td>
                <td style="border:1px solid #000; text-align:center;">{{ $counts['A'] ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
