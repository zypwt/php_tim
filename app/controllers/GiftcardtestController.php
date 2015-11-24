<?php

use \Phalcon\Tag as Tag;

class GiftCardTestController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "GiftCardTest", $_POST);
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

        $giftcardtest = GiftCardTest::find($parameters);
        if (count($giftcardtest) == 0) {
            $this->flash->notice("The search did not find any gift card test");
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $giftcardtest,
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

            $giftcardtest = GiftCardTest::findFirst('1="'.$1.'"');
            if (!$giftcardtest) {
                $this->flash->error("gift card test was not found");
                return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
            }
            $this->view->setVar("1", $giftcardtest->1);
        
            Tag::displayTo("CARD_NO", $giftcardtest->CARD_NO);
            Tag::displayTo("CARD_PWD", $giftcardtest->CARD_PWD);
            Tag::displayTo("CARD_TYPE", $giftcardtest->CARD_TYPE);
            Tag::displayTo("CARD_PRICE", $giftcardtest->CARD_PRICE);
            Tag::displayTo("CREATE_TIME", $giftcardtest->CREATE_TIME);
            Tag::displayTo("END_TIME", $giftcardtest->END_TIME);
            Tag::displayTo("PERSON_UUID", $giftcardtest->PERSON_UUID);
            Tag::displayTo("PARTY_ID", $giftcardtest->PARTY_ID);
            Tag::displayTo("IS_USE", $giftcardtest->IS_USE);
            Tag::displayTo("BATCH_NUMBER", $giftcardtest->BATCH_NUMBER);
            Tag::displayTo("CARD_NAME", $giftcardtest->CARD_NAME);
            Tag::displayTo("SALE_PRICE", $giftcardtest->SALE_PRICE);
            Tag::displayTo("START_TIME", $giftcardtest->START_TIME);
            Tag::displayTo("REMARK", $giftcardtest->REMARK);
            Tag::displayTo("AUDIT_STATUS", $giftcardtest->AUDIT_STATUS);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

        $giftcardtest = new GiftCardTest();
        $giftcardtest->CARD_NO = $this->request->getPost("CARD_NO");
        $giftcardtest->CARD_PWD = $this->request->getPost("CARD_PWD");
        $giftcardtest->CARD_TYPE = $this->request->getPost("CARD_TYPE");
        $giftcardtest->CARD_PRICE = $this->request->getPost("CARD_PRICE");
        $giftcardtest->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $giftcardtest->END_TIME = $this->request->getPost("END_TIME");
        $giftcardtest->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $giftcardtest->PARTY_ID = $this->request->getPost("PARTY_ID");
        $giftcardtest->IS_USE = $this->request->getPost("IS_USE");
        $giftcardtest->BATCH_NUMBER = $this->request->getPost("BATCH_NUMBER");
        $giftcardtest->CARD_NAME = $this->request->getPost("CARD_NAME");
        $giftcardtest->SALE_PRICE = $this->request->getPost("SALE_PRICE");
        $giftcardtest->START_TIME = $this->request->getPost("START_TIME");
        $giftcardtest->REMARK = $this->request->getPost("REMARK");
        $giftcardtest->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        if (!$giftcardtest->save()) {
            foreach ($giftcardtest->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "new"));
        } else {
            $this->flash->success("gift card test was created successfully");
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $giftcardtest = GiftCardTest::findFirst("1='$1'");
        if (!$giftcardtest) {
            $this->flash->error("gift card test does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }
        $giftcardtest->CARD_NO = $this->request->getPost("CARD_NO");
        $giftcardtest->CARD_PWD = $this->request->getPost("CARD_PWD");
        $giftcardtest->CARD_TYPE = $this->request->getPost("CARD_TYPE");
        $giftcardtest->CARD_PRICE = $this->request->getPost("CARD_PRICE");
        $giftcardtest->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $giftcardtest->END_TIME = $this->request->getPost("END_TIME");
        $giftcardtest->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $giftcardtest->PARTY_ID = $this->request->getPost("PARTY_ID");
        $giftcardtest->IS_USE = $this->request->getPost("IS_USE");
        $giftcardtest->BATCH_NUMBER = $this->request->getPost("BATCH_NUMBER");
        $giftcardtest->CARD_NAME = $this->request->getPost("CARD_NAME");
        $giftcardtest->SALE_PRICE = $this->request->getPost("SALE_PRICE");
        $giftcardtest->START_TIME = $this->request->getPost("START_TIME");
        $giftcardtest->REMARK = $this->request->getPost("REMARK");
        $giftcardtest->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        if (!$giftcardtest->save()) {
            foreach ($giftcardtest->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "edit", "params" => array($giftcardtest->1)));
        } else {
            $this->flash->success("gift card test was updated successfully");
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $giftcardtest = GiftCardTest::findFirst('1="'.$1.'"');
        if (!$giftcardtest) {
            $this->flash->error("gift card test was not found");
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }

        if (!$giftcardtest->delete()) {
            foreach ($giftcardtest->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "search"));
        } else {
            $this->flash->success("gift card test was deleted");
            return $this->dispatcher->forward(array("controller" => "giftcardtest", "action" => "index"));
        }
    }

}
