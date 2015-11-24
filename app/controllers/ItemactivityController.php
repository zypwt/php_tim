<?php

use \Phalcon\Tag as Tag;

class ItemActivityController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemActivity", $_POST);
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
        $parameters["order"] = "1";

        $itemactivity = ItemActivity::find($parameters);
        if (count($itemactivity) == 0) {
            $this->flash->notice("The search did not find any item activity");
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemactivity,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
    }

    public function newAction()
    {

    }

    public function editAction($1)
    {

        $request = $this->request;
        if (!$request->isPost()) {

            $1 = $this->filter->sanitize($1, array("int"));

            $itemactivity = ItemActivity::findFirst('1="'.$1.'"');
            if (!$itemactivity) {
                $this->flash->error("item activity was not found");
                return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
            }
            $this->view->setVar("1", $itemactivity->1);
        
            Tag::displayTo("ID", $itemactivity->ID);
            Tag::displayTo("A_NAME", $itemactivity->A_NAME);
            Tag::displayTo("A_TYPE", $itemactivity->A_TYPE);
            Tag::displayTo("A_STARTTIME", $itemactivity->A_STARTTIME);
            Tag::displayTo("A_ENDTIME", $itemactivity->A_ENDTIME);
            Tag::displayTo("A_PLATFORM", $itemactivity->A_PLATFORM);
            Tag::displayTo("IS_VISIBLE", $itemactivity->IS_VISIBLE);
            Tag::displayTo("AUDIT_STATUS", $itemactivity->AUDIT_STATUS);
            Tag::displayTo("A_CONTENT", $itemactivity->A_CONTENT);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

        $itemactivity = new ItemActivity();
        $itemactivity->ID = $this->request->getPost("ID");
        $itemactivity->A_NAME = $this->request->getPost("A_NAME");
        $itemactivity->A_TYPE = $this->request->getPost("A_TYPE");
        $itemactivity->A_STARTTIME = $this->request->getPost("A_STARTTIME");
        $itemactivity->A_ENDTIME = $this->request->getPost("A_ENDTIME");
        $itemactivity->A_PLATFORM = $this->request->getPost("A_PLATFORM");
        $itemactivity->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemactivity->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $itemactivity->A_CONTENT = $this->request->getPost("A_CONTENT");
        if (!$itemactivity->save()) {
            foreach ($itemactivity->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "new"));
        } else {
            $this->flash->success("item activity was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $itemactivity = ItemActivity::findFirst("1='$1'");
        if (!$itemactivity) {
            $this->flash->error("item activity does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }
        $itemactivity->ID = $this->request->getPost("ID");
        $itemactivity->A_NAME = $this->request->getPost("A_NAME");
        $itemactivity->A_TYPE = $this->request->getPost("A_TYPE");
        $itemactivity->A_STARTTIME = $this->request->getPost("A_STARTTIME");
        $itemactivity->A_ENDTIME = $this->request->getPost("A_ENDTIME");
        $itemactivity->A_PLATFORM = $this->request->getPost("A_PLATFORM");
        $itemactivity->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemactivity->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $itemactivity->A_CONTENT = $this->request->getPost("A_CONTENT");
        if (!$itemactivity->save()) {
            foreach ($itemactivity->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "edit", "params" => array($itemactivity->1)));
        } else {
            $this->flash->success("item activity was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $itemactivity = ItemActivity::findFirst('1="'.$1.'"');
        if (!$itemactivity) {
            $this->flash->error("item activity was not found");
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }

        if (!$itemactivity->delete()) {
            foreach ($itemactivity->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "search"));
        } else {
            $this->flash->success("item activity was deleted");
            return $this->dispatcher->forward(array("controller" => "itemactivity", "action" => "index"));
        }
    }

}
