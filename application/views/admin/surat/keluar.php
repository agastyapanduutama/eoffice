 <div class="card">
     <div class="card-header">
         <h4> <?= $title ?></h4>
         <div class="card-header-form float-right">
             <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modalTambah">Buat <?= $title ?></button>
         </div>

     </div>
 </div>

 <style>
     tr {
         cursor: pointer;
     }
 </style>
 <div class="card">
     <div class="card-body">
         <div class="form-group-sm">
             <label>Status Pengiriman</label>
             <select class="form-control" id="statusPengiriman">
                 <option value="3">Semua</option>
                 <option value="1">Diproses / Belum di Verifikasi</option>
                 <option value="2">Dikembalikan / Revisi</option>
                 <option value="4">Ditolak</option>
                 <option value="0">Selesai</option>
             </select>
         </div>
     </div>
 </div>
 <div class="card">
     <div class="card-body">
         <div class="table-responsive">
             <!-- <table id="list_surat" class="table table-striped table-bordered" style="width:100%"> -->
             <table id="list_surat" class="table table-striped table-bordered" style="width:100%">
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

         <div id="jstree">
         </div>
         <p>Selected items:</p>
         <ul id="output">
         </ul>
     </div>
 </div>
 </div>


 <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalTambah">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Buat Surat Keluar</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <!-- pindah kadieu/ -->
             <!-- form start -->
             <form id="formAddSurat">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Nomor Surat</label>
                         <input type="text" name="no_surat" id="no_surat" class="form-control" readonly>
                     </div>

                     <div class="form-group">
                         <label>Tanggal Dibuat</label>
                         <input type="date" name="tanggal_dibuat" id="tanggal_dibuat" value="<?= date('Y-m-d') ?>" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Asal Surat</label>
                         <input type="text" class="form-control" id="upkNa" readonly>
                     </div>

                     <div class="form-group">
                         <label>Jenis Surat</label>
                         <select name="jenis_surat" id="id_jenis" class="form-control"></select>
                     </div>

                     <div class="form-group">
                         <label>Sifat Surat</label>
                         <select name="sifat_surat" id="id_sifat" class="form-control"></select>
                     </div>

                     <div class="form-group">
                         <label>Tanda Tangan Pejabat</label>
                         <select class="form-control" name="ttd_pejabat">
                             <option disabled selected>-- Pilih Tandatangan --</option>
                             <option value="1">ketua UPK</option>
                             <option value="2">ketua Yayasan</option>
                             <?php foreach ($jabatan as $key):?>
                             <option value="<?= $key->id?>"> <?= $key->jabatan?> - <?= $key->nama_user?> </option>
                             <?php endforeach ?>
                         </select>
                     </div>

                     <div class="form-group">
                         <label>Apakah Terdapat Lampiran</label>
                         <select name="status_lampiran" id="lampiranPilih" onchange="statusLampiran()" class="form-control">
                             <option value=""> -- Silakan Pilih -- </option>
                             <option value="1"> Ya </option>
                             <option value="0"> Tidak </option>
                         </select>
                     </div>


                     <div class="form-group" id="jenisLampiran"></div>
                     <div class="form-group" id="fileLampiran"></div>
                     <div class="form-group" id="fileLampiranNa"></div>


                     <div class="form-group">
                         <label>Tembusan</label>
                         <input type="text" name="tembusan" class="form-control">
                         <br>Dipisahkan Menggunakan Koma (,)
                     </div>

                     <div class="form-group">
                         <label>Perihal</label>
                         <textarea name="perihal" id="perihal" class="form-control" rows="50"></textarea>
                     </div>

                     <div class="form-group">
                         <label>Catatan/Isi Surat</label>
                         <textarea name="isi_surat" id="isi_surat" class="summernote" rows="50"></textarea>
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

 <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalEdit">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Revisi Surat Keluar</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>

             <!-- pindah kadieu/ -->
             <!-- form start -->
             <form id="formRevisiSurat">
                 <div class="modal-body">

                     <input type="hidden" id="idData" name="id">

                     <input type="hidden" value="0" id="status1" name="status">

                     <input type="hidden" id="persetujuan1" name="persetujuan">

                     <input type="hidden" id="nomorUrutSurat">

                     <input type="hidden" id="userBuat" name="id_user">

                     <input type="hidden" name="asal_surat" id="asalSurat">

                     <!-- <input type="hidden" name="" id="id_jenis1"> -->


                     <div class="form-group">
                         <h6>Revisi Dari : </h6>
                         <p id="RevisiDari"></p>
                         <h6>Catatan Revisi : </h6>
                         <p style="font-size: 20px;" id="catatan1"></p>
                     </div>

                     <hr>

                     <div class="form-group">
                         <label>Nomor Surat</label>
                         <input type="text" name="no_surat" id="no_surat1" class="form-control" readonly>
                     </div>

                     <div class="form-group">
                         <label>Tanggal Dibuat</label>
                         <input type="date" name="tanggal_dibuat" id="tanggal_dibuat1" value="<?= date('Y-m-d') ?>" class="form-control">
                     </div>

                     <div class="form-group">
                         <label>Asal Surat</label>
                         <input type="text" name="" class="form-control" id="upkNa1" readonly>
                     </div>

                     <div class="form-group">
                         <label>Jenis Surat</label>
                         <select name="jenis_surat" id="id_jenis1" class="form-control"></select>
                     </div>

                     <div class="form-group">
                         <label>Sifat Surat</label>
                         <select name="sifat_surat" id="id_sifat1" class="form-control"></select>
                     </div>

                     <div class="form-group">
                         <label>Perihal</label>
                         <textarea name="perihal" id="perihal1" class="form-control" rows="50"></textarea>
                     </div>

                     <div class="form-group">
                         <label>Catatan/Isi Surat</label>
                         <textarea name="isi_surat" id="isi_surat1" class="summernote" rows="50"></textarea>
                     </div>

                     <label id="persenUpload"></label>
                     <div class="progress" data-height="3" style="height: 3px;">
                         <div class="progress-bar" id="progressNa" role="progressbar" data-width="0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                     </div>

                 </div>
                 <div class="modal-footer bg-whitesmoke br">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Kirim Ulang</button>
                 </div>
             </form>
             <!-- form end -->


         </div>
     </div>
 </div>

