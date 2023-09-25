  
  <!-- Modal -->
  <div class="modal fade" id="pembayaranModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {!! Form::open(['method' => 'post', 'route' => ['keranjang.prosesPembayaran'], 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="form-label">Invoice</label>
                        <input type="text" name="kode_invoice" id="kodeInvoice" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Total Invoice</label>
                        <h5 id="totalInvoice"></h5>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="form-control">
                        <i>Format: JPG, JPEG, PNG</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Bayar</button>
        {!! Form::close() !!}
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>