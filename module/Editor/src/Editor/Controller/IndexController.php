<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Editor\Controller;

use Editor\NewsAddForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model;
use Editor\Form\NewsAddForm as AddForm;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $model = new Model\News($this->getServiceLocator()->get('db'));
        $news = $model->getList();

        return new ViewModel(['news'=>$news]);
    }

    public function addAction()
    {
        $themesModel = new Model\Themes($this->getServiceLocator()->get('db'));
        $form = new AddForm(null, ['category_values' => $themesModel->getList()]);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $model = new Model\News($this->getServiceLocator()->get('db'));
            $form->setInputFilter($model->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $model = new Model\News($this->getServiceLocator()->get('db'));
                $model->add($request->getPost());

                return $this->redirect()->toRoute('editor');
            }
        }
        return [
            'form' => $form
        ];
    }

    public function editAction(){

        $id = (int) $this->params()->fromRoute('news_id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('editor', array(
                'action' => 'add'
            ));
        }

        $db_adapter = $this->getServiceLocator()->get('db');

        $newsModel = new Model\News($db_adapter);
        $themesModel = new Model\Themes($db_adapter);

        $newsModel->exchangeArray($newsModel->getById($id));

        $form = new AddForm(null, ['category_values' => $themesModel->getList()]);

        $form->get('theme_id')->setValue($newsModel->theme_id);
        $form->bind($newsModel);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($form->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $newsModel->update($form->getData());
                return $this->redirect()->toRoute('editor');
            }
        }

        return [
            'id' => $id,
            'form' => $form,
        ];
    }

    public function deleteAction(){

        $id = (int) $this->params()->fromRoute('news_id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('editor');
        }

        $newsModel = new Model\News($this->getServiceLocator()->get('db'));
        $newsModel->delete($id);

        return $this->redirect()->toRoute('editor');

    }
}
