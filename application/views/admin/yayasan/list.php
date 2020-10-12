<form id="formUpdateData">
	<div class="row">
		<div class="col-md-12 col-lg-4 col-sm-12">
			<div class="card">
				<div class="card-header">
					<h4>Logo</h4>
				</div>
				<div class="card-body">
					<img id="output" class="img-fluid" src="<?= base_url() ?>assets/logo/nologo.png">
					<br>
					<div class="input-group">
						<div class="custom-file">
							<input type="file" name="logo" onchange="loadFile(event)" class="custom-file-input" id="logo" onchange="">
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
						<label>Nama Yayasan</label>
						<input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Yayasan" required>
					</div>
					<div class="form-group">
						<label>Ketua Yayasan</label>
						<select name="ketua_yayasan" class="form-control" id="id_pegawai"></select>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Yayasan"></textarea>
					</div>
					<div class="form-group">
						<label>No Telp</label>
						<input type="number" name="no_telp_1" id="no_telp_1" class="form-control" placeholder="No Telp 1" required>
					</div>
					<div class="form-group"></div>
					<label>No Telp 2</label>
					<input type="number" name="no_telp_2" id="no_telp_2" class="form-control" placeholder="No Telp 2">
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
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