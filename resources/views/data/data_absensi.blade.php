<x-layout judul="Absensi">
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
    {{-- @php dd(session()->all()); @endphp --}}
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
    
    @foreach (session()->all() as $key => $value)
        @if (Str::startsWith($key, 'warning_'))
            <div class="alert alert-warning" id="tlp">
                {{ $value }}
            </div>

            <script>
                setTimeout(function() {
                    var alertElement = document.getElementById('tlp');
                    alertElement.remove('show');
                }, 6000);
            </script>
        @endif
    @endforeach

    @if ($errors->any())
        <div class="alert alert-danger" role="alert" id="error_alert">
            <strong>Oops! Ada kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <script>
            setTimeout(function() {
                var alertElement = document.getElementById('error_alert');
                alertElement.remove('show');
            }, 5000);
        </script>
    @endif

    
    <div class="card mb-4 pb-3">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Filter Data</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0"></div>
                    </div>
                </div>
                <form action="/absensi" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Pilih tanggal</label>
                        <input class="form-control" type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Pilih kelas</label><br>
                        <select class="form-select select2" id="kelas_ab" name="id_kelas">
                            <option value="" hidden>- Pilih kelas -</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('id_kelas') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route('absensi.index') }}';" class="btn btn-outline-primary mt-2">
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
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Absensi</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0">
                        </div>
                    </div>
                </div>
            </div>



            <form method="post" id="form_absensi">@csrf

                <div class="justify-content-between dt-layout-table mt-2 p-2">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2" class="text-center" style="width: 25px;">NO</th>
                                    <th rowspan="2" class="text-center">NIS</th>
                                    <th rowspan="2" class="text-center">Nama Siswa</th>
                                    <th rowspan="2" class="text-center" style="width: 100px;">Jenis Kelamin</th>
                                    <th colspan="4" class="text-center">Keterangan</th>
                                </tr>
                                <tr>
                                    <th style="width: 30px;">Hadir</th>
                                    <th style="width: 30px;">Sakit</th>
                                    <th style="width: 30px;">Izin</th>
                                    <th style="width: 30px;">Alpa</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if (Request::has('id_kelas'))
                                    @foreach ($siswa as $s)
                                    @php
                                        $keterangan_siswa = $absensi[$s->nis]->keterangan ?? null;
                                    @endphp
                                        <tr>
                                            <input type="hidden" name="siswa_ids[]" value="{{ $s->nis }}">
                                            <input type="hidden" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                                            <td class="text-center">{{ $loop->iteration}}</td>
                                            <td class="text-center">{{$s->nis}}</td>
                                            <td style="padding-left: 5%;">{{$s->nama_siswa}}</td>
                                            <td class="text-center">{{ $s->jenis_kelamin == 'Perempuan' ? 'P':'L' }}</td>
                                            <td class="text-center" style="width: 30px;"><input type="radio" name="keterangan[{{$s->nis}}]" value="Hadir" {{ $keterangan_siswa == 'Hadir' ? 'checked' : '' }}></td>
                                            <td class="text-center" style="width: 30px;"><input type="radio" name="keterangan[{{$s->nis}}]" value="Sakit" {{ $keterangan_siswa == 'Sakit' ? 'checked' : '' }}></td>
                                            <td class="text-center" style="width: 30px;"><input type="radio" name="keterangan[{{$s->nis}}]" value="Izin" {{ $keterangan_siswa == 'Izin' ? 'checked' : '' }}></td>
                                            <td class="text-center" style="width: 30px;"><input type="radio" name="keterangan[{{$s->nis}}]" value="Alpa" {{ $keterangan_siswa == 'Alpa' ? 'checked' : '' }}></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="8">Pilih kelas dulu!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="dt-container dt-bootstrap5 dt-empty-footer">
                    <div class="row flex-column flex-md-row pb-0 pb-3 pe-3">
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                            <h5 class="card-title mb-0 text-md-start text-center"></h5>
                        </div>
                        <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                            <div class="dt-buttons btn-group flex-wrap mb-0">
                                @php
                                    $tanggalInput = \Carbon\Carbon::parse($tanggal);
                                    $sekarang = \Carbon\Carbon::now();
                                    $lebihDari1Hari = $tanggalInput->lt($sekarang->subDay(2));
                                @endphp
                                @if($absensiAda)
                                    @if($user->role === 'admin' || ($user->role === 'guru' && !$lebihDari1Hari))
                                        <button type="submit" class="btn btn-warning" formaction="{{ route('absensi.update', ['tanggal' => $tanggal, 'id_kelas' => $kelas_id]) }}">Ubah Absensi</button>
                                    @endif
                                @else
                                    @if($user->role === 'admin' || ($user->role === 'guru' && !$lebihDari1Hari))
                                    <button type="submit" class="btn btn-primary" formaction="{{ route('absensi.store') }}">Tambah Absensi</button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

</x-layout>
