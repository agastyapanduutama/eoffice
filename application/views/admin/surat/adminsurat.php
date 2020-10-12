<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <div class="card-header-form">
           
        </div>
    </div>
</div>

<input type="hidden" id="tipena" value="<?= $this->uri->segment(4, 0) ?>">

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="list_surat" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Surat</th>    
                        <th>Tanggal Dibuat</th>
                        <th>Asal Surat</th>
                        <th>Jenis Surat</th>
                        <th>Aksi Surat</th>
                        <th>Perihal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>

            </table>
        </div>
    </div>

</div>
</div>




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalConfirm">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tindakan Surat Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- pindah kadieu/ -->
            <!-- form start -->
            <form id="formTindakanInternal">
                <div class="modal-body">
                    
                    <!-- <input type="" name="id_user" value="<?= $this->session->userdata('id_user');?>" id="id_user" class="form-control"> -->
                    <!-- <input type="" name="id_upk" value="<?= $this->session->userdata('upk');?>" id="id_uPK" class="form-control"> -->
                    <input type="hidden" name="status_suratmasuk" value="1" id="status_surat" class="form-control">
                    <input type="hidden" id="idData" name="id">

                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="no_surat" id="no_surat" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Dibuatnya Surat</label>
                        <input type="date" name="" id="tanggalDibuat" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" value="<?= date('Y-m-d') ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Asal Surat</label>
                        <input type="text" class="form-control" id="asal_surat" readonly name="asal_surat">
                    </div>

                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <input type="text" class="form-control" id="jenisSurat" readonly="" name="jenis_surat">
                    </div>

                    <div class="form-group">
                        <label>Sifat Surat</label>
                        <select readonly name="sifat_surat" id="sifatSurat" class="form-control"></select>
                    </div>

                    <div class="form-group">
                        <label>Harus Disposisi</label>
                        <select name="disposisi" id="disposisi" class="form-control">
                            <option value="" selected disabled>-- Pilih --</option>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <!-- Kalau Tidak -->
                    <div class="form-group" id="alamat-tujuan"></div>
                    <input type="hidden" name="aksi_kirim"  class="form-control" id="valTujuan">

                    <!-- Kalau Iya -->
                    <div class="form-group" id="alamat-aksi"></div>

                 

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            <!-- form end -->


        </div>
    </div>
</div>


<div class="modal fade modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="modalLihat">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lampiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddStatus">
                <div class="modal-body">
                    <div class="row" id="lampiranNa">

                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
