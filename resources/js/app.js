import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

// Configure Toast Alert defaults
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

window.Toast = Toast;

// Modern Delete Confirmation Dialog
window.confirmDelete = function (formOrEvent, options = {}) {
    let form = formOrEvent;
    if (formOrEvent && formOrEvent.preventDefault) {
        formOrEvent.preventDefault();
        form = formOrEvent.target;
    }

    const message = options.message || (form && form.dataset ? form.dataset.confirmMessage : null) || 'Are you sure you want to delete this item? This action cannot be undone.';
    const title = options.title || (form && form.dataset ? form.dataset.confirmTitle : null) || 'Delete Confirmation';
    const confirmButtonText = options.confirmButtonText || 'Yes, Delete';
    const cancelButtonText = options.cancelButtonText || 'Cancel';

    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl shadow-xl border border-gray-100 p-6',
            title: 'text-xl font-bold text-gray-800',
            htmlContainer: 'text-sm text-gray-600 mt-2',
            confirmButton: 'px-5 py-2.5 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-medium rounded-xl text-sm transition shadow-sm ml-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2',
            cancelButton: 'px-5 py-2.5 bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 font-medium rounded-xl text-sm transition focus:outline-none focus:ring-2 focus:ring-slate-300'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed && form && typeof form.submit === 'function') {
            form.submit();
        }
    });

    return false;
};

// Auto-attach delete confirmation to forms with data-confirm-delete or .delete-form class
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (form.matches('.delete-form, [data-confirm-delete]')) {
        if (!form.dataset.confirmed) {
            e.preventDefault();
            window.confirmDelete(form);
        }
    }
});

Alpine.start();

