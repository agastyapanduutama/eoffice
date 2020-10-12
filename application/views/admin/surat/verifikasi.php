    <div class="card">
        <div class="card-header">
            <h4><?= $title ?></h4>
            <div class="card-header-form">

            </div>
        </div>
    </div>

    <style>
        tr {
            cursor: pointer;
        }
    </style>

    <input type="hidden" id="tipena" value="<?= $this->uri->segment(3, 0)?>" name="">

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <!-- <table id="list_surat" class="table table-striped table-bordered" style="width:100%"> -->
                <table id="list_verifikasi" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Dibuat</th>
                            <th>Asal Surat</th>
                            <th>Jenis Surat</th>
                            <th>Sifat Surat</th>
                            <th>Perihal</th>
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
                        <input type="hidden" name="uri" value="<?= $this->uri->segment(3, 0)?>" >
                        <input type="hidden" name="id_surat" id="idData">
                        <input type="hidden" name="userNa" id="userBuat">
                        <input type="hidden" name="notifNa" id="notif">
                        <!-- <input type="hidden" name="id_user" value="<?= $this->session->userdata('id_user'); ?>"> -->

                        <div class="form-group">
                            <label>No Surat</label>
                            <input type="text" value="" readonly id="no_surat" class="form-control" name="no_surat">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Dibuat</label>
                            <input type="date" readonly value="" id="tanggal_dibuat" class="form-control" name="tanggal_dibuat">
                        </div>

                        <div class="form-group">
                            <label>Asal Surat</label>
                            <input type="text" readonly value="" id="asal_surat" class="form-control" name="asal_surat">
                        </div>

                        <div class="form-group">
                            <label>Jenis Surat</label>
                            <input type="text" readonly value="" id="jenis_surat" class="form-control" name="jenis_surat">
                        </div>

                        <div class="form-group">
                            <label>Sifat Surat</label>
                            <input type="text" class="form-control" id="sifat_surat" name="sifat_surat" readonly="">
                        </div>

                        <div class="form-group">
                            <label>Perihal</label>
                            <textarea name="perihal" readonly="" id="perihal" class="form-control" cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group ">
                            <label>Isi Surat/Catatan</label>
                            <p id="tampilIsi" class=""></p>
                        </div>

                        <div id="catatanSurat"></div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" id="status" name="status" onchange="statusRevisi()">
                                <option value="1">ACC</option>
                                <option value="0">Tidak di ACC</option>
                            </select>
                        </div>

                        <div class="form-group" id="statusRevisiNa">
                        </div>

                        <div class="form-group" id="catatanRevisiNa">
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
    <form id="formAddStatus">
        <div class="modal-body">
            <div class="row" id="lampiranNa">

            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
        </div>
    </form>
    </div>
    </div>
    </div>