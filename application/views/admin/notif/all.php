<style>
    .notifna .dropdown-item {
        padding-top: 18px;
    }

    .notifna .opened {
        background-color: #f0f0f0;
    }

    .notifna .time {
        font-size: 10px;
        text-transform: uppercase;
        margin-top: 5px;
        /* font-weight: bold; */
    }

    .notifna .dropdown-item-icon {
        /* display: none; */
        float: left;
        flex-shrink: 0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        line-height: 42px;
        text-align: center;
        margin-right: 15px;
    }

    .loadingNa {
        display: none;
    }

    .showLoading {
        display: inline-block;
    }
</style>
<input type="hidden" value="<?= $itemNotif ?>" id="idItemNotif">
<input type="hidden" id="dataNotif1">
<input type="hidden" value="0" id="fromGet">
<div class="row">
    <div class='col-md-4 col-xl-4 col-sm-12'>
        <div class="card shadow">
            <div class="card-header">
                <h4><?= $title ?></h4>
            </div>
            <div class="notifna" style="max-height: 500px; overflow: auto;">
                <div id="notifNa1"></div>
            </div>
            <div class="loadingNa w-100 text-center pb-2">
                <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-8 col-sm-12">
        <div class="card shadow">
            <div class="card-header">
                <h4>Detail</h4>
            </div>
            <div class="card-body" id="notifDetail">
                <div class="w-100 text-center">
                    <b>Tidak ada item terpilih</b>
                </div>
            </div>
        </div>
    </div>
</div>