@if (session('success') || session('error') || session('warning') || session('info') || session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Toast !== 'undefined') {
                @if (session('success'))
                    window.Toast.fire({
                        icon: 'success',
                        title: "{{ session('success') }}"
                    });
                @endif

                @if (session('error'))
                    window.Toast.fire({
                        icon: 'error',
                        title: "{{ session('error') }}"
                    });
                @endif

                @if (session('warning'))
                    window.Toast.fire({
                        icon: 'warning',
                        title: "{{ session('warning') }}"
                    });
                @endif

                @if (session('info'))
                    window.Toast.fire({
                        icon: 'info',
                        title: "{{ session('info') }}"
                    });
                @endif

                @if (session('status'))
                    window.Toast.fire({
                        icon: 'info',
                        title: "{{ session('status') }}"
                    });
                @endif
            }
        });
    </script>
@endif
