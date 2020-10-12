<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <div class="card-header-form">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Tambah
                Data</button>
        </div>
    </div>

    <div class="card-header">
        <select name="list_upk" id="filter_upk" class="form-control">
        </select>
    </div>
</div>

<div class="card">

    <!-- multiple select (wajib)-->
    <div class="card-header">
        <h4 id="denganData">Dengan data terpilih</h4>
        <div class="card-header-form">
            <button class="btn btn-success" id="btnAllOn"> <i class='fas fa-toggle-on'></i> ON</button>
            <button class="btn btn-danger" id="btnAllOff"> <i class='fas fa-toggle-off'></i> OFF</button>
            <button class="btn btn-danger" id="btnAllHapus"> <i class='fas fa-trash'></i> Hapus</button>
        </div>
    </div>
    <input type="hidden" id="dipilih">
    <!-- multiple select (wajib)-->

    <div class="card-body">
        <div class="table-responsive">
            <table id="list_pegawai" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th><input id="checkAll" type="checkbox"></th>
                        <th>No</th>
                        <!-- <th>Kode Pegawai</th> -->
                        <!-- <th>Gelar Depan</th> -->
                        <th>Nama Pegawai</th>
                        <!-- <th>Gelar Belakang</th> -->
                        <!-- <th>Nama Pengguna</th> -->
                        <th>Email</th>
                        <th>NIY</th>
                        <th>UPK</th>
                        <th>Jabatan</th>
                        <!-- <th>Satuan</th> -->
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
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
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddPegawai">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Gelar Depan</label>
                        <input type="text" name="gelar_depan" id="gelar_depan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama_user" id="nama_user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="Email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>NIY</label>
                        <input type="number" name="niy" id="niy" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>UPK</label>
                        <select name="id_upk" class="form-control" id="id_upk"></select>
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
                <h5 class="modal-title">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditPegawai">
                <div class="modal-body">
                    <input type="hidden" name="id" id="idData">
                    <!-- <div class="form-group">
                        <label>Kode Pegawai</label>
                        <input type="number" name="kode_pegawai" id="kode_pegawai1" class="form-control" required>
                    </div> -->

                    <div class="form-group">
                        <label>Gelar Depan</label>
                        <input type="text" name="gelar_depan" id="gelar_depan1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Pegawai</label>
                        <input type="text" name="nama_user" id="nama_user1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gelar Belakang</label>
                        <input type="text" name="gelar_belakang" id="gelar_belakang1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="Email" name="email" id="email1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>NIY</label>
                        <input type="number" name="niy" id="niy1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>UPK</label>
                        <select name="id_upk" class="form-control" id="id_upk1"></select>
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