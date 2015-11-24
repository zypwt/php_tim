<?php

use \Phalcon\Tag as Tag;

class CDiscountUserLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CDiscountUserLog", $_POST);
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

        $cdiscountuserlog = CDiscountUserLog::find($parameters);
        if (count($cdiscountuserlog) == 0) {
            $this->flash->notice("The search did not find any c discount user log");
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cdiscountuserlog,
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

            $cdiscountuserlog = CDiscountUserLog::findFirst('ID="'.$ID.'"');
            if (!$cdiscountuserlog) {
                $this->flash->error("c discount user log was not found");
                return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
            }
            $this->view->setVar("ID", $cdiscountuserlog->ID);
        
            Tag::displayTo("ID", $cdiscountuserlog->ID);
            Tag::displayTo("USER_ID", $cdiscountuserlog->USER_ID);
            Tag::displayTo("COMM", $cdiscountuserlog->COMM);
            Tag::displayTo("CREATE_TIME", $cdiscountuserlog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

        $cdiscountuserlog = new CDiscountUserLog();
        $cdiscountuserlog->ID = $this->request->getPost("ID");
        $cdiscountuserlog->USER_ID = $this->request->getPost("USER_ID");
        $cdiscountuserlog->COMM = $this->request->getPost("COMM");
        $cdiscountuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$cdiscountuserlog->save()) {
            foreach ($cdiscountuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "new"));
        } else {
            $this->flash->success("c discount user log was created successfully");
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cdiscountuserlog = CDiscountUserLog::findFirst("ID='$ID'");
        if (!$cdiscountuserlog) {
            $this->flash->error("c discount user log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }
        $cdiscountuserlog->ID = $this->request->getPost("ID");
        $cdiscountuserlog->USER_ID = $this->request->getPost("USER_ID");
        $cdiscountuserlog->COMM = $this->request->getPost("COMM");
        $cdiscountuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$cdiscountuserlog->save()) {
            foreach ($cdiscountuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "edit", "params" => array($cdiscountuserlog->ID)));
        } else {
            $this->flash->success("c discount user log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cdiscountuserlog = CDiscountUserLog::findFirst('ID="'.$ID.'"');
        if (!$cdiscountuserlog) {
            $this->flash->error("c discount user log was not found");
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }

        if (!$cdiscountuserlog->delete()) {
            foreach ($cdiscountuserlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "search"));
        } else {
            $this->flash->success("c discount user log was deleted");
            return $this->dispatcher->forward(array("controller" => "cdiscountuserlog", "action" => "index"));
        }
    }

}
