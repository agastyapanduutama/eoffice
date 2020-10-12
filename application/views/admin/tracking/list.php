<div class="card">
    <div class="card-header">
        <h2 class="section-title"> <?= $title ?></h2>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="activities">

            <?php foreach ($datana as $track) { ?>
                <div class="activity">
                    <!-- Selesai -->
                    <?php if ($track->tipe == 0) { ?>
                        <div class="activity-icon bg-success text-white shadow-primary">
                            <i class="fas fa-check"></i>
                        </div>
                    <?php } ?>
                    <!-- Buat Surat Keluar -->
                    <?php if ($track->tipe == 1) { ?>
                        <div class="activity-icon bg-info text-white shadow-primary">
                            <i class="fas fa-plus"></i>
                        </div>
                    <?php } ?>
                    <!-- Revisi -->
                    <?php if ($track->tipe == 2) { ?>
                        <div class="activity-icon bg-warning text-white shadow-primary">
                            <i class="fas fa-redo"></i>
                        </div>
                    <?php } ?>
                    <!-- Ditolak -->
                    <?php if ($track->tipe == 3) { ?>
                        <div class="activity-icon bg-danger text-white shadow-primary">
                            <i class="fas fa-times"></i>
                        </div>
                    <?php } ?>
                    <!-- Dikembalikan -->
                    <?php if ($track->tipe == 4) { ?>
                        <div class="activity-icon bg-primary text-white shadow-primary">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                    <?php } ?>

                    <div class="activity-detail">
                        <div class="mb-2">
                            <span class="text-job text-primary"><?= $track->waktu_dibuat ?></span>
                            <span class="bullet"></span>
                            <a class="text-job" href="#"><?= $track->no_surat ?></a>
                            <p><?= $track->aksi ?></p>
                            <p><?= $track->status_pengiriman ?></p>
                            <p><?= $track->keterangan ?></p>
                            <!-- <p><?= $track->tipe ?></p> -->
                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>