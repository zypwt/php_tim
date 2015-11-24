<?php

use \Phalcon\Tag as Tag;

class POrderFinishLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "POrderFinishLog", $_POST);
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

        $porderfinishlog = POrderFinishLog::find($parameters);
        if (count($porderfinishlog) == 0) {
            $this->flash->notice("The search did not find any p order finish log");
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $porderfinishlog,
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

            $porderfinishlog = POrderFinishLog::findFirst('ID="'.$ID.'"');
            if (!$porderfinishlog) {
                $this->flash->error("p order finish log was not found");
                return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
            }
            $this->view->setVar("ID", $porderfinishlog->ID);
        
            Tag::displayTo("ID", $porderfinishlog->ID);
            Tag::displayTo("TYPE", $porderfinishlog->TYPE);
            Tag::displayTo("CHARGE_NO", $porderfinishlog->CHARGE_NO);
            Tag::displayTo("ORDERNO", $porderfinishlog->ORDERNO);
            Tag::displayTo("OPERATE_NUMBER", $porderfinishlog->OPERATE_NUMBER);
            Tag::displayTo("CREATE_TIME", $porderfinishlog->CREATE_TIME);
            Tag::displayTo("LOG_OPERATE", $porderfinishlog->LOG_OPERATE);
            Tag::displayTo("LOG_CREATE_TIME", $porderfinishlog->LOG_CREATE_TIME);
            Tag::displayTo("PACKAGE_ID", $porderfinishlog->PACKAGE_ID);
            Tag::displayTo("PAYMENT_TIME", $porderfinishlog->PAYMENT_TIME);
            Tag::displayTo("MONEY_BASE_FEN", $porderfinishlog->MONEY_BASE_FEN);
            Tag::displayTo("REFUND_MONEY_BASE_FEN", $porderfinishlog->REFUND_MONEY_BASE_FEN);
            Tag::displayTo("PERSON_UUID", $porderfinishlog->PERSON_UUID);
            Tag::displayTo("PERSON_NAME", $porderfinishlog->PERSON_NAME);
            Tag::displayTo("PERSON_AGENCY_ID", $porderfinishlog->PERSON_AGENCY_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

        $porderfinishlog = new POrderFinishLog();
        $porderfinishlog->ID = $this->request->getPost("ID");
        $porderfinishlog->TYPE = $this->request->getPost("TYPE");
        $porderfinishlog->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $porderfinishlog->ORDERNO = $this->request->getPost("ORDERNO");
        $porderfinishlog->OPERATE_NUMBER = $this->request->getPost("OPERATE_NUMBER");
        $porderfinishlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $porderfinishlog->LOG_OPERATE = $this->request->getPost("LOG_OPERATE");
        $porderfinishlog->LOG_CREATE_TIME = $this->request->getPost("LOG_CREATE_TIME");
        $porderfinishlog->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $porderfinishlog->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $porderfinishlog->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $porderfinishlog->REFUND_MONEY_BASE_FEN = $this->request->getPost("REFUND_MONEY_BASE_FEN");
        $porderfinishlog->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $porderfinishlog->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $porderfinishlog->PERSON_AGENCY_ID = $this->request->getPost("PERSON_AGENCY_ID");
        if (!$porderfinishlog->save()) {
            foreach ($porderfinishlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "new"));
        } else {
            $this->flash->success("p order finish log was created successfully");
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $porderfinishlog = POrderFinishLog::findFirst("ID='$ID'");
        if (!$porderfinishlog) {
            $this->flash->error("p order finish log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }
        $porderfinishlog->ID = $this->request->getPost("ID");
        $porderfinishlog->TYPE = $this->request->getPost("TYPE");
        $porderfinishlog->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $porderfinishlog->ORDERNO = $this->request->getPost("ORDERNO");
        $porderfinishlog->OPERATE_NUMBER = $this->request->getPost("OPERATE_NUMBER");
        $porderfinishlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $porderfinishlog->LOG_OPERATE = $this->request->getPost("LOG_OPERATE");
        $porderfinishlog->LOG_CREATE_TIME = $this->request->getPost("LOG_CREATE_TIME");
        $porderfinishlog->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $porderfinishlog->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $porderfinishlog->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $porderfinishlog->REFUND_MONEY_BASE_FEN = $this->request->getPost("REFUND_MONEY_BASE_FEN");
        $porderfinishlog->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $porderfinishlog->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $porderfinishlog->PERSON_AGENCY_ID = $this->request->getPost("PERSON_AGENCY_ID");
        if (!$porderfinishlog->save()) {
            foreach ($porderfinishlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "edit", "params" => array($porderfinishlog->ID)));
        } else {
            $this->flash->success("p order finish log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $porderfinishlog = POrderFinishLog::findFirst('ID="'.$ID.'"');
        if (!$porderfinishlog) {
            $this->flash->error("p order finish log was not found");
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }

        if (!$porderfinishlog->delete()) {
            foreach ($porderfinishlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "search"));
        } else {
            $this->flash->success("p order finish log was deleted");
            return $this->dispatcher->forward(array("controller" => "porderfinishlog", "action" => "index"));
        }
    }

}
