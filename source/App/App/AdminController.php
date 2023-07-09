<?php

namespace Source\App\App;

use Source\Core\Controller;
use Source\Models\Auth;

/**
 * Class AdminController
 * @package Source\App\App
 */
class AdminController extends Controller
{
    /**
     * @var \Source\Models\User|null
     */
    protected $user;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONF_VIEW_APP . "/");

        $this->user = Auth::user();

        if (!$this->user || $this->user->level < 1) {
            $this->message->error("Para acessar é preciso logar-se")->flash();
            redirect("/app/login");
        }
    }
}
