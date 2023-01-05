<?php
    /**
     * Created by PhpStorm.
     * User: admin
     * Date: 04/01/2023
     * Time: 13:48
     */
    
    namespace App\View\Helper;
    
    
    use Laminas\Form\View\Helper\AbstractHelper;
    use Mezzio\Flash\FlashMessages;
    use Mezzio\Session\Session;

    class FlashHelper extends AbstractHelper
    {
        public function __invoke()
        {
            $sessionStatus = session_status() === PHP_SESSION_ACTIVE ? $_SESSION : [] ;
            // test
            return FlashMessages::createFromSession(new Session($sessionStatus))->getFlashes();
        }
    }