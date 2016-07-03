<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Presenter\Controller;

use Presenter\Model\Filter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model;
use Zend\Paginator\Paginator;

class IndexController extends AbstractActionController
{
    public $month_names_ru = [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь'
    ];

    public function indexAction()
    {
        $page = (int)$this->params()->fromRoute('page', 1);

        $filterModel = new Filter();
        $filter_options = $filterModel->getOptions($this->getRequest());

        $model = new Model\News($this->getServiceLocator()->get('db'));
        $themesModel = new Model\Themes($this->getServiceLocator()->get('db'));
        $news_list = $model->getList($filter_options);

        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($news_list));
        $paginator->setItemCountPerPage(5);
        $paginator->setCurrentPageNumber($page);

        return new ViewModel([
            'list'=>$news_list,
            'dates_filter' => $model->getFilterDates(),
            'month_names' => $this->month_names_ru,
            'themes_filter' => $themesModel->getFilterThemes(),
            'filter_options' => $filter_options,
            'paginator' => $paginator
        ]);
    }
}
