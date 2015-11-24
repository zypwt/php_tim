<?php

use \Phalcon\Tag as Tag;

class PwOrderClearQueueController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PwOrderClearQueue", $_POST);
            $this->session->conditions = $query->getConditions();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
            if ($numberPage <= 0) {
                $numberPage = 1;
            }
        }

        $parameters = array();
        if ($this->session->conditions) {
            $parameters["conditions"] = $this->session->conditions;
        }
        $parameters["order"] = "ID";

        $pworderclearqueue = PwOrderClearQueue::find($parameters);
        if (count($pworderclearqueue) == 0) {
            $this->flash->notice("The search did not find any pw order clear queue");
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $pworderclearqueue,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
    }

    public function newAction()
    {

    }

    public function editAction($ID)
    {

        $request = $this->request;
        if (!$request->isPost()) {

            $ID = $this->filter->sanitize($ID, array("int"));

            $pworderclearqueue = PwOrderClearQueue::findFirst('ID="'.$ID.'"');
            if (!$pworderclearqueue) {
                $this->flash->error("pw order clear queue was not found");
                return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
            }
            $this->view->setVar("ID", $pworderclearqueue->ID);
        
            Tag::displayTo("ID", $pworderclearqueue->ID);
            Tag::displayTo("PIAOWU_ORDER_ID", $pworderclearqueue->PIAOWU_ORDER_ID);
            Tag::displayTo("OPERATE_NUMBER", $pworderclearqueue->OPERATE_NUMBER);
            Tag::displayTo("CREATE_TIME", $pworderclearqueue->CREATE_TIME);
            Tag::displayTo("QIANG", $pworderclearqueue->QIANG);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

        $pworderclearqueue = new PwOrderClearQueue();
        $pworderclearqueue->ID = $this->request->getPost("ID");
        $pworderclearqueue->PIAOWU_ORDER_ID = $this->request->getPost("PIAOWU_ORDER_ID");
        $pworderclearqueue->OPERATE_NUMBER = $this->request->getPost("OPERATE_NUMBER");
        $pworderclearqueue->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $pworderclearqueue->QIANG = $this->request->getPost("QIANG");
        if (!$pworderclearqueue->save()) {
            foreach ($pworderclearqueue->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "new"));
        } else {
            $this->flash->success("pw order clear queue was created successfully");
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $pworderclearqueue = PwOrderClearQueue::findFirst("ID='$ID'");
        if (!$pworderclearqueue) {
            $this->flash->error("pw order clear queue does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }
        $pworderclearqueue->ID = $this->request->getPost("ID");
        $pworderclearqueue->PIAOWU_ORDER_ID = $this->request->getPost("PIAOWU_ORDER_ID");
        $pworderclearqueue->OPERATE_NUMBER = $this->request->getPost("OPERATE_NUMBER");
        $pworderclearqueue->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $pworderclearqueue->QIANG = $this->request->getPost("QIANG");
        if (!$pworderclearqueue->save()) {
            foreach ($pworderclearqueue->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "edit", "params" => array($pworderclearqueue->ID)));
        } else {
            $this->flash->success("pw order clear queue was updated successfully");
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $pworderclearqueue = PwOrderClearQueue::findFirst('ID="'.$ID.'"');
        if (!$pworderclearqueue) {
            $this->flash->error("pw order clear queue was not found");
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }

        if (!$pworderclearqueue->delete()) {
            foreach ($pworderclearqueue->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "search"));
        } else {
            $this->flash->success("pw order clear queue was deleted");
            return $this->dispatcher->forward(array("controller" => "pworderclearqueue", "action" => "index"));
        }
    }

}
