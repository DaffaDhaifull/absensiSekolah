<x-layout judul="Kelas">

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

    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Kelas</h5>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0">

                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <x-modal useForm="y" useButton="ada" class="mb-5" modalId="idkelas" modalTitle="Tambah Data Kelas" buttonText="+ Tambah Data">
                                <form action="{{ route('kelas.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Kelas</label>
                                        <input type="text" class="form-control" name="nama_kelas" placeholder="Masukan nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Wali kelas</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="wali_kelas" name="wali_kelas">
                                          <option value="" selected hidden>- Pilih wali kelas -</option>
                                          @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </form>
                            </x-modal>
                        @endif

                            <x-modal useForm="y" class="mb-5" modalId="idkelase" modalTitle="Edit Data Kelas" buttonText="+ Tambah Data">
                                <form method="post" id="form_ubah">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Kelas</label>
                                        <input type="text" id="nama_kelas" class="form-control" name="nama_kelas" placeholder="Masukan nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Wali kelas</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="wali_u_kelas" name="wali_kelas">
                                          <option value="" selected hidden>- Pilih wali kelas -</option>
                                          @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">

                    <div class="card table-responsive w-100 m-1">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Wali Kelas</th>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                        <th>Opsi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($classes->count() > 0)
                                    @foreach($classes as $c)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $c->nama_kelas }}</td>
                                        <td>{{ $c->users->name}}</td>
                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                            <td class="d-flex gap-2">
                                                <button value="{{ $c->id }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#idkelase" class="btn btn-warning btn-sm">Edit</button>
                                                <form action="/kelas/{{ $c->id }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="3">Data belum ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mx-3 justify-content-between mt-2">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">Menampilkan 1 - 10 dari 6 data</div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                <li class="dt-paging-button page-item disabled">
                                    <button class="page-link previous" role="link" type="button" aria-controls="DataTables_Table_0" aria-disabled="true" aria-label="Previous" data-dt-idx="previous" tabindex="-1">
                                        <i class="icon-base bx bx-chevron-left scaleX-n1-rtl icon-18px"></i>
                                    </button>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <button class="page-link next" role="link" type="button" aria-controls="DataTables_Table_0" aria-label="Next" data-dt-idx="next">
                                        <i class="icon-base bx bx-chevron-right scaleX-n1-rtl icon-18px"></i>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        async function ubah(id) {
            const data = await window.api.get(`/kelas/${id}`)
            const name = document.getElementById("nama_kelas")
            const form = document.getElementById("form_ubah")

            name.value = data.nama_kelas
            $('#wali_u_kelas').val(data.wali_kelas).trigger('change')
            form.action = `/kelas/${data.id}`
        }
    </script>
</x-layout>