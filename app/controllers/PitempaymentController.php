<?php

use \Phalcon\Tag as Tag;

class PItemPaymentController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PItemPayment", $_POST);
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

        $pitempayment = PItemPayment::find($parameters);
        if (count($pitempayment) == 0) {
            $this->flash->notice("The search did not find any p item payment");
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $pitempayment,
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

            $pitempayment = PItemPayment::findFirst('ID="'.$ID.'"');
            if (!$pitempayment) {
                $this->flash->error("p item payment was not found");
                return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
            }
            $this->view->setVar("ID", $pitempayment->ID);
        
            Tag::displayTo("ID", $pitempayment->ID);
            Tag::displayTo("TYPE_ID", $pitempayment->TYPE_ID);
            Tag::displayTo("ITEM_ID", $pitempayment->ITEM_ID);
            Tag::displayTo("PARTY_ID", $pitempayment->PARTY_ID);
            Tag::displayTo("AGENCY_ID", $pitempayment->AGENCY_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

        $pitempayment = new PItemPayment();
        $pitempayment->ID = $this->request->getPost("ID");
        $pitempayment->TYPE_ID = $this->request->getPost("TYPE_ID");
        $pitempayment->ITEM_ID = $this->request->getPost("ITEM_ID");
        $pitempayment->PARTY_ID = $this->request->getPost("PARTY_ID");
        $pitempayment->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        if (!$pitempayment->save()) {
            foreach ($pitempayment->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "new"));
        } else {
            $this->flash->success("p item payment was created successfully");
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $pitempayment = PItemPayment::findFirst("ID='$ID'");
        if (!$pitempayment) {
            $this->flash->error("p item payment does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }
        $pitempayment->ID = $this->request->getPost("ID");
        $pitempayment->TYPE_ID = $this->request->getPost("TYPE_ID");
        $pitempayment->ITEM_ID = $this->request->getPost("ITEM_ID");
        $pitempayment->PARTY_ID = $this->request->getPost("PARTY_ID");
        $pitempayment->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        if (!$pitempayment->save()) {
            foreach ($pitempayment->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "edit", "params" => array($pitempayment->ID)));
        } else {
            $this->flash->success("p item payment was updated successfully");
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $pitempayment = PItemPayment::findFirst('ID="'.$ID.'"');
        if (!$pitempayment) {
            $this->flash->error("p item payment was not found");
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }

        if (!$pitempayment->delete()) {
            foreach ($pitempayment->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "search"));
        } else {
            $this->flash->success("p item payment was deleted");
            return $this->dispatcher->forward(array("controller" => "pitempayment", "action" => "index"));
        }
    }

}
