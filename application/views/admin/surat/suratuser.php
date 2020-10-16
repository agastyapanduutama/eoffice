<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <div class="card-header-form">
            <!-- <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Buat <?= $title ?></button> -->
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
                        <th>Tanggal Surat</th>
                        <th>Asal Surat</th>
                        <th>Jenis Surat</th>
                        <th>Disposisi</th>
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

<div class="modal fade modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="modalKirimUlang">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Balasan Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddTindakanInternal">
                <div class="modal-body">

                    <!-- disposisi -->
                    <input type="" value="" id="disposisiNa" name="disposisi">
                    <!-- jabatan terkait -->
                    <input type="" value="" id="jabatanTerkait" name="jabatan_terkait">
                    <!-- id surat -->
                    <input type="" id="idSurat" name="id_surat">
                    <!-- id user  -->
                    <input type="" value="<?= $this->session->userdata('id_user'); ?>" id="" name="id_user">
                    <!-- id jabatan user -->
                    <input type="" value="<?= $this->session->userdata('jabatan'); ?>" id="idUserJabatan" name="id_user_jabatan">
                    <!-- id tujuan -->
                    <input type="" id="userTujuan" name="user_tujuan">

                    <div class="form-group">
                        <label>Perihal</label>
                        <p id="perihalNa"></p>
                    </div>

                    <div class="form-group">
                        <label>Aksi</label>
                        <select class="form-control" name="aksi" id="id_aksi">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Lampiran</label>
                        <input type="file" class="form-control" name="lampiran">
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" id="catatan" class="summernote" cols="30" rows="10"></textarea>
                        <textarea style="display:none;" name="catatan" id="catatanNa"></textarea>
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

<div class="modal fade modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalConfirm">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAddTindakan">
                <div class="modal-body">

                    <input type="hidden" name="id_surat" id="idData">
                    <input type="hidden" name="id_user" value="<?= $this->session->userdata('id_user'); ?>">

                    <div class="form-group" id="alamat-aksi">
                        <label>Disposisi Ke</label>
                        <input type='text' name='' id='aksiNa' required>
                    </div>

                    <input type="" value="" name="user_tujuan" class="form-control" id="valAksi">

                    <input type="" id="akiKirimNa">
                    <input type="" id="userTerkait">
                    <input type="" name="jabatan_terkait" id="totalAksi">

                    <div class="form-group">
                        <label>Tanggal Disposisi</label>
                        <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="tgl_disposisi">
                    </div>

                    <div class="form-group">
                        <label>Aksi</label>
                        <select class="form-control" name="aksi" id="id_aksi_disposisi">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Isi Disposisi / Intruksi</label>
                        <textarea name="isi_disposisi" id="isi_disposisi" class="summernote" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea id="catatan1" class="summernote" cols="30" rows="10"></textarea>
                        <textarea style="display:none;" name="catatan" id="catatan1Na"></textarea>
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