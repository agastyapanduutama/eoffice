<base href="{{BASE_URL}}">
<style>
    body {
        font-family: Times New Roman, sans-serif;
    }

    table {
        font-family: Times New Roman, sans-serif;
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
</style>

<body style="font-family: Times New Roman; font-size: 10pt;">


<!-- Header -->
    <table style="width:100%;border-collapse: collapse;" border="1">
        <tr>
            <td style="padding:5px;font-size:12px;text-align:left;vertical-align:top;">
                <img src="<?= base_url()?>uploads/config/logobth.png" width="120" alt="">
            </td>
            <td style="width:100%;padding:5px;text-align:center; font-weight:bold;font-size:12px">
                <h3>SEKOLAH TINGGI ILMU KESEHATAN <br>BAKTI TUNAS HUSADA TASIKMALAYA <br> Prodi S1 Farmasi, DIII Keperawatanm DIII TLM, DIII Otometri <br>Jl Cilolohan No.36 Telp.(0265)334740 Fax. (0265)327224 <br>Tasikmalaya 46115</h3>
            </td>
        </tr>
    </table>

     <table style="width:100%;border-collapse: collapse;">
        <tr>
            <!-- <td style="width:30%;padding:5px;text-align:center; font-weight:bold;font-size:12px">
                KEPADA YTH
            </td> -->
            <td style="width:100%;padding:5px;text-align:center; font-weight:bold;font-size:12px">
                <H2>PESAN BALASAN</H2>
            </td>
        </tr>
    </table>

        <br>


    <table style="width:100%;border-collapse: collapse;" border="0">
        <tr>
            <th width="100px"></th>
            <th width="10px"></th>
            <th></th>
        </tr>
         <tr>
            <td>DARI</td>
            <td>:</td>
            <td>
            <?= $surat->asal_surat?>
            </td>
          </tr>
          <tr>
            <td>PERIHAL</td>
            <td>:</td>
            <td>
            <?= $surat->perihal?>
            </td>
          </tr>
          <tr>
            <td>Tanggal Dibuat</td>
            <td>:</td>
            <td>
            <?= $surat->tanggal_dibuat ?>
            </td>
            <td>TGL TERIMA : <?= $surat->tanggal_surat ?></td>
          </tr>
          <tr>
            <td>NO SURAT</td>
            <td>:</td>
            <td>
            <?= $surat->no_surat ?>
            </td>
          </tr>
          <tr>
            <td>AKSI</td>
            <td>:</td>
            <td>
            <?= $surat->aksi ?>
            </td>
          </tr>
    </table>
   
    <table style="width:100%;border-collapse: collapse;" border="0">
        <tr>
            <td style="width:20%;">&nbsp;</td>
            <td style="width:55%;padding:16px;text-align:center; font-weight:bold;text-decoration:underline;">
                <!-- LEMBAR DISPOSISI -->
            </td>
            <td style="width:25%;padding:5px 0px;font-size:10px;text-align:center;border:0px solid #666;">

            </td>
        </tr>
    </table>
   
    <br>

    <table style="width:100%;border-collapse: collapse;" border="1">
        <tr>
            <!-- <td style="width:30%;padding:5px;text-align:center; font-weight:bold;font-size:12px">
                KEPADA YTH
            </td> -->
            <th style="padding:5px;text-align:center; font-weight:bold;font-size:12px">
                CATATAN / INTRUKSI
            </th>
        </tr>
        <tr >
            <td width="100%">
	                <?= $surat->catatan ?>
            </td>
        </tr>
       
    </table>
</body>