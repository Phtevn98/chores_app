<!-- FOOTER LOADED -->
<!-- Bootstrap 5 JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM loaded — trying to init dropdowns');
        if (typeof bootstrap !== 'undefined' && typeof bootstrap.Dropdown !== 'undefined') {
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function (el) {
                new bootstrap.Dropdown(el);
            });
        } else {
            console.warn('Bootstrap namespace not found');
        }
    });
</script>
</body>
</html>
