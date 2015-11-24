<?php

use \Phalcon\Tag as Tag;

class ItemInfoEnController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemInfoEn", $_POST);
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

        $iteminfoen = ItemInfoEn::find($parameters);
        if (count($iteminfoen) == 0) {
            $this->flash->notice("The search did not find any item info en");
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $iteminfoen,
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

            $iteminfoen = ItemInfoEn::findFirst('1="'.$1.'"');
            if (!$iteminfoen) {
                $this->flash->error("item info en was not found");
                return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
            }
            $this->view->setVar("1", $iteminfoen->1);
        
            Tag::displayTo("ID", $iteminfoen->ID);
            Tag::displayTo("ITEM_ID", $iteminfoen->ITEM_ID);
            Tag::displayTo("ITEM_TITLE", $iteminfoen->ITEM_TITLE);
            Tag::displayTo("ITEM_SHORT_TITLE", $iteminfoen->ITEM_SHORT_TITLE);
            Tag::displayTo("CITY_ID", $iteminfoen->CITY_ID);
            Tag::displayTo("VENUE_ID", $iteminfoen->VENUE_ID);
            Tag::displayTo("AGENCY_ID", $iteminfoen->AGENCY_ID);
            Tag::displayTo("TICKET_SYS_DIC_ID", $iteminfoen->TICKET_SYS_DIC_ID);
            Tag::displayTo("PROXY_TYPE", $iteminfoen->PROXY_TYPE);
            Tag::displayTo("SHOW_TYPE", $iteminfoen->SHOW_TYPE);
            Tag::displayTo("SHOW_TIME", $iteminfoen->SHOW_TIME);
            Tag::displayTo("PRICE_INFO", $iteminfoen->PRICE_INFO);
            Tag::displayTo("ARTIST_ID", $iteminfoen->ARTIST_ID);
            Tag::displayTo("ITEM_TYPE_ID", $iteminfoen->ITEM_TYPE_ID);
            Tag::displayTo("ITEM_TYPE_PID", $iteminfoen->ITEM_TYPE_PID);
            Tag::displayTo("ITEM_IMAGE_URL", $iteminfoen->ITEM_IMAGE_URL);
            Tag::displayTo("SEATS_IMAGE_URL", $iteminfoen->SEATS_IMAGE_URL);
            Tag::displayTo("AUDIT_STATUS", $iteminfoen->AUDIT_STATUS);
            Tag::displayTo("IS_VISIBLE", $iteminfoen->IS_VISIBLE);
            Tag::displayTo("ASSOCIATE_ITEM_ID", $iteminfoen->ASSOCIATE_ITEM_ID);
            Tag::displayTo("CREATE_TIME", $iteminfoen->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $iteminfoen->UPDATE_TIME);
            Tag::displayTo("ITEM_TAG", $iteminfoen->ITEM_TAG);
            Tag::displayTo("DOUBAN_REVIEW_ID", $iteminfoen->DOUBAN_REVIEW_ID);
            Tag::displayTo("SHOW_END_TIME", $iteminfoen->SHOW_END_TIME);
            Tag::displayTo("PROXY_TAX", $iteminfoen->PROXY_TAX);
            Tag::displayTo("IS_ETICKET", $iteminfoen->IS_ETICKET);
            Tag::displayTo("LIMIT_CHOICE", $iteminfoen->LIMIT_CHOICE);
            Tag::displayTo("EXCHANGE_TYPE", $iteminfoen->EXCHANGE_TYPE);
            Tag::displayTo("THIRDITEMID", $iteminfoen->THIRDITEMID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

        $iteminfoen = new ItemInfoEn();
        $iteminfoen->ID = $this->request->getPost("ID");
        $iteminfoen->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfoen->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $iteminfoen->ITEM_SHORT_TITLE = $this->request->getPost("ITEM_SHORT_TITLE");
        $iteminfoen->CITY_ID = $this->request->getPost("CITY_ID");
        $iteminfoen->VENUE_ID = $this->request->getPost("VENUE_ID");
        $iteminfoen->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $iteminfoen->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $iteminfoen->PROXY_TYPE = $this->request->getPost("PROXY_TYPE");
        $iteminfoen->SHOW_TYPE = $this->request->getPost("SHOW_TYPE");
        $iteminfoen->SHOW_TIME = $this->request->getPost("SHOW_TIME");
        $iteminfoen->PRICE_INFO = $this->request->getPost("PRICE_INFO");
        $iteminfoen->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $iteminfoen->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $iteminfoen->ITEM_TYPE_PID = $this->request->getPost("ITEM_TYPE_PID");
        $iteminfoen->ITEM_IMAGE_URL = $this->request->getPost("ITEM_IMAGE_URL");
        $iteminfoen->SEATS_IMAGE_URL = $this->request->getPost("SEATS_IMAGE_URL");
        $iteminfoen->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $iteminfoen->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $iteminfoen->ASSOCIATE_ITEM_ID = $this->request->getPost("ASSOCIATE_ITEM_ID");
        $iteminfoen->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfoen->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $iteminfoen->ITEM_TAG = $this->request->getPost("ITEM_TAG");
        $iteminfoen->DOUBAN_REVIEW_ID = $this->request->getPost("DOUBAN_REVIEW_ID");
        $iteminfoen->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $iteminfoen->PROXY_TAX = $this->request->getPost("PROXY_TAX");
        $iteminfoen->IS_ETICKET = $this->request->getPost("IS_ETICKET");
        $iteminfoen->LIMIT_CHOICE = $this->request->getPost("LIMIT_CHOICE");
        $iteminfoen->EXCHANGE_TYPE = $this->request->getPost("EXCHANGE_TYPE");
        $iteminfoen->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        if (!$iteminfoen->save()) {
            foreach ($iteminfoen->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "new"));
        } else {
            $this->flash->success("item info en was created successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $iteminfoen = ItemInfoEn::findFirst("1='$1'");
        if (!$iteminfoen) {
            $this->flash->error("item info en does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }
        $iteminfoen->ID = $this->request->getPost("ID");
        $iteminfoen->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfoen->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $iteminfoen->ITEM_SHORT_TITLE = $this->request->getPost("ITEM_SHORT_TITLE");
        $iteminfoen->CITY_ID = $this->request->getPost("CITY_ID");
        $iteminfoen->VENUE_ID = $this->request->getPost("VENUE_ID");
        $iteminfoen->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $iteminfoen->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $iteminfoen->PROXY_TYPE = $this->request->getPost("PROXY_TYPE");
        $iteminfoen->SHOW_TYPE = $this->request->getPost("SHOW_TYPE");
        $iteminfoen->SHOW_TIME = $this->request->getPost("SHOW_TIME");
        $iteminfoen->PRICE_INFO = $this->request->getPost("PRICE_INFO");
        $iteminfoen->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $iteminfoen->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $iteminfoen->ITEM_TYPE_PID = $this->request->getPost("ITEM_TYPE_PID");
        $iteminfoen->ITEM_IMAGE_URL = $this->request->getPost("ITEM_IMAGE_URL");
        $iteminfoen->SEATS_IMAGE_URL = $this->request->getPost("SEATS_IMAGE_URL");
        $iteminfoen->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $iteminfoen->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $iteminfoen->ASSOCIATE_ITEM_ID = $this->request->getPost("ASSOCIATE_ITEM_ID");
        $iteminfoen->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfoen->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $iteminfoen->ITEM_TAG = $this->request->getPost("ITEM_TAG");
        $iteminfoen->DOUBAN_REVIEW_ID = $this->request->getPost("DOUBAN_REVIEW_ID");
        $iteminfoen->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $iteminfoen->PROXY_TAX = $this->request->getPost("PROXY_TAX");
        $iteminfoen->IS_ETICKET = $this->request->getPost("IS_ETICKET");
        $iteminfoen->LIMIT_CHOICE = $this->request->getPost("LIMIT_CHOICE");
        $iteminfoen->EXCHANGE_TYPE = $this->request->getPost("EXCHANGE_TYPE");
        $iteminfoen->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        if (!$iteminfoen->save()) {
            foreach ($iteminfoen->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "edit", "params" => array($iteminfoen->1)));
        } else {
            $this->flash->success("item info en was updated successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $iteminfoen = ItemInfoEn::findFirst('1="'.$1.'"');
        if (!$iteminfoen) {
            $this->flash->error("item info en was not found");
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }

        if (!$iteminfoen->delete()) {
            foreach ($iteminfoen->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "search"));
        } else {
            $this->flash->success("item info en was deleted");
            return $this->dispatcher->forward(array("controller" => "iteminfoen", "action" => "index"));
        }
    }

}
