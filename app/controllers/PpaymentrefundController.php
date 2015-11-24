<?php

use \Phalcon\Tag as Tag;

class PPaymentRefundController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PPaymentRefund", $_POST);
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

        $ppaymentrefund = PPaymentRefund::find($parameters);
        if (count($ppaymentrefund) == 0) {
            $this->flash->notice("The search did not find any p payment refund");
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ppaymentrefund,
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

            $ppaymentrefund = PPaymentRefund::findFirst('1="'.$1.'"');
            if (!$ppaymentrefund) {
                $this->flash->error("p payment refund was not found");
                return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
            }
            $this->view->setVar("1", $ppaymentrefund->1);
        
            Tag::displayTo("BATCH_NO", $ppaymentrefund->BATCH_NO);
            Tag::displayTo("PACKAGE_ID", $ppaymentrefund->PACKAGE_ID);
            Tag::displayTo("PARTNER_ORDER_NO", $ppaymentrefund->PARTNER_ORDER_NO);
            Tag::displayTo("MONEY_BASE_FEN", $ppaymentrefund->MONEY_BASE_FEN);
            Tag::displayTo("REFUND_MONEY_BASE_FEN", $ppaymentrefund->REFUND_MONEY_BASE_FEN);
            Tag::displayTo("REASON", $ppaymentrefund->REASON);
            Tag::displayTo("NOTIFY_STATUS", $ppaymentrefund->NOTIFY_STATUS);
            Tag::displayTo("REFUND_TIME", $ppaymentrefund->REFUND_TIME);
            Tag::displayTo("TYPE_ID", $ppaymentrefund->TYPE_ID);
            Tag::displayTo("PAYMENT_TIME", $ppaymentrefund->PAYMENT_TIME);
            Tag::displayTo("CREATE_TIME", $ppaymentrefund->CREATE_TIME);
            Tag::displayTo("CHARGE_NO", $ppaymentrefund->CHARGE_NO);
            Tag::displayTo("PERSON_UUID", $ppaymentrefund->PERSON_UUID);
            Tag::displayTo("PERSON_NAME", $ppaymentrefund->PERSON_NAME);
            Tag::displayTo("PERSON_AGENCY_ID", $ppaymentrefund->PERSON_AGENCY_ID);
            Tag::displayTo("ID", $ppaymentrefund->ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

        $ppaymentrefund = new PPaymentRefund();
        $ppaymentrefund->BATCH_NO = $this->request->getPost("BATCH_NO");
        $ppaymentrefund->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $ppaymentrefund->PARTNER_ORDER_NO = $this->request->getPost("PARTNER_ORDER_NO");
        $ppaymentrefund->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $ppaymentrefund->REFUND_MONEY_BASE_FEN = $this->request->getPost("REFUND_MONEY_BASE_FEN");
        $ppaymentrefund->REASON = $this->request->getPost("REASON");
        $ppaymentrefund->NOTIFY_STATUS = $this->request->getPost("NOTIFY_STATUS");
        $ppaymentrefund->REFUND_TIME = $this->request->getPost("REFUND_TIME");
        $ppaymentrefund->TYPE_ID = $this->request->getPost("TYPE_ID");
        $ppaymentrefund->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $ppaymentrefund->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymentrefund->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $ppaymentrefund->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $ppaymentrefund->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $ppaymentrefund->PERSON_AGENCY_ID = $this->request->getPost("PERSON_AGENCY_ID");
        $ppaymentrefund->ID = $this->request->getPost("ID");
        if (!$ppaymentrefund->save()) {
            foreach ($ppaymentrefund->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "new"));
        } else {
            $this->flash->success("p payment refund was created successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $ppaymentrefund = PPaymentRefund::findFirst("1='$1'");
        if (!$ppaymentrefund) {
            $this->flash->error("p payment refund does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }
        $ppaymentrefund->BATCH_NO = $this->request->getPost("BATCH_NO");
        $ppaymentrefund->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $ppaymentrefund->PARTNER_ORDER_NO = $this->request->getPost("PARTNER_ORDER_NO");
        $ppaymentrefund->MONEY_BASE_FEN = $this->request->getPost("MONEY_BASE_FEN");
        $ppaymentrefund->REFUND_MONEY_BASE_FEN = $this->request->getPost("REFUND_MONEY_BASE_FEN");
        $ppaymentrefund->REASON = $this->request->getPost("REASON");
        $ppaymentrefund->NOTIFY_STATUS = $this->request->getPost("NOTIFY_STATUS");
        $ppaymentrefund->REFUND_TIME = $this->request->getPost("REFUND_TIME");
        $ppaymentrefund->TYPE_ID = $this->request->getPost("TYPE_ID");
        $ppaymentrefund->PAYMENT_TIME = $this->request->getPost("PAYMENT_TIME");
        $ppaymentrefund->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymentrefund->CHARGE_NO = $this->request->getPost("CHARGE_NO");
        $ppaymentrefund->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $ppaymentrefund->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $ppaymentrefund->PERSON_AGENCY_ID = $this->request->getPost("PERSON_AGENCY_ID");
        $ppaymentrefund->ID = $this->request->getPost("ID");
        if (!$ppaymentrefund->save()) {
            foreach ($ppaymentrefund->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "edit", "params" => array($ppaymentrefund->1)));
        } else {
            $this->flash->success("p payment refund was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $ppaymentrefund = PPaymentRefund::findFirst('1="'.$1.'"');
        if (!$ppaymentrefund) {
            $this->flash->error("p payment refund was not found");
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }

        if (!$ppaymentrefund->delete()) {
            foreach ($ppaymentrefund->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "search"));
        } else {
            $this->flash->success("p payment refund was deleted");
            return $this->dispatcher->forward(array("controller" => "ppaymentrefund", "action" => "index"));
        }
    }

}
