<?php

use \Phalcon\Tag as Tag;

class FinanceStatisticItemController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "FinanceStatisticItem", $_POST);
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

        $financestatisticitem = FinanceStatisticItem::find($parameters);
        if (count($financestatisticitem) == 0) {
            $this->flash->notice("The search did not find any finance statistic item");
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $financestatisticitem,
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

            $financestatisticitem = FinanceStatisticItem::findFirst('1="'.$1.'"');
            if (!$financestatisticitem) {
                $this->flash->error("finance statistic item was not found");
                return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
            }
            $this->view->setVar("1", $financestatisticitem->1);
        
            Tag::displayTo("ITEM_NAME", $financestatisticitem->ITEM_NAME);
            Tag::displayTo("COMPANY", $financestatisticitem->COMPANY);
            Tag::displayTo("PLACE", $financestatisticitem->PLACE);
            Tag::displayTo("SHOW_START_TIME", $financestatisticitem->SHOW_START_TIME);
            Tag::displayTo("SHOW_END_TIME", $financestatisticitem->SHOW_END_TIME);
            Tag::displayTo("TICKET_SYS_DIC_ID", $financestatisticitem->TICKET_SYS_DIC_ID);
            Tag::displayTo("CLEARING_PARTY", $financestatisticitem->CLEARING_PARTY);
            Tag::displayTo("IS_CONTACT", $financestatisticitem->IS_CONTACT);
            Tag::displayTo("UPDATE_TIME", $financestatisticitem->UPDATE_TIME);
            Tag::displayTo("UPDATE_USER_ID", $financestatisticitem->UPDATE_USER_ID);
            Tag::displayTo("ID", $financestatisticitem->ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

        $financestatisticitem = new FinanceStatisticItem();
        $financestatisticitem->ITEM_NAME = $this->request->getPost("ITEM_NAME");
        $financestatisticitem->COMPANY = $this->request->getPost("COMPANY");
        $financestatisticitem->PLACE = $this->request->getPost("PLACE");
        $financestatisticitem->SHOW_START_TIME = $this->request->getPost("SHOW_START_TIME");
        $financestatisticitem->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $financestatisticitem->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $financestatisticitem->CLEARING_PARTY = $this->request->getPost("CLEARING_PARTY");
        $financestatisticitem->IS_CONTACT = $this->request->getPost("IS_CONTACT");
        $financestatisticitem->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $financestatisticitem->UPDATE_USER_ID = $this->request->getPost("UPDATE_USER_ID");
        $financestatisticitem->ID = $this->request->getPost("ID");
        if (!$financestatisticitem->save()) {
            foreach ($financestatisticitem->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "new"));
        } else {
            $this->flash->success("finance statistic item was created successfully");
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $financestatisticitem = FinanceStatisticItem::findFirst("1='$1'");
        if (!$financestatisticitem) {
            $this->flash->error("finance statistic item does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }
        $financestatisticitem->ITEM_NAME = $this->request->getPost("ITEM_NAME");
        $financestatisticitem->COMPANY = $this->request->getPost("COMPANY");
        $financestatisticitem->PLACE = $this->request->getPost("PLACE");
        $financestatisticitem->SHOW_START_TIME = $this->request->getPost("SHOW_START_TIME");
        $financestatisticitem->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $financestatisticitem->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $financestatisticitem->CLEARING_PARTY = $this->request->getPost("CLEARING_PARTY");
        $financestatisticitem->IS_CONTACT = $this->request->getPost("IS_CONTACT");
        $financestatisticitem->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $financestatisticitem->UPDATE_USER_ID = $this->request->getPost("UPDATE_USER_ID");
        $financestatisticitem->ID = $this->request->getPost("ID");
        if (!$financestatisticitem->save()) {
            foreach ($financestatisticitem->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "edit", "params" => array($financestatisticitem->1)));
        } else {
            $this->flash->success("finance statistic item was updated successfully");
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $financestatisticitem = FinanceStatisticItem::findFirst('1="'.$1.'"');
        if (!$financestatisticitem) {
            $this->flash->error("finance statistic item was not found");
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }

        if (!$financestatisticitem->delete()) {
            foreach ($financestatisticitem->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "search"));
        } else {
            $this->flash->success("finance statistic item was deleted");
            return $this->dispatcher->forward(array("controller" => "financestatisticitem", "action" => "index"));
        }
    }

}
