<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Editor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $model = new Model\News($this->getServiceLocator()->get('db'));
        $news = $model->getList();

        return new ViewModel([ 'news'=>$news]);
    }
}
