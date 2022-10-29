<?php

namespace App\Support\Flash;

use Illuminate\Contracts\Session\Session;

class Flash
{
    public const MESSAGE_KEY = 'shop_flash_message';
    public const MESSAGE_CLAS_KEY = 'shop_flash_class';


    public function __construct(protected Session $session)
    {

    }


    public function get(): FlashMessage
    {

    }


    public function info(string $message)
    {
        $this->session->flash(self::MESSAGE_KEY, $message);
        $this->session->flash(self::MESSAGE_CLAS_KEY, 'bg-purple text-center text-white');
    }


    public function alert(string $message)
    {

    }




}
