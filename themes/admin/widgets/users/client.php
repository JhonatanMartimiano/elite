<?php $v->layout("_admin"); ?>
<!--App-Content-->
<?php if (!$client) : ?>
    <div class="app-content  my-3 my-md-5">
        <div class="side-app">
            <div class="page-header">
                <h4 class="page-title">Clientes</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Criar Cliente</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Criar Cliente</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/clients/client'); ?>" method="post">
                                <input type="hidden" name="action" value="create">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Nome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="first_name" placeholder="Digite seu nome">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Sobrenome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="last_name" placeholder="Digite seu sobrenome">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Saldo</label>
                                        <input type="text" class="form-control mask-money" name="wallet">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Telefone/WhatsApp</label>
                                        <input type="tel" class="form-control mask-phone" name="phone" placeholder="Digite o telefone">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Gênero</label>
                                        <select name="genre" class="form-control">
                                            <option value="">Selecione o gênero</option>
                                            <option value="male" class="">Masculino</option>
                                            <option value="female" class="">Feminino</option>
                                            <option value="other" class="">Outros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nascimento</label>
                                        <input type="text" class="form-control mask-date" name="datebirth" placeholder="Digite sua data de nascimento">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CPF</label>
                                        <input type="text" class="form-control mask-doc" name="document" placeholder="Digite seu CPF">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>E-mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Senha <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" placeholder="Digite sua senha">
                                    </div>
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
                <h4 class="page-title">Clientes</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url('/admin/dash/home'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= url('/admin/clients/home'); ?>">Clientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Cliente</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-b-20">
                        <div class="card-header">
                            <h3 class="card-title">Editar Cliente</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= url('/admin/clients/client/' . $client->id); ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Nome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="first_name" value="<?= $client->first_name; ?>" placeholder="Digite seu nome">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Sobrenome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="last_name" value="<?= $client->last_name; ?>" placeholder="Digite seu sobrenome">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Saldo</label>
                                        <input type="text" class="form-control mask-money" name="wallet" value="<?= $client->wallet; ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Telefone/WhatsApp</label>
                                        <input type="tel" class="form-control mask-phone" name="phone" value="<?= $client->phone; ?>" placeholder="Digite o telefone">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Gênero</label>
                                        <select name="genre" class="form-control">
                                            <option value="">Selecione o gênero</option>
                                            <?php
                                            $genre = $client->genre;
                                            $select = function ($value) use ($genre) {
                                                return ($genre == $value ? "selected" : "");
                                            };
                                            ?>
                                            <option <?= $select("male"); ?> value="male">Masculino</option>
                                            <option <?= $select("female"); ?> value="female">Feminino</option>
                                            <option <?= $select("other"); ?> value="other">Outros</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Nascimento</label>
                                        <input type="text" class="form-control mask-date" name="datebirth" value="<?= date_fmt($client->datebirth, "d/m/Y"); ?>" placeholder="Digite sua data de nascimento">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>CPF</label>
                                        <input type="text" class="form-control mask-doc" name="document" value="<?= $client->document; ?>" placeholder="Digite seu CPF">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>E-mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" value="<?= $client->email; ?>" placeholder="Digite seu e-mail">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Senha <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password" placeholder="Digite sua senha">
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