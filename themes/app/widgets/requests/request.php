<?php $v->layout("_app"); ?>
<!--App-Content-->
<?php if (!$request) : ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Pedidos</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/app/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/app/requests/home'); ?>">Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Pedido</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Criar Pedido</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/app/requests/request'); ?>" method="post">
                                <input type="hidden" name="action" value="create">
                                <div class="form-row">
                                    <div class="col-md-4"></div>
                                    <div class="form-group col-md-2">
                                        <label>CPF</label>
                                        <input type="text" class="form-control mask-doc" name="document">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Número Benefício</label>
                                        <input type="text" class="form-control" name="benefit_number">
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                                <button type="submit" class="btn btn-success ">Criar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Pedidos</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/app/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/app/requests/home'); ?>">Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Visualizar Pedido</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Visualizar Pedido</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/app/requests/request/' . $request->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="col-md-4"></div>
                                    <div class="form-group col-md-2">
                                        <label>CPF</label>
                                        <input type="text" class="form-control mask-doc" name="document" value="<?= $request->document; ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Número Benefício</label>
                                        <input type="text" class="form-control" name="benefit_number" value="<?= $request->benefit_number; ?>" readonly>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <?php if ($request->attachment) : ?>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="d-flex justify-content-center">
                                                <a href="<?= url() . "/storage/{$request->attachment}" ?>" class="btn btn-info" target="_blank" download="anexo-de-<?= $request->client()->fullName() ?>" title="Anexo">
                                                    <span class="fa fa-download"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                    <?php endif; ?>
                                    <?php if ($request->description) : ?>
                                        <div class="form-group col-md-12">
                                            <label>Descrição</label>
                                            <textarea name="description" cols="30" rows="10" class="form-control" readonly><?= $request->description; ?></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= url("/app/requests/home") ?>" class="btn btn-danger">Volar</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--/App-Content-->