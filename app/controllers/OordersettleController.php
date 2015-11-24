<?php

use \Phalcon\Tag as Tag;

class OOrderSettleController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OOrderSettle", $_POST);
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

        $oordersettle = OOrderSettle::find($parameters);
        if (count($oordersettle) == 0) {
            $this->flash->notice("The search did not find any o order settle");
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oordersettle,
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

            $oordersettle = OOrderSettle::findFirst('1="'.$1.'"');
            if (!$oordersettle) {
                $this->flash->error("o order settle was not found");
                return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
            }
            $this->view->setVar("1", $oordersettle->1);
        
            Tag::displayTo("ORDER_ID", $oordersettle->ORDER_ID);
            Tag::displayTo("SETTLE_STATUS", $oordersettle->SETTLE_STATUS);
            Tag::displayTo("PRE_SETTLE_TIME", $oordersettle->PRE_SETTLE_TIME);
            Tag::displayTo("SETTLE_DONE_TIME", $oordersettle->SETTLE_DONE_TIME);
            Tag::displayTo("PRE_SETTLE_OPERATOR", $oordersettle->PRE_SETTLE_OPERATOR);
            Tag::displayTo("SETTLE_DONE_OPERATOR", $oordersettle->SETTLE_DONE_OPERATOR);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

        $oordersettle = new OOrderSettle();
        $oordersettle->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oordersettle->SETTLE_STATUS = $this->request->getPost("SETTLE_STATUS");
        $oordersettle->PRE_SETTLE_TIME = $this->request->getPost("PRE_SETTLE_TIME");
        $oordersettle->SETTLE_DONE_TIME = $this->request->getPost("SETTLE_DONE_TIME");
        $oordersettle->PRE_SETTLE_OPERATOR = $this->request->getPost("PRE_SETTLE_OPERATOR");
        $oordersettle->SETTLE_DONE_OPERATOR = $this->request->getPost("SETTLE_DONE_OPERATOR");
        if (!$oordersettle->save()) {
            foreach ($oordersettle->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "new"));
        } else {
            $this->flash->success("o order settle was created successfully");
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $oordersettle = OOrderSettle::findFirst("1='$1'");
        if (!$oordersettle) {
            $this->flash->error("o order settle does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }
        $oordersettle->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oordersettle->SETTLE_STATUS = $this->request->getPost("SETTLE_STATUS");
        $oordersettle->PRE_SETTLE_TIME = $this->request->getPost("PRE_SETTLE_TIME");
        $oordersettle->SETTLE_DONE_TIME = $this->request->getPost("SETTLE_DONE_TIME");
        $oordersettle->PRE_SETTLE_OPERATOR = $this->request->getPost("PRE_SETTLE_OPERATOR");
        $oordersettle->SETTLE_DONE_OPERATOR = $this->request->getPost("SETTLE_DONE_OPERATOR");
        if (!$oordersettle->save()) {
            foreach ($oordersettle->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "edit", "params" => array($oordersettle->1)));
        } else {
            $this->flash->success("o order settle was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $oordersettle = OOrderSettle::findFirst('1="'.$1.'"');
        if (!$oordersettle) {
            $this->flash->error("o order settle was not found");
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }

        if (!$oordersettle->delete()) {
            foreach ($oordersettle->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "search"));
        } else {
            $this->flash->success("o order settle was deleted");
            return $this->dispatcher->forward(array("controller" => "oordersettle", "action" => "index"));
        }
    }

}
