<?php

use \Phalcon\Tag as Tag;

class PanicBuyTicketController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PanicBuyTicket", $_POST);
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

        $panicbuyticket = PanicBuyTicket::find($parameters);
        if (count($panicbuyticket) == 0) {
            $this->flash->notice("The search did not find any panic buy ticket");
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $panicbuyticket,
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

            $panicbuyticket = PanicBuyTicket::findFirst('ID="'.$ID.'"');
            if (!$panicbuyticket) {
                $this->flash->error("panic buy ticket was not found");
                return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
            }
            $this->view->setVar("ID", $panicbuyticket->ID);
        
            Tag::displayTo("ID", $panicbuyticket->ID);
            Tag::displayTo("SCENE_ID", $panicbuyticket->SCENE_ID);
            Tag::displayTo("ITEM_ID", $panicbuyticket->ITEM_ID);
            Tag::displayTo("STATUS", $panicbuyticket->STATUS);
            Tag::displayTo("IS_VISIBLE", $panicbuyticket->IS_VISIBLE);
            Tag::displayTo("CREATE_TIME", $panicbuyticket->CREATE_TIME);
            Tag::displayTo("CREATE_UUID", $panicbuyticket->CREATE_UUID);
            Tag::displayTo("UPDATE_TIME", $panicbuyticket->UPDATE_TIME);
            Tag::displayTo("UPDATE_UUID", $panicbuyticket->UPDATE_UUID);
            Tag::displayTo("SELL_NUM", $panicbuyticket->SELL_NUM);
            Tag::displayTo("SYNC_SELL_NUM", $panicbuyticket->SYNC_SELL_NUM);
            Tag::displayTo("START_TIME", $panicbuyticket->START_TIME);
            Tag::displayTo("END_TIME", $panicbuyticket->END_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

        $panicbuyticket = new PanicBuyTicket();
        $panicbuyticket->ID = $this->request->getPost("ID");
        $panicbuyticket->SCENE_ID = $this->request->getPost("SCENE_ID");
        $panicbuyticket->ITEM_ID = $this->request->getPost("ITEM_ID");
        $panicbuyticket->STATUS = $this->request->getPost("STATUS");
        $panicbuyticket->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $panicbuyticket->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $panicbuyticket->CREATE_UUID = $this->request->getPost("CREATE_UUID");
        $panicbuyticket->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $panicbuyticket->UPDATE_UUID = $this->request->getPost("UPDATE_UUID");
        $panicbuyticket->SELL_NUM = $this->request->getPost("SELL_NUM");
        $panicbuyticket->SYNC_SELL_NUM = $this->request->getPost("SYNC_SELL_NUM");
        $panicbuyticket->START_TIME = $this->request->getPost("START_TIME");
        $panicbuyticket->END_TIME = $this->request->getPost("END_TIME");
        if (!$panicbuyticket->save()) {
            foreach ($panicbuyticket->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "new"));
        } else {
            $this->flash->success("panic buy ticket was created successfully");
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $panicbuyticket = PanicBuyTicket::findFirst("ID='$ID'");
        if (!$panicbuyticket) {
            $this->flash->error("panic buy ticket does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }
        $panicbuyticket->ID = $this->request->getPost("ID");
        $panicbuyticket->SCENE_ID = $this->request->getPost("SCENE_ID");
        $panicbuyticket->ITEM_ID = $this->request->getPost("ITEM_ID");
        $panicbuyticket->STATUS = $this->request->getPost("STATUS");
        $panicbuyticket->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $panicbuyticket->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $panicbuyticket->CREATE_UUID = $this->request->getPost("CREATE_UUID");
        $panicbuyticket->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $panicbuyticket->UPDATE_UUID = $this->request->getPost("UPDATE_UUID");
        $panicbuyticket->SELL_NUM = $this->request->getPost("SELL_NUM");
        $panicbuyticket->SYNC_SELL_NUM = $this->request->getPost("SYNC_SELL_NUM");
        $panicbuyticket->START_TIME = $this->request->getPost("START_TIME");
        $panicbuyticket->END_TIME = $this->request->getPost("END_TIME");
        if (!$panicbuyticket->save()) {
            foreach ($panicbuyticket->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "edit", "params" => array($panicbuyticket->ID)));
        } else {
            $this->flash->success("panic buy ticket was updated successfully");
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $panicbuyticket = PanicBuyTicket::findFirst('ID="'.$ID.'"');
        if (!$panicbuyticket) {
            $this->flash->error("panic buy ticket was not found");
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }

        if (!$panicbuyticket->delete()) {
            foreach ($panicbuyticket->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "search"));
        } else {
            $this->flash->success("panic buy ticket was deleted");
            return $this->dispatcher->forward(array("controller" => "panicbuyticket", "action" => "index"));
        }
    }

}
