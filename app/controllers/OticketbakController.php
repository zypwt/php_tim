<?php

use \Phalcon\Tag as Tag;

class OTicketBakController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OTicketBak", $_POST);
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

        $oticketbak = OTicketBak::find($parameters);
        if (count($oticketbak) == 0) {
            $this->flash->notice("The search did not find any o ticket bak");
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oticketbak,
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

            $oticketbak = OTicketBak::findFirst('1="'.$1.'"');
            if (!$oticketbak) {
                $this->flash->error("o ticket bak was not found");
                return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
            }
            $this->view->setVar("1", $oticketbak->1);
        
            Tag::displayTo("ID", $oticketbak->ID);
            Tag::displayTo("ORDER_ID", $oticketbak->ORDER_ID);
            Tag::displayTo("UUID", $oticketbak->UUID);
            Tag::displayTo("USERNAME", $oticketbak->USERNAME);
            Tag::displayTo("PRICE_INFO_ID", $oticketbak->PRICE_INFO_ID);
            Tag::displayTo("PRICE", $oticketbak->PRICE);
            Tag::displayTo("PRICE_LEVEL", $oticketbak->PRICE_LEVEL);
            Tag::displayTo("TICKET_NAME", $oticketbak->TICKET_NAME);
            Tag::displayTo("TICKET_TYPE", $oticketbak->TICKET_TYPE);
            Tag::displayTo("VENUES_ID", $oticketbak->VENUES_ID);
            Tag::displayTo("SCENE_ID", $oticketbak->SCENE_ID);
            Tag::displayTo("TICKET_NUM", $oticketbak->TICKET_NUM);
            Tag::displayTo("SEATS", $oticketbak->SEATS);
            Tag::displayTo("DISCOUNT", $oticketbak->DISCOUNT);
            Tag::displayTo("DISCOUNT_MONEY", $oticketbak->DISCOUNT_MONEY);
            Tag::displayTo("MONEY", $oticketbak->MONEY);
            Tag::displayTo("TICKET_SOURCE", $oticketbak->TICKET_SOURCE);
            Tag::displayTo("PIAOWU_ORDER_ID", $oticketbak->PIAOWU_ORDER_ID);
            Tag::displayTo("ITEM_TYPE_ID", $oticketbak->ITEM_TYPE_ID);
            Tag::displayTo("ITEM_ID", $oticketbak->ITEM_ID);
            Tag::displayTo("ONLINE_ID", $oticketbak->ONLINE_ID);
            Tag::displayTo("ITEM_SOURCE", $oticketbak->ITEM_SOURCE);
            Tag::displayTo("ITEM_CITY_ID", $oticketbak->ITEM_CITY_ID);
            Tag::displayTo("SELL_TYPE", $oticketbak->SELL_TYPE);
            Tag::displayTo("TICKET_STATUS", $oticketbak->TICKET_STATUS);
            Tag::displayTo("TICKET_PACKAGE", $oticketbak->TICKET_PACKAGE);
            Tag::displayTo("TICKET_PACKAGE_PRICE", $oticketbak->TICKET_PACKAGE_PRICE);
            Tag::displayTo("PIAOWU_XSZC", $oticketbak->PIAOWU_XSZC);
            Tag::displayTo("PIAOWU_ZYZK", $oticketbak->PIAOWU_ZYZK);
            Tag::displayTo("SOLD_TIME", $oticketbak->SOLD_TIME);
            Tag::displayTo("UPDATE_TIME", $oticketbak->UPDATE_TIME);
            Tag::displayTo("CREATE_TIME", $oticketbak->CREATE_TIME);
            Tag::displayTo("ITEM_AGENCY_ID", $oticketbak->ITEM_AGENCY_ID);
            Tag::displayTo("ITEM_ONLINE_CITY_ID", $oticketbak->ITEM_ONLINE_CITY_ID);
            Tag::displayTo("SEAT_NAME", $oticketbak->SEAT_NAME);
            Tag::displayTo("SEAT_NUM", $oticketbak->SEAT_NUM);
            Tag::displayTo("COST_PRICE", $oticketbak->COST_PRICE);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

        $oticketbak = new OTicketBak();
        $oticketbak->ID = $this->request->getPost("ID");
        $oticketbak->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oticketbak->UUID = $this->request->getPost("UUID");
        $oticketbak->USERNAME = $this->request->getPost("USERNAME");
        $oticketbak->PRICE_INFO_ID = $this->request->getPost("PRICE_INFO_ID");
        $oticketbak->PRICE = $this->request->getPost("PRICE");
        $oticketbak->PRICE_LEVEL = $this->request->getPost("PRICE_LEVEL");
        $oticketbak->TICKET_NAME = $this->request->getPost("TICKET_NAME");
        $oticketbak->TICKET_TYPE = $this->request->getPost("TICKET_TYPE");
        $oticketbak->VENUES_ID = $this->request->getPost("VENUES_ID");
        $oticketbak->SCENE_ID = $this->request->getPost("SCENE_ID");
        $oticketbak->TICKET_NUM = $this->request->getPost("TICKET_NUM");
        $oticketbak->SEATS = $this->request->getPost("SEATS");
        $oticketbak->DISCOUNT = $this->request->getPost("DISCOUNT");
        $oticketbak->DISCOUNT_MONEY = $this->request->getPost("DISCOUNT_MONEY");
        $oticketbak->MONEY = $this->request->getPost("MONEY");
        $oticketbak->TICKET_SOURCE = $this->request->getPost("TICKET_SOURCE");
        $oticketbak->PIAOWU_ORDER_ID = $this->request->getPost("PIAOWU_ORDER_ID");
        $oticketbak->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $oticketbak->ITEM_ID = $this->request->getPost("ITEM_ID");
        $oticketbak->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $oticketbak->ITEM_SOURCE = $this->request->getPost("ITEM_SOURCE");
        $oticketbak->ITEM_CITY_ID = $this->request->getPost("ITEM_CITY_ID");
        $oticketbak->SELL_TYPE = $this->request->getPost("SELL_TYPE");
        $oticketbak->TICKET_STATUS = $this->request->getPost("TICKET_STATUS");
        $oticketbak->TICKET_PACKAGE = $this->request->getPost("TICKET_PACKAGE");
        $oticketbak->TICKET_PACKAGE_PRICE = $this->request->getPost("TICKET_PACKAGE_PRICE");
        $oticketbak->PIAOWU_XSZC = $this->request->getPost("PIAOWU_XSZC");
        $oticketbak->PIAOWU_ZYZK = $this->request->getPost("PIAOWU_ZYZK");
        $oticketbak->SOLD_TIME = $this->request->getPost("SOLD_TIME");
        $oticketbak->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $oticketbak->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $oticketbak->ITEM_AGENCY_ID = $this->request->getPost("ITEM_AGENCY_ID");
        $oticketbak->ITEM_ONLINE_CITY_ID = $this->request->getPost("ITEM_ONLINE_CITY_ID");
        $oticketbak->SEAT_NAME = $this->request->getPost("SEAT_NAME");
        $oticketbak->SEAT_NUM = $this->request->getPost("SEAT_NUM");
        $oticketbak->COST_PRICE = $this->request->getPost("COST_PRICE");
        if (!$oticketbak->save()) {
            foreach ($oticketbak->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "new"));
        } else {
            $this->flash->success("o ticket bak was created successfully");
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $oticketbak = OTicketBak::findFirst("1='$1'");
        if (!$oticketbak) {
            $this->flash->error("o ticket bak does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }
        $oticketbak->ID = $this->request->getPost("ID");
        $oticketbak->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oticketbak->UUID = $this->request->getPost("UUID");
        $oticketbak->USERNAME = $this->request->getPost("USERNAME");
        $oticketbak->PRICE_INFO_ID = $this->request->getPost("PRICE_INFO_ID");
        $oticketbak->PRICE = $this->request->getPost("PRICE");
        $oticketbak->PRICE_LEVEL = $this->request->getPost("PRICE_LEVEL");
        $oticketbak->TICKET_NAME = $this->request->getPost("TICKET_NAME");
        $oticketbak->TICKET_TYPE = $this->request->getPost("TICKET_TYPE");
        $oticketbak->VENUES_ID = $this->request->getPost("VENUES_ID");
        $oticketbak->SCENE_ID = $this->request->getPost("SCENE_ID");
        $oticketbak->TICKET_NUM = $this->request->getPost("TICKET_NUM");
        $oticketbak->SEATS = $this->request->getPost("SEATS");
        $oticketbak->DISCOUNT = $this->request->getPost("DISCOUNT");
        $oticketbak->DISCOUNT_MONEY = $this->request->getPost("DISCOUNT_MONEY");
        $oticketbak->MONEY = $this->request->getPost("MONEY");
        $oticketbak->TICKET_SOURCE = $this->request->getPost("TICKET_SOURCE");
        $oticketbak->PIAOWU_ORDER_ID = $this->request->getPost("PIAOWU_ORDER_ID");
        $oticketbak->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $oticketbak->ITEM_ID = $this->request->getPost("ITEM_ID");
        $oticketbak->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $oticketbak->ITEM_SOURCE = $this->request->getPost("ITEM_SOURCE");
        $oticketbak->ITEM_CITY_ID = $this->request->getPost("ITEM_CITY_ID");
        $oticketbak->SELL_TYPE = $this->request->getPost("SELL_TYPE");
        $oticketbak->TICKET_STATUS = $this->request->getPost("TICKET_STATUS");
        $oticketbak->TICKET_PACKAGE = $this->request->getPost("TICKET_PACKAGE");
        $oticketbak->TICKET_PACKAGE_PRICE = $this->request->getPost("TICKET_PACKAGE_PRICE");
        $oticketbak->PIAOWU_XSZC = $this->request->getPost("PIAOWU_XSZC");
        $oticketbak->PIAOWU_ZYZK = $this->request->getPost("PIAOWU_ZYZK");
        $oticketbak->SOLD_TIME = $this->request->getPost("SOLD_TIME");
        $oticketbak->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $oticketbak->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $oticketbak->ITEM_AGENCY_ID = $this->request->getPost("ITEM_AGENCY_ID");
        $oticketbak->ITEM_ONLINE_CITY_ID = $this->request->getPost("ITEM_ONLINE_CITY_ID");
        $oticketbak->SEAT_NAME = $this->request->getPost("SEAT_NAME");
        $oticketbak->SEAT_NUM = $this->request->getPost("SEAT_NUM");
        $oticketbak->COST_PRICE = $this->request->getPost("COST_PRICE");
        if (!$oticketbak->save()) {
            foreach ($oticketbak->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "edit", "params" => array($oticketbak->1)));
        } else {
            $this->flash->success("o ticket bak was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $oticketbak = OTicketBak::findFirst('1="'.$1.'"');
        if (!$oticketbak) {
            $this->flash->error("o ticket bak was not found");
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }

        if (!$oticketbak->delete()) {
            foreach ($oticketbak->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "search"));
        } else {
            $this->flash->success("o ticket bak was deleted");
            return $this->dispatcher->forward(array("controller" => "oticketbak", "action" => "index"));
        }
    }

}
