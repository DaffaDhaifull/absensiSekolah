 $('.select2').select2();

$('#jk').select2({
dropdownParent: $('#idsiswas'),
  minimumResultsForSearch: Infinity, // ini akan menyembunyikan kotak search
  templateResult: function (data) {
        // Cek apakah option memiliki atribut hidden
        if ($(data.element).attr('hidden')) {
            return null; // tidak ditampilkan di dropdown
        }
        return data.text; // tampilkan normal
    }
});

$('#jk_t_siswa').select2({
    dropdownParent: $('#tsiswa'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#kelas_t_siswa').select2({
    dropdownParent: $('#tsiswa'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#kelas').select2({
    dropdownParent: $('#idsiswas'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#ortu_t_siswa').select2({
    dropdownParent: $('#tsiswa'),
    minimumResultsForSearch: 0,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#wali_kelas').select2({
    dropdownParent: $('#idkelas'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#wali_u_kelas').select2({
    dropdownParent: $('#idkelase'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#ortu').select2({
    dropdownParent: $('#idsiswas'),
    minimumResultsForSearch: 0,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#role_t_pengguna').select2({
    dropdownParent: $('#idpengguna'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#role').select2({
    dropdownParent: $('#idpenggunad'),
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#kelas_ab').select2({
    dropdownParent: $('#kelas_ab').closest('.card'), // dropdown akan "melekat" ke card
    width: '100%',
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});

$('#kls-lap').select2({ 
    minimumResultsForSearch: Infinity,
    templateResult: function (data) {
        if ($(data.element).attr('hidden')) {
            return null; 
        }
        return data.text; 
    }
});
