<x-layout judul="Siswa">

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
            }, 7000);
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
                        <h5 class="card-title mb-0 text-md-start text-center">Filter Data</h5>
                    </div>
                    <div
                        class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0"></div>
                    </div>
                </div>
                <form action="{{ route('pesan.index')}}" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Tanggal awal</label>
                        <input class="form-control" type="date" name="tanggal_awal" value="{{ request('tanggal_awal', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Tanggal akhir</label>
                        <input class="form-control" type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route('pesan.index') }}';" class="btn btn-outline-primary mt-2">
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
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Siswa</h5>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table mt-2">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">

                    <div class="card table-responsive w-100 m-1">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">NIS</th>
                                    <th class="ps-5">Nama Siswa</th>
                                    <th class="text-center">Telepon Orang Tua</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->count() > 0)
                                    @foreach($data as $d)
                                    <tr>
                                        <td class="text-center">{{ $d->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">{{$d->nis}}</td>
                                        <td>{{ $d->nama_siswa}}</td>
                                        <td class="text-center">{{ $d->telepon_ortu == "" ? "-" : $d->telepon_ortu}}</td>
                                        <td class="text-center"><span class="badge bg-label-{{ $d->status == 'gagal' ? 'danger' : 'success'}} me-1">{{ $d->status}}</span></td>
                                        
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="6">Data belum ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mx-3 justify-content-between mt-2">
                {{ $data->links('pagination::bootstrap-5') }} 
            </div>
        </div>
    </div>
    
</x-layout>


