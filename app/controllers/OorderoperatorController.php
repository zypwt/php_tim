<?php

use \Phalcon\Tag as Tag;

class OOrderOperatorController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OOrderOperator", $_POST);
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

        $oorderoperator = OOrderOperator::find($parameters);
        if (count($oorderoperator) == 0) {
            $this->flash->notice("The search did not find any o order operator");
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oorderoperator,
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

            $oorderoperator = OOrderOperator::findFirst('ID="'.$ID.'"');
            if (!$oorderoperator) {
                $this->flash->error("o order operator was not found");
                return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
            }
            $this->view->setVar("ID", $oorderoperator->ID);
        
            Tag::displayTo("ID", $oorderoperator->ID);
            Tag::displayTo("ORDER_ID", $oorderoperator->ORDER_ID);
            Tag::displayTo("DEAL_ID", $oorderoperator->DEAL_ID);
            Tag::displayTo("DEAL_AGENCY_ID", $oorderoperator->DEAL_AGENCY_ID);
            Tag::displayTo("PRINT_USER_ID", $oorderoperator->PRINT_USER_ID);
            Tag::displayTo("PRINT_AGENCY_ID", $oorderoperator->PRINT_AGENCY_ID);
            Tag::displayTo("CREATE_USER_ID", $oorderoperator->CREATE_USER_ID);
            Tag::displayTo("CREATE_AGENCY_ID", $oorderoperator->CREATE_AGENCY_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

        $oorderoperator = new OOrderOperator();
        $oorderoperator->ID = $this->request->getPost("ID");
        $oorderoperator->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oorderoperator->DEAL_ID = $this->request->getPost("DEAL_ID");
        $oorderoperator->DEAL_AGENCY_ID = $this->request->getPost("DEAL_AGENCY_ID");
        $oorderoperator->PRINT_USER_ID = $this->request->getPost("PRINT_USER_ID");
        $oorderoperator->PRINT_AGENCY_ID = $this->request->getPost("PRINT_AGENCY_ID");
        $oorderoperator->CREATE_USER_ID = $this->request->getPost("CREATE_USER_ID");
        $oorderoperator->CREATE_AGENCY_ID = $this->request->getPost("CREATE_AGENCY_ID");
        if (!$oorderoperator->save()) {
            foreach ($oorderoperator->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "new"));
        } else {
            $this->flash->success("o order operator was created successfully");
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $oorderoperator = OOrderOperator::findFirst("ID='$ID'");
        if (!$oorderoperator) {
            $this->flash->error("o order operator does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }
        $oorderoperator->ID = $this->request->getPost("ID");
        $oorderoperator->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oorderoperator->DEAL_ID = $this->request->getPost("DEAL_ID");
        $oorderoperator->DEAL_AGENCY_ID = $this->request->getPost("DEAL_AGENCY_ID");
        $oorderoperator->PRINT_USER_ID = $this->request->getPost("PRINT_USER_ID");
        $oorderoperator->PRINT_AGENCY_ID = $this->request->getPost("PRINT_AGENCY_ID");
        $oorderoperator->CREATE_USER_ID = $this->request->getPost("CREATE_USER_ID");
        $oorderoperator->CREATE_AGENCY_ID = $this->request->getPost("CREATE_AGENCY_ID");
        if (!$oorderoperator->save()) {
            foreach ($oorderoperator->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "edit", "params" => array($oorderoperator->ID)));
        } else {
            $this->flash->success("o order operator was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $oorderoperator = OOrderOperator::findFirst('ID="'.$ID.'"');
        if (!$oorderoperator) {
            $this->flash->error("o order operator was not found");
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }

        if (!$oorderoperator->delete()) {
            foreach ($oorderoperator->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "search"));
        } else {
            $this->flash->success("o order operator was deleted");
            return $this->dispatcher->forward(array("controller" => "oorderoperator", "action" => "index"));
        }
    }

}
