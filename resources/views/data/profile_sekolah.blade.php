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
    <div class="row">
        <div class="col-md-12">
            <form action="/profile" method="POST" enctype="multipart/form-data">@csrf
                <div class="card mb-4">
                <h5 class="card-header">Data Lengkap Sekolah</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <img src="{{ asset('assets/img/logo/' . $school->logo) }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
                    <div class="button-wrapper">
                        <label for="upload" class="btn btn-primary me-2 mb-4 mt-4" tabindex="0">
                            <span class="d-none d-sm-block">Unggah foto baru</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input type="file" id="upload" name="logo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                        </label>
                    </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nama Sekolah</label>
                                <input class="form-control" type="text" name="namaSekolah" value="{{ $school->namaSekolah ?? ''}}" autofocus/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Nama singkat</label>
                                <input class="form-control" type="text" name="namaSingkat" value="{{$school->namaSingkat ?? ''}}"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Nomor Pokok Sekolah Nasional (NPSN)</label>
                                <input type="text" name="NPSN" class="form-control" value="{{$school->NPSN ?? ''}}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Kepala Sekolah</label>
                                <input class="form-control" type="text" name="kepalaSekolah" value="{{$school->kepalaSekolah ?? ''}}"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Bentuk Pendidikan / Jenjang</label>
                                <input type="text" name="jenjang" class="form-control" value="{{$school->jenjang ?? ''}}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Status</label>
                                <input class="form-control" type="text" id="email" name="status" value="{{$school->status ??''}}"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phoneNumber">Telepon Sekolah</label>
                                <input type="text" name="telepon" class="form-control" value="{{$school->telepon ?? ''}}" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" name="email" value="{{$school->email ?? ''}}" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="firstName" class="form-label">Alamat Sekolah</label>
                                <textarea class="form-control" name="alamat" aria-label="With textarea">{{$school->alamat ?? ''}}</textarea>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan perubahan </button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </div>
                </div> 
            </div>
            </form>
        </div>
    </div>

</x-layout>