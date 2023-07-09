<?php $v->layout("_admin"); ?>
<!--App-Content-->
<?php if ($request) : ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Pedidos</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/requests/home'); ?>">Pedidos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Pedido</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Editar Pedido</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/requests/request/' . $request->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label>CPF</label>
                                        <input type="text" class="form-control mask-doc" name="document" value="<?= $request->document; ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Número Benefício</label>
                                        <input type="text" class="form-control" name="benefit_number" value="<?= $request->benefit_number; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control" name="client_id" value="<?= $request->client()->fullName(); ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <?php
                                            $status = $request->status;
                                            $selected = function ($value) use ($status) {
                                                return ($status == $value) ? "selected" : "";
                                            }
                                            ?>
                                            <option disabled value="">Selecionar</option>
                                            <option <?= $selected("pending") ?> value="pending">Pendente</option>
                                            <option <?= $selected("approved") ?> value="approved">Aprovado</option>
                                            <option <?= $selected("disapproved") ?> value="disapproved">Reprovado</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label>Anexo</label>
                                        <input type="file" class="form-control" name="attachment">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Descrição</label>
                                        <textarea name="description" cols="30" rows="10" class="form-control"><?= $request->description; ?></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success ">Atualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--/App-Content-->