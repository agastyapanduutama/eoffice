<div class="card">
    <div class="card-header">
        <h4>Atur Profile</h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="Profile" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Password</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <form id="formProfile">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label>NIY</label>
                        <input type="number" name="niy" id="niy" class="form-control" placeholder="NIY">
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-lg-3">
                            <div class="form-group">
                                <label>Gelar Depan</label>
                                <input type="text" name="gelar_depan" id="gelar_depan" class="form-control" placeholder="Gelar Depan">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama_user" id="nama_user" class="form-control" placeholder="Nama">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-lg-3">
                            <div class="form-group">
                                <label>Gelar Belakang</label>
                                <input type="text" name="gelar_belakang" id="gelar_belakang" class="form-control" placeholder="Gelar Belakang">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Masukan Password Untuk Merubah</label>
                        <input type="password" name="password" class="form-control" id="passwordUbahProfile" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Password Salah !
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" id="reset" class="btn btn-danger"> <i class="fas fa-times"></i> Batal</button>
                        <button type="submit" class="btn btn-primary"> <i class="fas fa-paper-plane"></i> Simpan</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                <form id="formPassword">
                    <div class="form-group">
                        <label>Masukan Password Lama</label>
                        <input type="password" name="passwordLama" id="passLama" class="form-control" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Password Salah !
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Masukan Password Baru</label>
                        <input type="password" name="password" id="passBaru" class="form-control" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Password minimal 6 karakter
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Masukan Lagi Password</label>
                        <input type="password" name="passwordConfirm" id="confirmPass" class="form-control" placeholder="Password" required>
                        <div class="invalid-feedback">
                            Password tidak sama !
                        </div>
                        <div class="valid-feedback">
                            Password sama !
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" id="btnUbahPass" class="btn btn-primary" disabled="true"> <i class="fas fa-paper-plane"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>