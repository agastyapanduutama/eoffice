 <div class="card">
        <div class="card-header">
            <h4> <?= $title ?></h4>
            <div class="card-header-form float-right">
            </div>

        </div>
    </div>


<input type="hidden" id="tipena" value="<?= $this->uri->segment(3, 0) ?>">


    <style>
        tr {
            cursor: pointer;
        }
    </style>
   
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <!-- <table id="list_surat" class="table table-striped table-bordered" style="width:100%"> -->
                <table id="list_arsipkeluar" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Surat</th>
                            <th>Tanggal Dibuat</th>
                            <th>Asal Surat</th>
                            <th>Jenis Surat</th>
                            <th>Sifat Surat</th>
                            <th>Perihal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>
            </div>

            <div id="jstree">
            </div>
            <p>Selected items:</p>
            <ul id="output">
            </ul>
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

