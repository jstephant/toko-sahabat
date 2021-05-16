<script>
    $(document).ready(function () {
        $('#modal-confirm-delete').on('show.bs.modal', function (e) {
            var id = $(e.relatedTarget).data('id');
            var url = $(e.relatedTarget).data('link');
            $('#form-confirm-delete').attr('action', url + '/' + id);
            $('#id').val(id);
        });
    });
</script>
