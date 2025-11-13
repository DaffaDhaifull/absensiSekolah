<x-layout judul="SD Bina Insan Cendikia">
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">
                @auth
                  Selamat Datang, {{ ucfirst(auth()->user()->role ?? 'Guru' )}}! 
                @endauth
              </h5>
              <p class="mb-4">
                Pantau aktivitas kehadiran dengan cepat dan akurat.
              </p>
              <a href="/absensi" class="btn btn-sm btn-outline-primary">Lihat lengkap</a>
            </div>
            
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img
                src="../assets/img/illustrations/man-with-laptop-light.png"
                height="140"
                alt="View Badge User"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  

  <div class="row mt-2">
      <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-info">
                    <i class="bx bx-user"></i>
                  </span>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="/pengguna">Lihat Lengkap</a>
                  </div>
                </div>
              </div>
              <span>Total Pengguna</span>
              <h3 class="card-title text-nowrap mb-1">{{$totalPengguna}}</h3>
            </div>
          </div>
      </div>
      
      <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-success">
                    <i class="bx bx-group"></i>
                  </span>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="/siswa">Lihat Lengkap</a>
                  </div>
                </div>
              </div>
              <span>Total Siswa</span>
              <h3 class="card-title text-nowrap mb-1">{{ $totalSiswa}}</h3>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-warning">
                    <i class="bx bx-door-open"></i>
                  </span>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="/kelas">Lihat Lengkap</a>
                  </div>
                </div>
              </div>
              <span>Total Kelas</span>
              <h3 class="card-title text-nowrap mb-1">{{$totalKelas}}</h3>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0 me-3">
                  <span class="avatar-initial rounded bg-label-primary">
                    <i class="bx bx-calendar-check"></i>
                  </span>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="/absensi">Lihat Lengkap</a>
                  </div>
                </div>
              </div>
              <span>Total Siswa hadir</span>
              <div class="d-flex gap-2">
                <h3 class="card-title text-nowrap mb-1">{{$totalHadir}}</h3>
                <small class="text-info fw-semibold mt-2">{{$persentaseHadir}}%</small>
              </div>
            </div>
          </div>
      </div>
  </div>
</x-layout>