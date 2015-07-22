<?php

use Icinga\Module\Director\Web\Controller\ActionController;

class Director_DatalistController extends ActionController
{
    public function addAction()
    {
        $this->forward('index', 'datalist', 'director');
    }

    public function editAction()
    {
        $this->forward('index', 'datalist', 'director');
    }

    public function indexAction()
    {
        $edit = false;

        if($id = $this->params->get('id')) {
            $edit = true;
        }

        if ($edit) {
            $this->view->title = $this->translate('Edit list');
            $this->getTabs()->add('editlist', array(
                'url'       => 'director/datalist/edit' . '?id=' . $id,
                'label'     => $this->view->title,
            ))->add('entries', array(
                'url'       => 'director/list/datalistentry' . '?list_id=' . $id,
                'label'     => $this->translate('List entries'),
            ))->activate('editlist');
        } else {
            $this->view->title = $this->translate('Add list');
            $this->getTabs()->add('addlist', array(
                'url'       => 'director/datalist/add',
                'label'     => $this->view->title,
            ))->activate('addlist');
        }

        $form = $this->view->form = $this->loadForm('directorDatalist')
            ->setSuccessUrl('director/list/datalist')
            ->setDb($this->db());

        if ($edit) {
            $form->loadObject($id);
        }

        $form->handleRequest();

        $this->render('object/form', null, true);
    }
}