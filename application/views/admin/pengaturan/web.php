<form id="formUpdateData">
    <div class="row">
        <div class="col-md-12 col-lg-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Logo</h4>
                </div>
                <div class="card-body">
                   <img id="output" class="img-fluid" width="300" src="<?= base_url('uploads/config/' . $configNa[0]->value) ?>">
                    <br>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="<?= $configNa[0]->config ?>" onchange="loadFile(event)" class="custom-file-input" id="logo" onchange="">
                            <label class="kecilform-control form-control-sm custom-file-label " for="logo">Pilih</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4>Identitas Yayasan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama UPK</label>
                        <input type="text" class="form-control" id="nama" value="<?= $configNa[1]->value ?>" placeholder="Nama UPK" readonly>
                    </div>
                    <div class="form-group">
                        <label>Ketua UPK</label>
                        <input type="text" value="<?= $configNa[6]->value?>" class="form-control" id="ketua_upk" placeholder="Ketua UPK" readonly>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="<?= $configNa[2]->config ?>" id="alamat" class="form-control" placeholder="Alamat UPK"><?= $configNa[2]->value ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="number" name="<?= $configNa[3]->config ?>" value="<?= $configNa[3]->value ?>" id="no_telp_1" class="form-control" placeholder="No Telp 1" required>
                    </div>
                    <div class="form-group"></div>
                    <label>No Telp 2</label>
                    <input type="number" name="<?= $configNa[4]->config ?>" value="<?= $configNa[4]->value ?>" id="no_telp_1" class="form-control" placeholder="No Telp 2" required>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="<?= $configNa[5]->config ?>" value="<?= $configNa[5]->value ?>" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <button type="submit" class="btn btn-primary col-md-12">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
</script>