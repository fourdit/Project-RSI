// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Profile photo click handler
document.addEventListener('DOMContentLoaded', function() {
    const photoLabel = document.querySelector('.change-photo-label');
    if (photoLabel) {
        photoLabel.addEventListener('click', function() {
            document.getElementById('profile_photo').click();
        });
    }
});

// Confirmation before delete
function confirmDelete(message) {
    return confirm(message || 'Apakah Anda yakin ingin menghapus?');
}

// Format number as currency
function formatCurrency(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

// Prevent form double submission
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Memproses...';
            }
        });
    });
});