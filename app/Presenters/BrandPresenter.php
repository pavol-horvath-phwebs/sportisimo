<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Factories\BrandFactory;
use Nette\Application\UI\Presenter;

/**
 * Presenter form brands acitons
 */
final class BrandPresenter extends Presenter
{
    /**
     * Factory form brands
     *
     * @var BrandFactory
     */
    private BrandFactory $brandFactory;

    /**
     * __construct for brand presenter
     *
     * @param BrandFactory $brandFactory
     * 
     */
    public function __construct(BrandFactory $brandFactory)
    {
        $this->brandFactory = $brandFactory;
    }

    /**
     * All action are only login users
     *
     * @return void
     * 
     */
    public function startup(): void
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro přístup do této sekce musíte být přihlášen.');
            $this->redirect('Homepage:default');
        }
    }
    
    /**
     * Show list of brands
     *
     * @param int $page
     * @param int $limit
     * @param string $order
     * 
     * @return void
     * 
     */
    public function actionDefault(int $page = 1, int $limit = 10, string $order = 'ASC'): void
    {
        if (!in_array($limit, [10, 20, 30])) {
            $limit = 10;
        }
        $this->template->page = $page;
        $this->template->pagesCount = $this->brandFactory->getPagesCount($limit);
        $this->template->limit = $limit;
        $this->template->order = $order;
        $this->template->brands = $this->brandFactory->getList($page, $limit, $order);
    }

    /**
     * Show form for new brand
     *
     * @return void
     * 
     */
    public function actionAdd(): void
    {
        $this->template->title = 'Přidat značku';
        $this->setView('form');
    }

    /**
     * Show form for update existing brand
     *
     * @param int $id
     * 
     * @return void
     * 
     */
    public function actionUpdate(int $id): void
    {
        $this->template->title = 'Upravit značku';
        $brand = $this->brandFactory->get($id);
        $this->template->id = $brand->id;
        $this->template->name = $brand->name;
        $this->setView('form');
    }

    /**
     * Save data from brand form
     *
     * @return void
     * 
     */
    public function actionSave(): void
    {
        $id = intval($this->getHttpRequest()->getPost('id'));
        $name = trim($this->getHttpRequest()->getPost('name'));
        $brand = $this->brandFactory->create();
        $brand->id = $id ?: null;
        $brand->name = $name;
        if ($errorMsg = $brand->validate()) {
            $this->flashMessage($errorMsg);
            if ($id) {
                $this->redirect('Brand:update', $id);
            } else {
                $this->redirect('Brand:add');
            }
        }
        $brand->save();
        $this->flashMessage('Značka byla uložena.');
        $this->redirect('Brand:default');
    }

    /**
     * Delete existing brand
     *
     * @param int $id
     * 
     * @return void
     * 
     */
    public function actionDelete(int $id): void
    {
        $brand = $this->brandFactory->get($id);
        $brand->delete();
        $this->flashMessage('Značka byla smazána.');
        $this->redirect('Brand:default');
    }
}