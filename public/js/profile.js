/**
 * Profile Edit Form Modal Logic
 * Includes real-time input validation for numeric/text-only fields.
 */
document.addEventListener('DOMContentLoaded', function() {
    const editBtns = document.querySelectorAll('.btn-edit-profile');
    const editModalEl = document.getElementById('editProfileModal');
    if (!editModalEl) return;
    
    const editModal = new bootstrap.Modal(editModalEl);
    const modalBody = document.getElementById('modalFormBody');
    const originalTabs = document.getElementById('profileTabsContent');

    editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Clear modal body
            modalBody.innerHTML = '';
            
            // Find the closest tab pane to the button clicked
            const activeTabPane = btn.closest('.tab-pane');
            if (!activeTabPane) return;

            // Clone only the active tab pane
            const clonedPane = activeTabPane.cloneNode(true);
            clonedPane.removeAttribute('id');
            
            // Convert tab pane to normal stacked div so it shows properly
            clonedPane.classList.remove('tab-pane', 'fade', 'show', 'active');
            clonedPane.classList.add('mb-0');

            // Remove readonly and disabled restrictions, change bg
            const editableFields = clonedPane.querySelectorAll('.editable-field');
            editableFields.forEach(field => {
                field.removeAttribute('readonly');
                field.removeAttribute('disabled');
                field.classList.remove('bg-light');
                field.classList.add('bg-white', 'border');
            });

            // Show field hints in the clone
            const hints = clonedPane.querySelectorAll('.field-hint');
            hints.forEach(h => h.classList.remove('d-none'));

            // Hide all "Editar Perfil" buttons in the clone
            const buttons = clonedPane.querySelectorAll('.btn-edit-profile');
            buttons.forEach(b => b.remove());

            // Remove any nested modals to avoid ID conflicts (e.g., modalFamilia)
            const nestedModals = clonedPane.querySelectorAll('.modal');
            nestedModals.forEach(m => m.remove());

            modalBody.appendChild(clonedPane);

            // --- Apply real-time input validation ---
            applyInputRestrictions(clonedPane);

            // Ensure 'email' is submitted if not present in the cloned pane (required by Laravel validation)
            if (!clonedPane.querySelector('input[name="email"]')) {
                const mainEmailInput = document.querySelector('input[name="email"]');
                if (mainEmailInput) {
                    const hiddenEmail = document.createElement('input');
                    hiddenEmail.type = 'hidden';
                    hiddenEmail.name = 'email';
                    hiddenEmail.value = mainEmailInput.value;
                    modalBody.appendChild(hiddenEmail);
                }
            }
            
            // Show the modal
            editModal.show();
        });
    });

    /**
     * Apply real-time input restrictions inside the given container.
     * Uses data attributes: data-only-digits, data-only-letters
     */
    function applyInputRestrictions(container) {
        // --- Only digits (DNI, phone, RUC, etc.) ---
        const digitFields = container.querySelectorAll('[data-only-digits]');
        digitFields.forEach(field => {
            field.addEventListener('input', function() {
                const original = this.value;
                this.value = this.value.replace(/[^0-9]/g, '');
                if (original !== this.value) {
                    showFieldWarning(this, 'Este campo solo acepta números');
                }
            });

            field.addEventListener('paste', function(e) {
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                if (/[^0-9]/.test(paste)) {
                    e.preventDefault();
                    showFieldWarning(this, 'No se pueden pegar caracteres no numéricos');
                }
            });

            // Block non-digit keys at the keydown level
            field.addEventListener('keydown', function(e) {
                // Allow control keys: backspace, delete, tab, arrows, home, end
                const allowedKeys = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
                if (allowedKeys.includes(e.key)) return;
                // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                if (e.ctrlKey && ['a','c','v','x'].includes(e.key.toLowerCase())) return;
                // Block anything that is not a digit
                if (!/^[0-9]$/.test(e.key)) {
                    e.preventDefault();
                    showFieldWarning(this, 'Solo se permiten dígitos numéricos');
                }
            });
        });

        // --- Only letters and spaces (names, surnames) ---
        const letterFields = container.querySelectorAll('[data-only-letters]');
        letterFields.forEach(field => {
            field.addEventListener('input', function() {
                const original = this.value;
                this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/g, '');
                if (original !== this.value) {
                    showFieldWarning(this, 'Este campo solo acepta letras y espacios');
                }
            });

            field.addEventListener('paste', function(e) {
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                if (/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]/.test(paste)) {
                    e.preventDefault();
                    showFieldWarning(this, 'No se pueden pegar números ni caracteres especiales aquí');
                }
            });
        });
    }

    /**
     * Show a brief inline warning below a field.
     * Auto-hides after 3 seconds.
     */
    function showFieldWarning(field, message) {
        // Check if a warning already exists for this field
        let existing = field.parentElement.querySelector('.inline-field-warning');
        if (existing) {
            existing.textContent = message;
            // Reset animation
            existing.style.animation = 'none';
            existing.offsetHeight; // trigger reflow
            existing.style.animation = '';
            return;
        }

        const warning = document.createElement('div');
        warning.className = 'inline-field-warning text-danger small mt-1';
        warning.style.cssText = 'animation: fadeIn 0.2s ease; font-weight: 500;';
        warning.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>' + message;
        
        // Insert after the field (or after the input-group if inside one)
        const parent = field.closest('.input-group') || field;
        parent.parentElement.insertBefore(warning, parent.nextSibling);

        // Apply red border temporarily
        field.classList.add('border-danger');

        setTimeout(() => {
            warning.remove();
            field.classList.remove('border-danger');
        }, 3000);
    }
});
