<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <div class="card-header-form">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Buat Surat Masuk Internal</button>
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
                        <th>Jenis Surat</th>
                        <th>Perihal</th>	
                        <th>Aksi Surat</th>    
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Surat Masuk (<?= $this->session->nama_user?>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <form id="formAddSurat">
                <div class="modal-body">

                    <!-- <input type="" name="jenis_kirim" value="1" id="jenis_kirim" class="form-control"> -->
                    <input type="hidden" name="id_user" value="<?= $this->session->userdata('id_user'); ?>" id="id_user" class="form-control">
                    <input type="hidden" name="id_upk" value="<?= $this->session->userdata('upk'); ?>" id="id_uPK" class="form-control">
                    <input type="hidden" name="status_suratmasuk" value="1" id="status_surat" class="form-control">
                    <input type="hidden" name="internal" value="1">

                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" name="no_surat" id="no_surat" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Dibuat</label>
                        <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" value="<?= date('Y-m-d') ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Asal Surat</label>
                        <input type="text" class="form-control" name="asal_surat" id="asal_surat" value="asdasd" readonly>
                        <!-- <select class="form-control" name="asal_surat" onchange="asalna()" id="asal_surat">
                        </select> -->
                    </div>

                    <div class="form-group" id="asalnasurat">
                    </div>

                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <select name="jenis_surat" id="id_jenis" class="form-control"></select>
                    </div>

                    <div class="form-group">
                        <label>Sifat Surat</label>
                        <select name="sifat_surat" id="id_sifat" class="form-control"></select>
                    </div>

                    <input type="hidden" name="tujuan_kirim" id="tujuan_kirim">
                    <input type="hidden" name="aksi_kirim" value="">

                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="file" name="lampiran[]" multiple="multiple" id="inputGroupFile01" required>
                    </div>

                    <div class="form-group">
                        <label>Perihal</label>
                        <textarea name="perihal" id="perihal" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <div style="display: none;" class="form-group">
                        <label>Isi Surat</label>
                        <textarea name="isi_surat" id="isi_surat" class="form-control" cols="30" rows="10"></textarea>
                    </div>

                    <label id="persenUpload"></label>
                    <div class="progress" data-height="3" style="height: 3px;">
                        <div class="progress-bar" id="progressNa" role="progressbar" data-width="0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>

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
