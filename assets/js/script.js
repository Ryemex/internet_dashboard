// Fungsi untuk konfirmasi sebelum menghapus
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus data ini?');
}

// Fungsi untuk memvalidasi form
function validateForm(form) {
    let valid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valid = false;
            input.style.borderColor = 'red';
        } else {
            input.style.borderColor = '#ddd';
        }
    });
    
    if (!valid) {
        alert('Harap isi semua field yang wajib diisi!');
    }
    
    return valid;
}

// Event listener untuk form validasi
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
});
