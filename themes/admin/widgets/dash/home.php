<?php $v->layout("_admin"); ?>
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
                        <h5>
                            <span class="fa fa-users"></span>
                        </h5>
                        <h5>Clientes</h5>
                        <h3 class="mb-0 fs-30 mt-1"><span class="counter"><?= $clients; ?></span></h3>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                <div class="card overflow-hidden">
                    <div class="card-body iconfont text-center">
                        <h5>
                            <span class="fa fa-clipboard"></span>
                        </h5>
                        <h5>Pedidos</h5>
                        <h3 class="mb-0 fs-30 mt-1"><span class="counter"><?= $requests; ?></span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->