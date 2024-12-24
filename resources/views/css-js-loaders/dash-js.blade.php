<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/dashboard-js.js') }}"></script>
<script type="text/javascript">
    function setItemType() {
        if ($('select[name="type"]').val() == 'divider') {
            $('#divider_fields').removeClass('d-none');
            $('#item_fields').addClass('d-none');
        } else {
            $('#divider_fields').addClass('d-none');
            $('#item_fields').removeClass('d-none');
        }
    };
    setItemType();
    $('input[name="type"]').change(setItemType);
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
