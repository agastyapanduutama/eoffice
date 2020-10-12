<?php
// error_reporting(0)
?>

<base href='{{BASE_URL}}'>
<style>
    body {
        font-family: Helvetica, sans-serif;
        /* padding-top: 200px; */
    }

    table {
        font-family: Helvetica, sans-serif;
    }
</style>
<style>
    .barcode {
        padding: 1.5mm;
        margin: 0;
        vertical-align: top;
        color: #000044;
    }

    .barcodecell {
        text-align: center;
        vertical-align: middle;
    }

    #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 60px;
        /* tinggi dari footer */
        /* background: #6cf; */
    }
</style>

<body style='font-family: Helvetica; font-size: 10pt;'>

    <htmlpageheader name="MyHeader1">
        <table style='width:100%;border-collapse: collapse;' border='0'>
            <tr>
                <td style='padding:5px;font-size:12px;text-align:left;vertical-align:top;'>
                    <img src='<?= base_url('uploads/config/logostikes.png') ?>' width='50' alt=''>
                </td>
                <td style='width:100%;padding:5px;text-align:center; '>
                    <h2 style='margin-top:200px'>
                        Sekolah Tinggi Ilmu Kesehatan <br> Bakti Tunas Husada
                    </h2>
                    <h5>Jl. Cilolohan No. 36 Telp. (0265)334740 Fax. (0265)327224 Tasik Malaya 46115 <br> Website :
                        www.stikes-bth.ac.id Email : mail@stikes-bth.ac.id</h5>
                </td>
                <td style='padding:5px;font-size:12px;text-align:right;vertical-align:top;'>
                    <img src='<?= base_url('uploads/config/') ?><?= $surat->logo ?>' width='50' alt=''>
                </td>
            </tr>
        </table>
        <table style='width:100%;border-collapse: collapse;' border='0'>
            <tr>
                <td style='width:20%;'>&nbsp;</td>
                <td style='width:55%;padding:16px;text-align:center; font-weight:bold;text-decoration:underline;'>
                    <!-- LEMBAR DISPOSISI -->
                </td>
                <td style='width:25%;padding:5px 0px;font-size:10px;text-align:center;border:0px solid #666;'>
                </td>
            </tr>
        </table>
        <table style='width:100%;border-collapse: collapse;border-spacing: 0;' border='0'>
            <tr>
                <td style='width:60%;'>
                </td>
                <td style='width:40%;padding:5px;text-align:justify; '>
                    <table style='width:100%;border-collapse: collapse;font-size:12px;border-spacing: 0;float:right;'>
                        <tr>
                            <td colspan='3'><?= $surat->no_surat ?></td>
                        </tr>
                        <tr>
                            <td>Perihal</td>
                            <td>:</td>
                            <td><?= $surat->perihal ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Surat</td>
                            <td>:</td>
                            <td><?= $surat->jenis ?></td>
                        </tr>
            </tr>
            <tr>
                <td>DiKonfimasi</td>
                <td>:</td>
                <td> <?= date('d-m-Y', strtotime($surat->tanggal_konfirmasi)) ?></td>
                </td>
            </tr>

            <tr>
                <td rowspan='10'>Lampiran</td>
                <td>:</td>
                <?php if ($surat->lampiran != '') { ?>
                    <td>
                        <ol>
                            <?php foreach ($lampiran as $key) : ?>
                                <li>
                                    <?= $key ?>
                                </li>
                            <?php endforeach ?>
                        </ol>
                    </td>
                <?php } else { ?>
                    <td style='padding:5px;vertical-align:center;' colspan='2'> - </td>
                <?php } ?>
            </tr>
            </td>
            </tr>
        </table>

        </td>
        </tr>
        </table>
    </htmlpageheader>

    <htmlpagefooter name="MyFooter1">
        <table width="100%">
            <tr>
                <td width="100%" align="left" style="font-weight: bold; font-style:;">Halaman {PAGENO} dari {nbpg}</td>
                <!-- <td width="50%" align="right"><span style=" font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td> -->
            </tr>
        </table>
    </htmlpagefooter>

    <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
    <sethtmlpagefooter name="MyFooter1" value="on" />

    <!-- <div>Start of the document ... and all the rest</div>'; -->


    <div class="content">
        <br><br><br><br><br><br><br><br><br>
        <div class='checkbox1'>
            <?= $surat->isi_surat ?>
        </div>


        <br><br><br><br><br><br><br>
        <table style='width:100%;border-collapse: collapse;border-spacing: 0;' border='0'>
            <tr>
                <td style='width:50%;'>
                    <ol>
                        Tembusan : <?php foreach ($tembusan as $key) : ?>
                            <li>
                                <?= $key ?>
                            </li>
                        <?php endforeach ?>
                    </ol>
                </td>
                <td style='width:50%;padding:5px;text-align:justify; border: 1'>
                    <table style='width:100%;border-collapse: collapse;font-size:12px;border-spacing: 0;float:right;'>
                        <tr>
                             <td>
                                    <img src='<?= base_url('uploads/config/logostikes.png') ?>' width='50' alt=''>
                                </td>
                            <?php
                            // kalo acc ada
                            $NoSuratnya = str_replace('/', '-', $surat->no_surat);
                            if (count($acc) > 0 || $surat->status_pengiriman = !4) {
                                // foreach ($keterangan as $key => $value) { 
                            ?>

                                <?php 
                                if ($surat->acc_pejabat != NULL){ ?>
                                <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>
                                    <?php echo $keterangan[0] ?>
                                    <br><br>
                                    <img width='100px' src='https://chart.googleapis.com/chart?chs=270x270&cht=qr&chld=M|1&choe=UTF-8&chl=192.168.2.30/office/admin/track/<?= $NoSuratnya ?>'><br>
                                    <?= $pejabat->gelar_depan?> <?= $pejabat->nama_user ?> <?= $pejabat->gelar_belakang?>
                                </td>  

                                <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>
                                    <?php echo $keterangan[1] ?>
                                    <br><br>
                                    <img width='100px' src='https://chart.googleapis.com/chart?chs=270x270&cht=qr&chld=M|1&choe=UTF-8&chl=192.168.2.30/office/admin/track/<?= $NoSuratnya ?>'><br>
                                    <?= end($depan)?> <?= end($acc); ?> <?= end($belakang)?>
                                </td>  
                                
                                <?php }else{ ?>
                                     <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>

                                    <?php echo end($keterangan) ?>
                                    <br><br>
                                    <img width='100px' src='https://chart.googleapis.com/chart?chs=270x270&cht=qr&chld=M|1&choe=UTF-8&chl=192.168.2.30/office/admin/track/<?= $NoSuratnya ?>'>
                                    <br>
                                    <?= end($depan)?> <?= end($acc); ?> <?= end($belakang)?>
                                </td> 
   
                            <?php }
                            // Kalo belum di acc
                            } else { ?>
                                <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>
                                    Surat 
                                    <br><br><br><br><br>
                                    <!-- Barcode -->
                                    <br><br><br><br><br>
                                    Belum di verifikasi / Tidak Disetujui
                                </td>
                            <?php } ?>
                </td>
            </tr>




        </table>
        </td>
        </tr>
        </table>
    </div>


    <!-- <div id='footer'>Halaman</div> -->

</body>