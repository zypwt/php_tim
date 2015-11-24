<?php

use \Phalcon\Tag as Tag;

class PPaymentChargeSuccController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PPaymentChargeSucc", $_POST);
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

        $ppaymentchargesucc = PPaymentChargeSucc::find($parameters);
        if (count($ppaymentchargesucc) == 0) {
            $this->flash->notice("The search did not find any p payment charge succ");
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ppaymentchargesucc,
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

            $ppaymentchargesucc = PPaymentChargeSucc::findFirst('1="'.$1.'"');
            if (!$ppaymentchargesucc) {
                $this->flash->error("p payment charge succ was not found");
                return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
            }
            $this->view->setVar("1", $ppaymentchargesucc->1);
        
            Tag::displayTo("ID", $ppaymentchargesucc->ID);
            Tag::displayTo("CHARGE_NO", $ppaymentchargesucc->CHARGE_NO);
            Tag::displayTo("ORDER_ID", $ppaymentchargesucc->ORDER_ID);
            Tag::displayTo("PARTNER_ORDER_NO", $ppaymentchargesucc->PARTNER_ORDER_NO);
            Tag::displayTo("PARTY_ID", $ppaymentchargesucc->PARTY_ID);
            Tag::displayTo("MONEY_BASE_FEN", $ppaymentchargesucc->MONEY_BASE_FEN);
            Tag::displayTo("PAYMENT_STATUS", $ppaymentchargesucc->PAYMENT_STATUS);
            Tag::displayTo("PAYMENT_TIME", $ppaymentchargesucc->PAYMENT_TIME);
            Tag::displayTo("TYPE_ID", $ppaymentchargesucc->TYPE_ID);
            Tag::displayTo("CUSTOMER_IP", $ppaymentchargesucc->CUSTOMER_IP);
            Tag::displayTo("CREATE_TIME", $ppaymentchargesucc->CREATE_TIME);
            Tag::displayTo("UUID", $ppaymentchargesucc->UUID);
            Tag::displayTo("AGENCY_ID", $ppaymentchargesucc->AGENCY_ID);
            Tag::displayTo("PAY_TYPE", $ppaymentchargesucc->PAY_TYPE);
            Tag::displayTo("PACKAGE_ID", $ppaymentchargesucc->PACKAGE_ID);
            Tag::displayTo("RECEIPT", $ppaymentchargesucc->RECEIPT);
            Tag::displayTo("PAYMENT_CLASS", $ppaymentchargesucc->PAYMENT_CLASS);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

        $ppaymentchargesucc = new PPaymentChargeSucc();
        $ppaymentchargesucc->ID = $this->request->getPost("ID");
        $ppaymentchargesucc->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $ppaymentchargesucc->ORDER_ID = $this->request->getPost("ORDER_ID");
        $ppaymentchargesucc->PARTNER_ORDER_NO = $this->request->getPost("PARTNER_ORDER_NO");
        $ppaymentchargesucc->PARTY_ID = $this->request->getPost("PARTY_ID");
        $ppaymentchargesucc->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $ppaymentchargesucc->PAYMENT_STATUS = $this->request->getPost("PAYMENT_STATUS");
        $ppaymentchargesucc->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $ppaymentchargesucc->TYPE_ID = $this->request->getPost("TYPE_ID");
        $ppaymentchargesucc->CUSTOMER_IP = $this->request->getPost("CUSTOMER_IP");
        $ppaymentchargesucc->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymentchargesucc->UUID = $this->request->getPost("UUID");
        $ppaymentchargesucc->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $ppaymentchargesucc->PAY_TYPE = $this->request->getPost("PAY_TYPE");
        $ppaymentchargesucc->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $ppaymentchargesucc->RECEIPT = $this->request->getPost("RECEIPT");
        $ppaymentchargesucc->PAYMENT_CLASS = $this->request->getPost("PAYMENT_CLASS");
        if (!$ppaymentchargesucc->save()) {
            foreach ($ppaymentchargesucc->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "new"));
        } else {
            $this->flash->success("p payment charge succ was created successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $ppaymentchargesucc = PPaymentChargeSucc::findFirst("1='$1'");
        if (!$ppaymentchargesucc) {
            $this->flash->error("p payment charge succ does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }
        $ppaymentchargesucc->ID = $this->request->getPost("ID");
        $ppaymentchargesucc->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $ppaymentchargesucc->ORDER_ID = $this->request->getPost("ORDER_ID");
        $ppaymentchargesucc->PARTNER_ORDER_NO = $this->request->getPost("PARTNER_ORDER_NO");
        $ppaymentchargesucc->PARTY_ID = $this->request->getPost("PARTY_ID");
        $ppaymentchargesucc->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $ppaymentchargesucc->PAYMENT_STATUS = $this->request->getPost("PAYMENT_STATUS");
        $ppaymentchargesucc->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $ppaymentchargesucc->TYPE_ID = $this->request->getPost("TYPE_ID");
        $ppaymentchargesucc->CUSTOMER_IP = $this->request->getPost("CUSTOMER_IP");
        $ppaymentchargesucc->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymentchargesucc->UUID = $this->request->getPost("UUID");
        $ppaymentchargesucc->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $ppaymentchargesucc->PAY_TYPE = $this->request->getPost("PAY_TYPE");
        $ppaymentchargesucc->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $ppaymentchargesucc->RECEIPT = $this->request->getPost("RECEIPT");
        $ppaymentchargesucc->PAYMENT_CLASS = $this->request->getPost("PAYMENT_CLASS");
        if (!$ppaymentchargesucc->save()) {
            foreach ($ppaymentchargesucc->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "edit", "params" => array($ppaymentchargesucc->1)));
        } else {
            $this->flash->success("p payment charge succ was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $ppaymentchargesucc = PPaymentChargeSucc::findFirst('1="'.$1.'"');
        if (!$ppaymentchargesucc) {
            $this->flash->error("p payment charge succ was not found");
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }

        if (!$ppaymentchargesucc->delete()) {
            foreach ($ppaymentchargesucc->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "search"));
        } else {
            $this->flash->success("p payment charge succ was deleted");
            return $this->dispatcher->forward(array("controller" => "ppaymentchargesucc", "action" => "index"));
        }
    }

}
