<?php

namespace Source\App\Admin;

use Source\Models\Auth;
use Source\Models\Request;
use Source\Models\User;

/**
 * Class DashController
 * @package Source\App\Admin
 */
class DashController extends AdminController
{
    /**
     * DashController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function dash(): void
    {
        redirect("/admin/dash/home");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        $level = 1;
        $clients = (new User())->find("level = :level", "level={$level}")->count();
        $requests = (new Request())->find()->count();

        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/admin"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "clients" => $clients,
            "requests" => $requests
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->first_name}.")->flash();

        Auth::logout();
        redirect("/admin/login");
    }
}
