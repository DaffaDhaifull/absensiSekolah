<x-layout judul="Laporan">

    @if (session('error'))
        <div class="alert alert-danger" role="alert" id="error_alert">
            <strong>{{ session('error') }}</strong>
        </div>

        <script>
            setTimeout(function() {
                var alertElement = document.getElementById('error_alert');
                alertElement.remove('show');
            }, 5000);
        </script>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert" id="s_alert">
            <strong>{{ session('success') }}</strong>
        </div>

        <script>
            setTimeout(function() {
                var alertElement = document.getElementById('s_alert');
                alertElement.remove('show');
            }, 3000);
        </script>
    @endif



    <div class="card mb-4 pb-3">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Laporan Absensi</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0"></div>
                    </div>
                </div>
                <form action="/laporan" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Tanggal awal</label>
                        <input class="form-control" type="date" name="tanggal_awal" value="{{ request('tanggal_awal', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Tanggal akhir</label>
                        <input class="form-control" type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-capitalize">Pilih kelas</label><br>
                        <select class="form-select select2" id="kelas_ab" name="id_kelas">
                            <option value="" hidden>- Pilih kelas -</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('id_kelas') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route('laporan.index') }}';" class="btn btn-outline-primary mt-2">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">

                <form action="{{ route('laporan.export', ['tanggal_awal' => request('tanggal_awal'),'tanggal_akhir' => request('tanggal_akhir'),'id_kelas' => request('id_kelas'),]) }}" method="post" id="form_absensi">@csrf
                    <div class="justify-content-between dt-layout-table mt-2 p-2">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">


                            @if ($isRekapBulanan)

                                <table class="table table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2" class="text-center fw-bold" style="width:25px;">NO</th>
                                            <th rowspan="2" class="text-center fw-bold">NIS</th>
                                            <th rowspan="2" class="text-center fw-bold">Nama Siswa</th>
                                            <th rowspan="2" class="text-center fw-bold" style="width:50px;">JK</th>

                                            @foreach ($bulan_range as $bulan)
                                                <th class="text-center fw-bold" colspan="4">
                                                    Bulan {{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}
                                                </th>
                                            @endforeach

                                            <th class="text-center fw-bold" colspan="4">Total</th>
                                        </tr>
                                        <tr>
                                            @foreach ($bulan_range as $bulan)
                                                <th class="text-center fw-bold">H</th>
                                                <th class="text-center fw-bold">S</th>
                                                <th class="text-center fw-bold">I</th>
                                                <th class="text-center fw-bold">A</th>
                                            @endforeach
                                            <th class="text-center fw-bold">Hadir</th>
                                            <th class="text-center fw-bold">Sakit</th>
                                            <th class="text-center fw-bold">Ijin</th>
                                            <th class="text-center fw-bold">Alpa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $s)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $s->nis }}</td>
                                                <td>{{ $s->nama_siswa }}</td>
                                                <td class="text-center">{{ $s->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }}</td>

                                                @php
                                                    $total = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
                                                @endphp

                                                @foreach ($bulan_range as $bulan)
                                                    @php
                                                        $r = $rekapBulanan[$s->nis][$bulan] ?? ['H'=>0,'S'=>0,'I'=>0,'A'=>0];
                                                        $total['H'] += $r['H'];
                                                        $total['S'] += $r['S'];
                                                        $total['I'] += $r['I'];
                                                        $total['A'] += $r['A'];
                                                    @endphp
                                                    <td class="text-center">{{ $r['H'] ?: '-' }}</td>
                                                    <td class="text-center">{{ $r['S'] ?: '-' }}</td>
                                                    <td class="text-center">{{ $r['I'] ?: '-' }}</td>
                                                    <td class="text-center">{{ $r['A'] ?: '-' }}</td>
                                                @endforeach

                                                <td class="text-center fw-bold">{{ $total['H'] ?: '-' }}</td>
                                                <td class="text-center fw-bold">{{ $total['S'] ?: '-' }}</td>
                                                <td class="text-center fw-bold">{{ $total['I'] ?: '-' }}</td>
                                                <td class="text-center fw-bold">{{ $total['A'] ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @else

                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th rowspan="2" class="text-center" style="width: 25px;">NO</th>
                                        <th rowspan="2" class="text-center">NIS</th>
                                        <th rowspan="2" class="text-center">Nama Siswa</th>
                                        <th rowspan="2" class="text-center" style="width: 50px;">JK</th>
                                        <th class="text-center" colspan="{{ count($tanggal_range) }}">Bulan {{ \Carbon\Carbon::parse($tanggal_range[0])->translatedFormat('F Y') }}</th>
                                        <th class="text-center" colspan="4">Jumlah</th>
                                    </tr>
                                    <tr>
                                        @foreach ($tanggal_range as $tgl)
                                            <th class="text-center" style="width: 10px;">{{ \Carbon\Carbon::parse($tgl)->format('d') }}</th>
                                        @endforeach
                                        <th style="width:30px;">Hadir</th>
                                        <th style="width:30px;">Sakit</th>
                                        <th style="width:30px;">Ijin</th>
                                        <th style="width:30px;">Alpa</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (Request::has('id_kelas'))

                                        @if (count($tanggal_range))
                                            @foreach($siswa as $s)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $s->nis }}</td>
                                                    <td>{{ $s->nama_siswa }}</td>
                                                    <td class="text-center">{{ $s->jenis_kelamin == 'Perempuan' ? 'P' : 'L' }}</td>

                                                    @foreach($tanggal_range as $tgl)
                                                        <td class="text-center">{{ $absensi[$s->nis][$tgl] ?? '' }}</td>
                                                    @endforeach

                                                    @php
                                                        $status = $absensi[$s->nis] ?? [];
                                                        $counts = array_count_values($status);
                                                    @endphp

                                                    <td class="text-center">{{ $counts['H'] ?? '-'}}</td>
                                                    <td class="text-center">{{ $counts['S'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $counts['I'] ?? '-' }}</td>
                                                    <td class="text-center">{{ $counts['A'] ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="{{4 + count($tanggal_range) + 4 }}">Pilih kelas dan tanggal yang valid!</td>
                                            </tr>
                                        @endif
                                    @else
                                            <tr>
                                                <td class="text-center" colspan="{{4 + count($tanggal_range) + 4 }}">Pilih data dulu!</td>
                                            </tr>
                                    @endif
                                </tbody>
                            </table>

                            @endif


                        </div>
                    </div>
                    <div class="dt-container dt-bootstrap5 dt-empty-footer">
                        <div class="row flex-column flex-md-row pb-0 pb-3 pe-3">
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                                <h5 class="card-title mb-0 text-md-start text-center"></h5>
                            </div>
                            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                                <div class="dt-buttons btn-group flex-wrap mb-0">
                                        <button type="submit" class="btn btn-primary">Export Data Absensi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-layout>
