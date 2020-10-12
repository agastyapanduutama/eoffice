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
            <table id="list_jabatan" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th><input id="checkAll" type="checkbox"></th>
                        <th>No</th>
                        <th>Kode Jabatan</th>
                        <th>Nama Jabatan</th>
                        <th>Parent</th>
                        <th>Level</th>
                        <th>Keterangan</th>
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
                <h5 class="modal-title">Tambah Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddJabatan">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Jabatan</label>
                        <input type="text" name="kode_jabatan" id="kode_jabatan" class="form-control" required>
                    </div>


                    <?php if ($this->session->userdata('level') != '1') : ?>
                        <input type="hidden" name="id_upk" value="<?= $this->session->userdata('upk') ?>" id="id_upk" class="form-control" required>
                    <?php endif ?>

                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Parent</label>
                        <select name="parent" id="parent" class="form-control" required>
                            <!-- <option value="1">awdwad</option> -->
                        </select>
                    </div>

                    <?php if ($this->session->userdata('level') == '1') : ?>
                        <div class="form-group">
                            <label>Grup UPK</label>
                            <select name="id_upk" id="upkna" class="form-control" required>
                                <!-- <option value="1">awdwad</option> -->
                            </select>
                        </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
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
                <h5 class="modal-title">Tambah Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditJabatan">
                <div class="modal-body">

                    <?php if ($this->session->userdata('level') != '1') : ?>
                        <input type="hidden" name="id" id="idData">
                    <?php endif ?>
                        <input type="hidden" name="id" id="idData">

                    <div class="form-group">
                        <label>Kode Jabatan</label>
                        <input type="text" name="kode_jabatan" id="kode_jabatan1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Parent</label>
                        <select name="parent" id="parent1" class="form-control" required></select>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select name="level" id="level1" class="form-control" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
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