// Auto-hide alerts after 4 seconds
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide success alerts
    const successAlerts = document.querySelectorAll('.alert-success');
    successAlerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 4000);
    });

    // Close alert on close button click
    const closeButtons = document.querySelectorAll('.btn-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    });

    // Smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Delete Modal Functionality
let currentDeleteId = null;

function showDeleteModal(userId, userName) {
    currentDeleteId = userId;
    document.getElementById('deleteUserName').textContent = userName;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if (currentDeleteId) {
                const form = document.getElementById('deleteForm-' + currentDeleteId);
                if (form) {
                    form.submit();
                }
            }
        });
    }
});

// Image Preview Functionality
function setupImagePreview(inputId, previewId, fileNameId) {
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById(previewId);
        const fileName = document.getElementById(fileNameId);

        if (file) {
            // Validate file type
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG)');
                this.value = '';
                return;
            }

            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must not exceed 5MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                preview.innerHTML = `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
            fileName.textContent = file.name;
        }
    });
}

// Expose function globally for inline event handlers
window.showDeleteModal = showDeleteModal;
window.setupImagePreview = setupImagePreview;

