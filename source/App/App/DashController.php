<?php

namespace Source\App\App;

use Source\Models\Auth;

/**
 * Class DashController
 * @package Source\App\App
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
        redirect("/app/dash/home");
    }

    /**
     * @param array|null $data
     * @throws \Exception
     */
    public function home(?array $data): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " | Dashboard",
            CONF_SITE_DESC,
            url("/app"),
            theme("/assets/images/image.jpg", CONF_VIEW_ADMIN),
            false
        );

        echo $this->view->render("widgets/dash/home", [
            "app" => "dash",
            "head" => $head,
            "balance" => str_replace(".", ",", user()->wallet)
        ]);
    }

    /**
     *
     */
    public function logoff(): void
    {
        $this->message->success("Você saiu com sucesso {$this->user->first_name}.")->flash();

        Auth::logout();
        redirect("/app/login");
    }
}
