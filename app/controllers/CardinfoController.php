<?php

use \Phalcon\Tag as Tag;

class CardInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CardInfo", $_POST);
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

        $cardinfo = CardInfo::find($parameters);
        if (count($cardinfo) == 0) {
            $this->flash->notice("The search did not find any card info");
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cardinfo,
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

            $cardinfo = CardInfo::findFirst('ID="'.$ID.'"');
            if (!$cardinfo) {
                $this->flash->error("card info was not found");
                return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $cardinfo->ID);
        
            Tag::displayTo("ID", $cardinfo->ID);
            Tag::displayTo("BATCH_ID", $cardinfo->BATCH_ID);
            Tag::displayTo("CARD_NO", $cardinfo->CARD_NO);
            Tag::displayTo("CARD_PWD", $cardinfo->CARD_PWD);
            Tag::displayTo("AUDIT_STATUS", $cardinfo->AUDIT_STATUS);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

        $cardinfo = new CardInfo();
        $cardinfo->ID = $this->request->getPost("ID");
        $cardinfo->BATCH_ID = $this->request->getPost("BATCH_ID");
        $cardinfo->CARD_NO = $this->request->getPost("CARD_NO");
        $cardinfo->CARD_PWD = $this->request->getPost("CARD_PWD");
        $cardinfo->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        if (!$cardinfo->save()) {
            foreach ($cardinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "new"));
        } else {
            $this->flash->success("card info was created successfully");
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cardinfo = CardInfo::findFirst("ID='$ID'");
        if (!$cardinfo) {
            $this->flash->error("card info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }
        $cardinfo->ID = $this->request->getPost("ID");
        $cardinfo->BATCH_ID = $this->request->getPost("BATCH_ID");
        $cardinfo->CARD_NO = $this->request->getPost("CARD_NO");
        $cardinfo->CARD_PWD = $this->request->getPost("CARD_PWD");
        $cardinfo->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        if (!$cardinfo->save()) {
            foreach ($cardinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "edit", "params" => array($cardinfo->ID)));
        } else {
            $this->flash->success("card info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cardinfo = CardInfo::findFirst('ID="'.$ID.'"');
        if (!$cardinfo) {
            $this->flash->error("card info was not found");
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }

        if (!$cardinfo->delete()) {
            foreach ($cardinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "search"));
        } else {
            $this->flash->success("card info was deleted");
            return $this->dispatcher->forward(array("controller" => "cardinfo", "action" => "index"));
        }
    }

}
