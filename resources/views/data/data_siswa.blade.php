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
                <form action="{{ route('siswa.index')}}" method="get" class="row g-3 p-3">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Pilih kelas</label><br>
                        <select class="form-select select2" id="kelas_ab" name="id_kelas">
                            <option value="" hidden>- Pilih kelas -</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('id_kelas') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-capitalize">Cari siswa</label>
                        <input type="search" class="form-control" id="searchSiswa"  name="search" placeholder="Masukan NIS / Nama siswa" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-block align-items-end pt-4">
                        <button type="submit" class="btn btn-primary me-2 mt-2">Cari</button>
                        <button type="button" onclick="this.form.reset(); window.location='{{ route('siswa.index') }}';" class="btn btn-outline-primary mt-2">
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

                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <x-modal useForm="y" useButton="ada" class="mb-5" modalId="tsiswa" modalTitle="Tambah Data Siswa" buttonText="+ Tambah Data">
                                <form action="{{ route('siswa.store') }}" method="post">
                                    @csrf
                                    <button data-bs-toggle="modal" data-bs-target="#siswaexcel" type="button" class="btn btn-outline-primary btn-sm mb-3">Impor dari File Excel</button>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nomor Induk Siswa</label>
                                        <input type="text" class="form-control" name="nis" placeholder="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_siswa" placeholder="Masukan nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Jenis Kelamin</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="jk_t_siswa" name="jenis_kelamin">
                                            <option class="text-sm" value="" selected hidden >- Pilih jenis kelamin -</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kelas Siswa</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="kelas_t_siswa" name="id_kelas">
                                            <option value="" selected hidden>- Pilih kelas -</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">No Telepon Orang Tua</label>
                                        <input type="text" class="form-control" name="telepon_ortu" placeholder="Masukan telepon orang tua">
                                    </div>
                                </form>

                            </x-modal>
                        @endif



                            <x-modal useForm="y" class="mb-5" modalId="siswaexcel" modalTitle="Tambah Siswa dari Excel" buttonText="+ Tambah Data">
                                <form action="{{ route('students.import.process') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="">
                                        <label for="" class="form-label">Nomor Induk Siswa</label>
                                        <input type="file" class="form-control" name="file" placeholder="" readonly>
                                        <small class="text-muted ms-1">Format file: .xlsx atau .xls</small>
                                    </div>
                                </form>
                            </x-modal>

                            <x-modal useForm="y" modalId="siswadelete" modalTitle="Hapus Data Siswa" buttonText="delete">
                                <form method="post" id="form_delete">
                                    @csrf
                                    @method('delete')
                                    <p class="text-lg ms-4">Apakah anda yakin ingin menghapus data ini?</p>
                                </form>
                            </x-modal>


                            <x-modal useForm="y" class="mb-5" modalId="idsiswas" modalTitle="Edit Data Siswa" buttonText="+ Tambah Data">
                                <form method="post" id="form_ubah">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nomor Induk Siswa</label>
                                        <input type="text" class="form-control" id="nis" name="nis" placeholder="" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama_siswa" placeholder="Masukan nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Jenis Kelamin</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="jk" name="jenis_kelamin">
                                            <option class="text-sm" value=""  hidden >- Pilih jenis kelamin -</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kelas Siswa</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="kelas" name="id_kelas">
                                            <option value="" hidden>- Pilih kelas -</option>
                                            @foreach($kelas as $k)
                                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">No Telepon Orang Tua</label>
                                        <input type="text" class="form-control" name="telepon_ortu" id="tlp" placeholder="Masukan telepon orang tua">
                                    </div>
                                </form>
                            </x-modal>


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
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Jenis kelamin</th>
                                    <th>Kelas</th>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                        <th>Opsi</th>   
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($siswa->count() > 0)
                                    @foreach($siswa as $s)
                                    <tr>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>{{ $s->jenis_kelamin }}</td>
                                        <td>{{ $s->classes->nama_kelas }}</td>
                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                            <td class="d-flex gap-2">
                                                <button value="{{ $s->nis }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#idsiswas" class="btn btn-warning btn-sm">Edit</button>
                                                <button value="{{ $s->nis }}" onclick="hapus(this.value)" data-bs-toggle="modal" data-bs-target="#siswadelete" class="btn btn-danger btn-sm">Hapus</button>
                                                {{-- <form action="/siswa/{{ $s->nis }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form> --}}
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="5">Data belum ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mx-3 justify-content-between mt-2">
                {{ $siswa->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>


<script>
    async function ubah(id) {
        const data = await window.api.get(`/siswa/${id}`)

        const form = document.getElementById("form_ubah")
        const nis = document.getElementById("nis")
        const nama = document.getElementById("nama")
        const jk = document.getElementById("jk")
        const kelas = document.getElementById("kelas")
        const tlp = document.getElementById("tlp")

        nis.value = data.nis
        nama.value = data.nama_siswa
        tlp.value = data.telepon_ortu
        $('#jk').val(data.jenis_kelamin).trigger('change')
        $('#kelas').val(data.id_kelas).trigger('change')

        form.action = `/siswa/${data.nis}`
    }

    async function hapus(id){
        const data = await window.api.get(`/siswa/${id}`)

        const form = document.getElementById("form_delete")
        form.action = `/siswa/${data.nis}`
    }
</script>
    
</x-layout>


