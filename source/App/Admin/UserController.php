<?php

namespace Source\App\Admin;

use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class UserController
 * @package Source\App\Admin
 */
class UserController extends AdminController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array|null $data
     */
    public function home(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/users/home/{$s}/1")]);
            return;
        }

        $search = null;
        $level = 5;
        $users = (new User())->find("level = :level", "level={$level}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $users = (new User())->find("level = :level AND (first_name LIKE CONCAT('%', :s, '%') OR last_name LIKE CONCAT('%', :s, '%') OR email LIKE CONCAT('%', :s, '%'))", "level={$level}&s={$search}");
            if (!$users->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/users/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/users/home/{$all}/"));
        $pager->pager($users->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/users/home", [
            "app" => "users/home",
            "head" => $head,
            "search" => $search,
            "users" => $users->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function user(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $userCreate = new User();
            $userCreate->first_name = $data["first_name"];
            $userCreate->last_name = $data["last_name"];
            $userCreate->phone = preg_replace("/[^0-9]/", "", $data["phone"]);
            $userCreate->email = $data["email"];
            $userCreate->password = $data["password"];
            $userCreate->level = $data["level"];
            $userCreate->genre = $data["genre"];
            $userCreate->datebirth = date_fmt_back($data["datebirth"]);
            $userCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userCreate->photo = $image;
            }

            if (!$userCreate->save()) {
                $json["message"] = $userCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/users/user/{$userCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userUpdate = (new User())->findById($data["user_id"]);

            if (!$userUpdate) {
                $this->message->error("Você tentou gerenciar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/users/home")]);
                return;
            }

            $userUpdate->first_name = $data["first_name"];
            $userUpdate->last_name = $data["last_name"];
            $userUpdate->phone = preg_replace("/[^0-9]/", "", $data["phone"]);
            $userUpdate->email = $data["email"];
            $userUpdate->password = (!empty($data["password"]) ? $data["password"] : $userUpdate->password);
            $userUpdate->level = $data["level"];
            $userUpdate->genre = $data["genre"];
            $userUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $userUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($userUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userUpdate->photo}");
                    (new Thumb())->flush($userUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $userUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $userUpdate->photo = $image;
            }

            if (!$userUpdate->save()) {
                $json["message"] = $userUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Usuário atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $userDelete = (new User())->findById($data["user_id"]);

            if (!$userDelete) {
                $this->message->error("Você tentnou deletar um usuário que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/users/home")]);
                return;
            }

            if ($userDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$userDelete->photo}");
                (new Thumb())->flush($userDelete->photo);
            }

            $userDelete->destroy();

            $this->message->success("O usuário foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/users/home")]);

            return;
        }

        $userEdit = null;
        if (!empty($data["user_id"])) {
            $userId = filter_var($data["user_id"], FILTER_VALIDATE_INT);
            $userEdit = (new User())->findById($userId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($userEdit ? "Perfil de {$userEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/users/user", [
            "app" => "users/home",
            "head" => $head,
            "user" => $userEdit
        ]);
    }

    /**
     * @param array|null $data
     */
    public function clients(?array $data): void
    {
        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);
            echo json_encode(["redirect" => url("/admin/clients/home/{$s}/1")]);
            return;
        }

        $search = null;
        $level = 1;
        $clients = (new User())->find("level = :level", "level={$level}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $clients = (new User())->find("level = :level AND (first_name LIKE CONCAT('%', :s, '%') OR last_name LIKE CONCAT('%', :s, '%') OR email LIKE CONCAT('%', :s, '%'))", "level={$level}&s={$search}");
            if (!$clients->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/admin/clients/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/admin/clients/home/{$all}/"));
        $pager->pager($clients->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Usuários",
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/users/clients", [
            "app" => "users/home",
            "head" => $head,
            "search" => $search,
            "clients" => $clients->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function client(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $clientCreate = new User();
            $clientCreate->first_name = $data["first_name"];
            $clientCreate->last_name = $data["last_name"];
            $clientCreate->wallet = $data["wallet"];
            $clientCreate->phone = preg_replace("/[^0-9]/", "", $data["phone"]);
            $clientCreate->email = $data["email"];
            $clientCreate->password = $data["password"];
            $clientCreate->level = 1;
            $clientCreate->genre = $data["genre"];
            $clientCreate->datebirth = date_fmt_back($data["datebirth"]);
            $clientCreate->document = preg_replace("/[^0-9]/", "", $data["document"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $clientCreate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $clientCreate->photo = $image;
            }

            if (!$clientCreate->save()) {
                $json["message"] = $clientCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cliente cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/admin/clients/client/{$clientCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientUpdate = (new User())->findById($data["client_id"]);

            if (!$clientUpdate) {
                $this->message->error("Você tentou gerenciar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/client/home")]);
                return;
            }

            $clientUpdate->first_name = $data["first_name"];
            $clientUpdate->last_name = $data["last_name"];
            $clientUpdate->wallet = str_replace(",", ".", $data["wallet"]);
            $clientUpdate->phone = preg_replace("/[^0-9]/", "", $data["phone"]);
            $clientUpdate->email = $data["email"];
            $clientUpdate->password = (!empty($data["password"]) ? $data["password"] : $clientUpdate->password);
            $clientUpdate->genre = $data["genre"];
            $clientUpdate->datebirth = date_fmt_back($data["datebirth"]);
            $clientUpdate->document = preg_replace("/[^0-9]/", "", $data["document"]);

            //upload photo
            if (!empty($_FILES["photo"])) {
                if ($clientUpdate->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientUpdate->photo}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientUpdate->photo}");
                    (new Thumb())->flush($clientUpdate->photo);
                }

                $files = $_FILES["photo"];
                $upload = new Upload();
                $image = $upload->image($files, $clientUpdate->fullName(), 600);

                if (!$image) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $clientUpdate->photo = $image;
            }

            if (!$clientUpdate->save()) {
                $json["message"] = $clientUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Cliente atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $clientDelete = (new User())->findById($data["user_id"]);

            if (!$clientDelete) {
                $this->message->error("Você tentou deletar um cliente que não existe")->flash();
                echo json_encode(["redirect" => url("/admin/client/home")]);
                return;
            }

            if ($clientDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$clientDelete->photo}");
                (new Thumb())->flush($clientDelete->photo);
            }

            $clientDelete->destroy();

            $this->message->success("O cliente foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/admin/client/home")]);

            return;
        }

        $clientEdit = null;
        if (!empty($data["client_id"])) {
            $clientId = filter_var($data["client_id"], FILTER_VALIDATE_INT);
            $clientEdit = (new User())->findById($clientId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($clientEdit ? "Perfil de {$clientEdit->fullName()}" : "Novo Usuário"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/admin/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/users/client", [
            "app" => "users/home",
            "head" => $head,
            "client" => $clientEdit
        ]);
    }
}
