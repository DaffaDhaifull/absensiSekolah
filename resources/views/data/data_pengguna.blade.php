<x-layout judul="Pengguna">

    @if ($errors->any())
        <div class="alert alert-danger" role="alert" id="error_alert">
            <strong>Oops! Ada beberapa kesalahan:</strong>
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


    <div class="card">
        <div class="card-datatable text-nowrap">
            <div class="dt-container dt-bootstrap5 dt-empty-footer">
                <div class="row card-header flex-column flex-md-row pb-0">
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                        <h5 class="card-title mb-0 text-md-start text-center">Data Pengguna</h5>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                        <div class="dt-buttons btn-group flex-wrap mb-0">
                            

                            <x-modal useForm="y" useButton="ada" class="mb-5" modalId="idpengguna" modalTitle="Tambah Data Pengguna" buttonText="+ Tambah Data">
                                <form action="{{ route('pengguna.store') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="name" placeholder="Masukan nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">No Telepon</label>
                                       <input type="text" class="form-control" name="telepon" placeholder="Masukan no telepon" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Masukan email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Masukan password" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Role</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="role_t_pengguna" name="role">
                                          <option value="2" selected hidden >- Pilih role pengguna -</option>
                                          <option value="admin">Kepala sekolah</option>
                                          <option value="guru">Guru</option>
                                        </select>
                                    </div>
                                </form>
                            </x-modal>

                            <x-modal useForm="y" class="mb-5" modalId="idpenggunad" modalTitle="Edit Data Pengguna" buttonText="+ Tambah Data">
                                <form method="post" id="form_ubah">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Masukan nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">No Telepon</label>
                                       <input type="text" id="telepon" class="form-control" name="telepon" placeholder="Masukan no telepon">
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="Masukan email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label><br>
                                        <select class="form-select select2" style="width: 100%;" id="role" name="role">
                                            <option value="2" hidden>- Pilih role pengguna -</option>
                                            <option value="admin">Kepala sekolah</option>
                                            <option value="guru">Guru</option>
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
                                    <th>No Telepon</th>
                                    <th>Email</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->count() > 0)
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->telepon }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="d-flex gap-2">
                                            <button value="{{ $user->id }}" onclick="ubah(this.value)" data-bs-toggle="modal" data-bs-target="#idpenggunad" class="btn btn-warning btn-sm">Edit</button>
                                            <form action=" /pengguna/{{ $user->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                                @if(Auth::user()->id === $user->id)
                                                    <button type="submit" class="btn btn-danger btn-sm" disabled>Hapus</button>
                                                @else
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                @endif
                                            </form>
                                        </td>
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
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info" aria-live="polite" id="DataTables_Table_0_info" role="status">Menampilkan 1 - 10 dari 2000 data</div>
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
            const data = await window.api.get(`/pengguna/${id}`)

            const name = document.getElementById("name")
            const telepon = document.getElementById("telepon")
            const email = document.getElementById("email")
            const form = document.getElementById("form_ubah")

            name.value = data.name
            telepon.value = data.telepon
            email.value = data.email
            $('#role').val(data.role).trigger('change');

            

            form.action = `/pengguna/${data.id}`
        }
    </script>
</x-layout>


