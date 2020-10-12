<div class="card">
	<div class="card-header">
		<h4><?= $title ?> </h4>
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
			<table id="list_user" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th><input id="checkAll" type="checkbox"></th>
						<th>No</th>
						<th>Email Pengguna</th>
						<th>Nama UPK</th>
						<th>Nama Admin UPK</th>
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
				<h5 class="modal-title">Tambah User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formAddUser">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama UPK</label>
						<select name="id_upk" id="id_upk" class="form-control">
						</select>
					</div>

					<div class="form-group">
						<label>Admin UPK</label>
						<select name="nama_user" id="adminupk" class="form-control"></select>
					</div>

					<div class="form-group">
						<label>Email Pengguna</label>
						<input type="text" name="email" id="email" class="form-control" required>
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
				<h5 class="modal-title">Edit User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formEditUser">
				<div class="modal-body">
					<input type="hidden" name="id" id="idData">
					<div class="form-group">
						<label>Nama UPK</label>
						<select name="id_upk" id="id_upk1" class="form-control">
						</select>
					</div>

					<div class="form-group">
						<label>Nama Admin UPK</label>
						<input type="text" name="nama_user" id="nama_user1" class="form-control" required>
					</div>

					<div class="form-group">
						<label>Email Pengguna</label>
						<input type="text" name="email" id="email1" class="form-control" required>
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