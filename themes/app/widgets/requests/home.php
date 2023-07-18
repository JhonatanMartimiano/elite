<?php $v->layout("_app"); ?>
<!--App-Content-->
<div class="app-content  my-3 my-md-5">
    <div class="side-app">
        <div class="page-header">
            <h4 class="page-title">Pedidos</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= url('/app/dash/home') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h3 class="card-title">Pedidos</h3>
                            <div>
                                <a href="<?= url('/app/requests/request'); ?>" class="btn btn-pill btn-success"><i class="fa fa-plus"></i> Adicionar Pedido</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form class="form-inline mb-1" action="<?= url('/app/requests/home'); ?>" method="post">
                                <div class="nav-search">
                                    <input type="search" class="form-control header-search" name="s" value="<?= $search; ?>" placeholder="Buscar…" aria-label="Search">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                            <table class="table table-bordered border-top mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CPF</th>
                                        <th>Número Benefício</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($requests) : ?>
                                        <?php foreach ($requests as $request) : ?>
                                            <tr>
                                                <th scope="row"><?= $request->id; ?></th>
                                                <td class="mask-doc"><?= $request->document; ?></td>
                                                <td><?= $request->benefit_number; ?></td>
                                                <td><?= $request->value; ?></td>
                                                <td>
                                                    <?php
                                                    switch ($request->status) {
                                                        case "disapproved":
                                                            echo "Reprovado";
                                                            break;
                                                        case "approved":
                                                            echo "Aprovado";
                                                        default:
                                                            echo "Pendente";
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <a href="<?= url('/app/requests/request/' . $request->id); ?>" class="btn btn-info btn-sm" title="Editar"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?= $paginator; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/App-Content-->