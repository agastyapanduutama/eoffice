<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <div class="card-header-form">

            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Tambah
                Data</button>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-header">
        <h4 id="denganData">Dengan data terpilih</h4>
        <div class="card-header-form">
            <button class="btn btn-success" id="btnAllOn"> <i class='fas fa-toggle-on'></i> ON</button>
            <button class="btn btn-danger" id="btnAllOff"> <i class='fas fa-toggle-off'></i> OFF</button>
            <button class="btn btn-danger" id="btnAllHapus"> <i class='fas fa-trash'></i> Hapus</button>
        </div>
    </div>
    <input type="hidden" id="dipilih">

    <div class="card-body">
        <div class="table-responsive">
            <table id="list_sifat" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th><input id="checkAll" type="checkbox"></th>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Sifat Surat</th>
                        <th>Keterangan</th>
                        <th>Warna</th>
                        <th>Status</th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sifat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddSifat">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Sifat</label>
                        <input type="text" name="kode_sifat" id="kode_sifat" class="form-control" required>
                    </div>

                    <input type="hidden" name="id_upk" value="<?= $this->session->userdata('upk') ?>" id="id_upk" class="form-control" required>

                    <div class="form-group">
                        <label>Nama Sifat Surat</label>
                        <input type="text" name="sifat" id="sifat" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modalEdit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sifat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditSifat">
                <div class="modal-body">
                    <input type="hidden" name="id" id="idData">
                    <div class="form-group">
                        <label>Kode Sifat</label>
                        <input type="text" name="kode_sifat" id="kode_sifat1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Sifat Surat</label>
                        <input type="text" name="sifat" id="sifat1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan1" class="form-control">
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>