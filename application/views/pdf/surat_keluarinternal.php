<style>
    body {
        font-family: Helvetica, sans-serif;
        font-size: 10pt;
    }

    table {
        font-family: Helvetica, sans-serif;
    }

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

    .content {
        /* background-color: #666; */
    }

    .tembusan {
        font-size: 10pt;
        position: absolute;
        bottom: 0mm;
        /* height: 100%; */
        margin-bottom: 80px;
        /* background-color: #999; */
    }
</style>

<body>

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
    </htmlpageheader>

    <htmlpagefooter name="MyFooter2">
        <!-- <h1>hohoho</h1> -->
    </htmlpagefooter>

    <htmlpagefooter name="MyFooter1">
        <table style='width:100%;border-collapse: collapse;border-spacing: 0;' border='0'>
            <tr>
                <td style='width:50%;'>

                </td>
                <td style='width:50%;padding:5px;text-align:justify; border: 1'>
                    <table style='width:100%;border-collapse: collapse;font-size:12px;border-spacing: 0;float:right;'>
                        <tr>
                            <?php
                            // kalo acc ada
                            $NoSuratnya = str_replace('/', '-', $surat->no_surat);
                            if (count($acc) > 0 || $surat->status_pengiriman = !4) {
                                // foreach ($acc as $key => $value) { 
                            ?>

                                <td>
                                    <img src='<?= base_url('uploads/config/logostikes.png') ?>' width='50' alt=''>
                                </td>
                                <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>
                                    Ditandatangani secara elektronik oleh:
                                    <br>
                                    <?php echo end($jabatan) ?>
                                    <br>
                                    <img width='100px' src='https://chart.googleapis.com/chart?chs=270x270&cht=qr&chld=M|1&choe=UTF-8&chl=192.168.2.30/office/admin/track/<?= $NoSuratnya ?>'>
                                    <br>

                                    <?php echo end($depan); echo end($acc); end($belakang); ?>


                                </td>
                            <?php
                                // }

                                // Kalo belum di acc
                            } else { ?>
                                <td style='padding:5px;vertical-align:center;text-align:center;' colspan='2'>
                                    Ditanadtangani secara elektronik oleh:
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
        <table width="100%">
            <tr>
                <td width="100%" align="left" style="font-weight: bold;">Halaman {PAGENO} dari {nbpg}</td>
            </tr>
        </table>
    </htmlpagefooter>

    <sethtmlpageheader name="MyHeader1" value="on" show-this-page="1" />
    <sethtmlpagefooter name="MyFooter1" value="on" />
    <!-- <sethtmlpagefooter name="MyFooter2" value="1" show-this-page="2" /> -->

    <!-- <div>Start of the document ... and all the rest</div>'; -->


    <div class="content">
        <!-- <br><br> -->
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
        Kepada Yth. <br>
        <?= $surat->tujuan?><br>
        di <br>
        Tempat
        <div class="content">
            <?= $surat->isi_surat ?>
        </div>

        <!-- <br><br><br><br><br><br><br> -->

    </div>

    <?php if ($surat->tembusan != ''): ?>
    <div class="tembusan">
        <ol>
            Tembusan : <?php foreach ($tembusan as $key) : ?>
                <li>
                    <?= $key ?>
                </li>
            <?php endforeach ?>
        </ol>
    </div>    
    <?php endif ?>
    

    <!-- <div id='footer'>Halaman</div> -->

</body>