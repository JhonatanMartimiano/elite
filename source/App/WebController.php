<?php

namespace Source\App;

use Source\Core\Controller;

/**
 * WebController
 * @package Source\App
 */
class WebController extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("")
        );

        echo $this->view->render("home", [
            "head" => $head,
        ]);
    }
}