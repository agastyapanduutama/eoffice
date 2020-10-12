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
            <table id="list_adminsurat" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th><input id="checkAll" type="checkbox"></th>
                        <th>No</th>
                        <!-- <th>Kode Staf</th> -->
                        <th>Gelar Depan</th>
                        <th>Nama Staf</th>
                        <th>Gelar Belakang</th>
                        <!-- <th>Nama Pengguna</th> -->
                        <th>Email</th>
                        <th>Jabatan</th>
                        <!-- <th>Satuan</th> -->
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
                <h5 class="modal-title">Tambah Admin Persuratan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddAdminSurat">
                <div class="modal-body">

                    <input type="hidden" name="id_upk" id="id_upk" value="<?= $this->session->userdata('upk') ?>" class="form-control" required>
                    <div class="form-group">
                        <label>Gelar Depan</label>
                        <input type="text" name="gelar_depan" id="gelar_depan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Staf</label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email Pengguna</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="id_jabatan" class="form-control" id="id_jabatan"></select>
                    </div>
                    <input type="hidden" name="level" value="3" id="level" class="form-control" required>

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
                <h5 class="modal-title">Edit Admin Persuratan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditAdminSurat">
                <div class="modal-body">
                    <input type="hidden" name="id" id="idData">
                    <!-- <div class="form-group">
                        <label>Kode Staf</label>
                        <input type="number" name="kode_staf" id="kode_staf1" class="form-control" required>
                    </div> -->

                    <div class="form-group">
                        <label>Gelar Depan</label>
                        <input type="text" name="gelar_depan" id="gelar_depan1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Staf</label>
                        <input type="text" name="nama_user" id="nama_user1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" id="gelar_belakang1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email Pengguna</label>
                        <input type="text" name="email" id="email1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="id_jabatan" class="form-control" id="id_jabatan1"></select>
                    </div>

                    <!-- <div class="form-group">
                        <label>Satuan</label>
                        <select name="id_satuan" id="id_satuan"></select>
                    </div> -->

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>