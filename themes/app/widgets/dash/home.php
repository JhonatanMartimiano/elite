<?php $v->layout("_app"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                <div class="card overflow-hidden">
                    <div class="card-body iconfont text-center">
                        <img src="<?= theme("/assets/images/wallet-solid.svg", CONF_VIEW_APP) ?>" alt="Wallet" width="50">
                        <h5>Saldo</h5>
                        <h3 class="mb-0 fs-30 mt-1">R$ <span class="counter"><?= $balance; ?></span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->