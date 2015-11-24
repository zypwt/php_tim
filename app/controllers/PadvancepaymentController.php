<?php

use \Phalcon\Tag as Tag;

class PAdvancePaymentController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PAdvancePayment", $_POST);
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

        $padvancepayment = PAdvancePayment::find($parameters);
        if (count($padvancepayment) == 0) {
            $this->flash->notice("The search did not find any p advance payment");
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $padvancepayment,
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

            $padvancepayment = PAdvancePayment::findFirst('ID="'.$ID.'"');
            if (!$padvancepayment) {
                $this->flash->error("p advance payment was not found");
                return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
            }
            $this->view->setVar("ID", $padvancepayment->ID);
        
            Tag::displayTo("ID", $padvancepayment->ID);
            Tag::displayTo("UUID", $padvancepayment->UUID);
            Tag::displayTo("MONEY", $padvancepayment->MONEY);
            Tag::displayTo("CREATE_TIME", $padvancepayment->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $padvancepayment->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

        $padvancepayment = new PAdvancePayment();
        $padvancepayment->ID = $this->request->getPost("ID");
        $padvancepayment->UUID = $this->request->getPost("UUID");
        $padvancepayment->MONEY = $this->request->getPost("MONEY");
        $padvancepayment->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $padvancepayment->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$padvancepayment->save()) {
            foreach ($padvancepayment->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "new"));
        } else {
            $this->flash->success("p advance payment was created successfully");
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $padvancepayment = PAdvancePayment::findFirst("ID='$ID'");
        if (!$padvancepayment) {
            $this->flash->error("p advance payment does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }
        $padvancepayment->ID = $this->request->getPost("ID");
        $padvancepayment->UUID = $this->request->getPost("UUID");
        $padvancepayment->MONEY = $this->request->getPost("MONEY");
        $padvancepayment->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $padvancepayment->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$padvancepayment->save()) {
            foreach ($padvancepayment->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "edit", "params" => array($padvancepayment->ID)));
        } else {
            $this->flash->success("p advance payment was updated successfully");
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $padvancepayment = PAdvancePayment::findFirst('ID="'.$ID.'"');
        if (!$padvancepayment) {
            $this->flash->error("p advance payment was not found");
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }

        if (!$padvancepayment->delete()) {
            foreach ($padvancepayment->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "search"));
        } else {
            $this->flash->success("p advance payment was deleted");
            return $this->dispatcher->forward(array("controller" => "padvancepayment", "action" => "index"));
        }
    }

}
