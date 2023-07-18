<?php

namespace Source\App\App;

use Source\Models\Request;
use Source\Models\User;
use Source\Support\Pager;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class RequestController
 * @package Source\App\App
 */
class RequestController extends AdminController
{
    /**
     * RequestController constructor.
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
            echo json_encode(["redirect" => url("/app/requests/home/{$s}/1")]);
            return;
        }

        $search = null;
        $clientId = user()->id;
        $requests = (new Request())->find("client_id = :client_id", "client_id={$clientId}");

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $requests = (new Request())->find("client_id = :client_id AND (document LIKE CONCAT('%', :s, '%') OR benefit_number LIKE CONCAT('%', :s, '%'))", "client_id={$clientId}&s={$search}");
            if (!$requests->count()) {
                $this->message->info("Sua pesquisa não retornou resultados")->flash();
                redirect("/app/requests/home");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/app/requests/home/{$all}/"));
        $pager->pager($requests->count(), 20, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Pedidos",
            CONF_SITE_DESC,
            url("/admin"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/requests/home", [
            "app" => "requests/home",
            "head" => $head,
            "search" => $search,
            "requests" => $requests->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function request(?array $data): void
    {
        //create
        if (!empty($data["action"]) && $data["action"] == "create") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $value = str_replace(",", ".", $data["value"]);
            $requestCreate = new Request();
            $requestCreate->document = clean_mask($data["document"]);
            $requestCreate->benefit_number = $data["benefit_number"];
            $requestCreate->value = $value;
            $requestCreate->client_id = user()->id;

            if (user()->wallet < $value + 1) {
                $json["message"] = $this->message->warning("O valor do pedido é maior que seu saldo, reveja o seu saldo e tenha em mente que o valor do pedido é de R$ 1,00.")->render();
                echo json_encode($json);
                return;
            }

            $wallet = user()->wallet - ($value + 1);

            $clientUpdateWallet = (new User())->findById(user()->id);
            $clientUpdateWallet->wallet = $wallet;

            if (!$clientUpdateWallet->save()) {
                $json["message"] = $clientUpdateWallet->message()->render();
                echo json_encode($json);
                return;
            }

            if (!$requestCreate->save()) {
                $json["message"] = $requestCreate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Pedido cadastrado com sucesso...")->flash();
            $json["redirect"] = url("/app/requests/request/{$requestCreate->id}");

            echo json_encode($json);
            return;
        }

        //update
        if (!empty($data["action"]) && $data["action"] == "update") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $requestUpdate = (new Request())->findById($data["request_id"]);

            if (!$requestUpdate) {
                $this->message->error("Você tentou gerenciar um pedido que não existe")->flash();
                echo json_encode(["redirect" => url("/app/requests/home")]);
                return;
            }

            $requestUpdate->status = $data["status"];
            $requestUpdate->description = $data["description"];
            $requestUpdate->document = clean_mask($data["document"]);

            //upload attachment
            if (!empty($_FILES["attachment"])) {
                if ($requestUpdate->attachment && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$requestUpdate->attachment}")) {
                    unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$requestUpdate->attachment}");
                    (new Thumb())->flush($requestUpdate->attachment);
                }

                $files = $_FILES["attachment"];
                $upload = new Upload();
                $attachment = $upload->file($files, $requestUpdate->document);

                if (!$attachment) {
                    $json["message"] = $upload->message()->render();
                    echo json_encode($json);
                    return;
                }

                $requestUpdate->attachment = $attachment;
            }

            if (!$requestUpdate->save()) {
                $json["message"] = $requestUpdate->message()->render();
                echo json_encode($json);
                return;
            }

            $this->message->success("Pedido atualizado com sucesso...")->flash();
            echo json_encode(["reload" => true]);
            return;
        }

        //delete
        if (!empty($data["action"]) && $data["action"] == "delete") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $requestDelete = (new Request())->findById($data["request_id"]);

            if (!$requestDelete) {
                $this->message->error("Você tentnou deletar um pedido que não existe")->flash();
                echo json_encode(["redirect" => url("/app/requests/home")]);
                return;
            }

            if ($requestDelete->photo && file_exists(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$requestDelete->photo}")) {
                unlink(__DIR__ . "/../../../" . CONF_UPLOAD_DIR . "/{$requestDelete->photo}");
                (new Thumb())->flush($requestDelete->photo);
            }

            $requestDelete->destroy();

            $this->message->success("O pedido foi excluído com sucesso...")->flash();
            echo json_encode(["redirect" => url("/app/requests/home")]);

            return;
        }

        $requestEdit = null;
        if (!empty($data["request_id"])) {
            $requestId = filter_var($data["request_id"], FILTER_VALIDATE_INT);
            $requestEdit = (new Request())->findById($requestId);
        }

        $head = $this->seo->render(
            CONF_SITE_NAME . " | " . ($requestEdit ? "Pedido de {$requestEdit->client()->fullName()}" : "Novo Pedido"),
            CONF_SITE_DESC,
            url("/admin"),
            url("/app/assets/images/image.jpg"),
            false
        );

        echo $this->view->render("widgets/requests/request", [
            "app" => "requests/home",
            "head" => $head,
            "request" => $requestEdit
        ]);
    }
}
