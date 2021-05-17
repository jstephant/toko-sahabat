<div class="modal fade" id="modal-confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
            <div class="modal-header justify-content-center bg-danger">
                <h5 id="title" class="modal-title text-white text-uppercase">Konfirmasi</h5>
            </div>
            <div class="modal-body justify-content-center">
                <div id="data_loader" class="row">
                    <div class="col-md-12">
                        <div class="justify-content-center text-center">
                            <div class="spinner-border text-primary " role="status" ></div>
                        </div>
                    </div>
                </div>
                <div class="row align-content-center">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <p class="text-center">Data akan dihapus. Apakah Anda yakin?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <form action="#" method="POST" enctype="multipart/form-data" id="form-confirm-delete">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="link" name="link">
                    <button type="button" class="btn btn-link btn-sm" data-dismiss="modal" id="btn_close">Tidak</button>
                    <button type="submit" class="btn btn-danger btn-sm" id="btn_delete" name="btn_delete">Hapus</button>
                </form>
            </div>
		</div>
	</div>
</div>

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
