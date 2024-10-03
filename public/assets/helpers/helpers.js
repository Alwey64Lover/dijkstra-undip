// After all Load
document.addEventListener('DOMContentLoaded', function () {
    // Notification Session
        var successMessage = document.querySelector('meta[name="session-success"]')?.content;
        var errorMessage = document.querySelector('meta[name="session-error"]')?.content;
        var errorMessages = [...document.querySelectorAll('meta[name="session-errors[]"]')].map(meta => meta.content);

        if (successMessage) {
            toast(successMessage, 'success');
        }

        if (errorMessage) {
            toast(errorMessage, 'error');
        }

        if (errorMessages.length > 0) {
            errorMessages.forEach(function (error) {
                toast(error, 'error');
            });
        }

    // Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle-tooltip="tooltip"]'))

        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
});

// Toastify
    function toast(text, type){
        let backgroundColor = '#28ab55';

        if(type === 'error'){
            backgroundColor = '#dc3545';
        }

        Toastify({
            text: text,
            duration: 3000,
            close: true,
            backgroundColor: backgroundColor,
        }).showToast()
    }

// Form element
    // password
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");

            input = $('#'+$(this).attr('data-id'));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

// Modal
    // Delete
        function modalDelete(route) {
            $('#modal_delete form').attr('action', route)
        }

// Table
    // Datatable
        // $("#table").DataTable({
        //     responsive: false,
        // })

// Filepond
    let ponds = $('.image-preview-filepond')

    ponds.each(function (pond) {
        let pondId = $(pond).attr('id');

        FilePond.create(document.querySelector("#"+pondId), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            labelIdle: `
                Drag & Drop your files or <span class="filepond--label-action" tabindex="0">Browse</span>
            `,

            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                resolve(type)
            }),

            storeAsFile: true,
        })
    })
