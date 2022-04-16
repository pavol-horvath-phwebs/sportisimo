<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Security\AuthenticationException;

/**
 * Presenter for auth actions
 */
final class AuthPresenter extends Presenter
{    
    /**
     * Show login form
     * Or login user from form
     *
     * @return void
     * 
     */
    public function actionLogin(): void
    {   
        $login = $this->getHttpRequest()->getPost('login') ?? null;
        $password = $this->getHttpRequest()->getPost('password') ?? null;
        if ($login !== null && $password !== null) {
            try {
                $this->getUser()->login($login, $password);
                $this->redirect('Homepage:default');
            } catch (AuthenticationException $e) {
                $this->flashMessage('Uživatelské jméno nebo heslo je nesprávné');
            }
        }
    }

    /**
     * Logout user
     *
     * @return void
     * 
     */
    public function actionLogout(): void
    {
        $this->getUser()->logout();
        $this->redirect('Homepage:default');
    }
}