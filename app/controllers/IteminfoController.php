<?php

use \Phalcon\Tag as Tag;

class ItemInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemInfo", $_POST);
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

        $iteminfo = ItemInfo::find($parameters);
        if (count($iteminfo) == 0) {
            $this->flash->notice("The search did not find any item info");
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $iteminfo,
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

            $iteminfo = ItemInfo::findFirst('ID="'.$ID.'"');
            if (!$iteminfo) {
                $this->flash->error("item info was not found");
                return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
            }
            $this->view->setVar("ID", $iteminfo->ID);
        
            Tag::displayTo("ID", $iteminfo->ID);
            Tag::displayTo("ITEM_ID", $iteminfo->ITEM_ID);
            Tag::displayTo("ITEM_TITLE", $iteminfo->ITEM_TITLE);
            Tag::displayTo("ITEM_SHORT_TITLE", $iteminfo->ITEM_SHORT_TITLE);
            Tag::displayTo("CITY_ID", $iteminfo->CITY_ID);
            Tag::displayTo("VENUE_ID", $iteminfo->VENUE_ID);
            Tag::displayTo("AGENCY_ID", $iteminfo->AGENCY_ID);
            Tag::displayTo("TICKET_SYS_DIC_ID", $iteminfo->TICKET_SYS_DIC_ID);
            Tag::displayTo("PROXY_TYPE", $iteminfo->PROXY_TYPE);
            Tag::displayTo("SHOW_TYPE", $iteminfo->SHOW_TYPE);
            Tag::displayTo("SHOW_TIME", $iteminfo->SHOW_TIME);
            Tag::displayTo("PRICE_INFO", $iteminfo->PRICE_INFO);
            Tag::displayTo("ARTIST_ID", $iteminfo->ARTIST_ID);
            Tag::displayTo("ITEM_TYPE_ID", $iteminfo->ITEM_TYPE_ID);
            Tag::displayTo("ITEM_TYPE_PID", $iteminfo->ITEM_TYPE_PID);
            Tag::displayTo("ITEM_IMAGE_URL", $iteminfo->ITEM_IMAGE_URL);
            Tag::displayTo("SEATS_IMAGE_URL", $iteminfo->SEATS_IMAGE_URL);
            Tag::displayTo("AUDIT_STATUS", $iteminfo->AUDIT_STATUS);
            Tag::displayTo("IS_VISIBLE", $iteminfo->IS_VISIBLE);
            Tag::displayTo("ASSOCIATE_ITEM_ID", $iteminfo->ASSOCIATE_ITEM_ID);
            Tag::displayTo("CREATE_TIME", $iteminfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $iteminfo->UPDATE_TIME);
            Tag::displayTo("ITEM_TAG", $iteminfo->ITEM_TAG);
            Tag::displayTo("DOUBAN_REVIEW_ID", $iteminfo->DOUBAN_REVIEW_ID);
            Tag::displayTo("SHOW_END_TIME", $iteminfo->SHOW_END_TIME);
            Tag::displayTo("PROXY_TAX", $iteminfo->PROXY_TAX);
            Tag::displayTo("IS_ETICKET", $iteminfo->IS_ETICKET);
            Tag::displayTo("LIMIT_CHOICE", $iteminfo->LIMIT_CHOICE);
            Tag::displayTo("EXCHANGE_TYPE", $iteminfo->EXCHANGE_TYPE);
            Tag::displayTo("THIRDITEMID", $iteminfo->THIRDITEMID);
            Tag::displayTo("IS_REALNAME", $iteminfo->IS_REALNAME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

        $iteminfo = new ItemInfo();
        $iteminfo->ID = $this->request->getPost("ID");
        $iteminfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfo->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $iteminfo->ITEM_SHORT_TITLE = $this->request->getPost("ITEM_SHORT_TITLE");
        $iteminfo->CITY_ID = $this->request->getPost("CITY_ID");
        $iteminfo->VENUE_ID = $this->request->getPost("VENUE_ID");
        $iteminfo->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $iteminfo->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $iteminfo->PROXY_TYPE = $this->request->getPost("PROXY_TYPE");
        $iteminfo->SHOW_TYPE = $this->request->getPost("SHOW_TYPE");
        $iteminfo->SHOW_TIME = $this->request->getPost("SHOW_TIME");
        $iteminfo->PRICE_INFO = $this->request->getPost("PRICE_INFO");
        $iteminfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $iteminfo->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $iteminfo->ITEM_TYPE_PID = $this->request->getPost("ITEM_TYPE_PID");
        $iteminfo->ITEM_IMAGE_URL = $this->request->getPost("ITEM_IMAGE_URL");
        $iteminfo->SEATS_IMAGE_URL = $this->request->getPost("SEATS_IMAGE_URL");
        $iteminfo->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $iteminfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $iteminfo->ASSOCIATE_ITEM_ID = $this->request->getPost("ASSOCIATE_ITEM_ID");
        $iteminfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $iteminfo->ITEM_TAG = $this->request->getPost("ITEM_TAG");
        $iteminfo->DOUBAN_REVIEW_ID = $this->request->getPost("DOUBAN_REVIEW_ID");
        $iteminfo->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $iteminfo->PROXY_TAX = $this->request->getPost("PROXY_TAX");
        $iteminfo->IS_ETICKET = $this->request->getPost("IS_ETICKET");
        $iteminfo->LIMIT_CHOICE = $this->request->getPost("LIMIT_CHOICE");
        $iteminfo->EXCHANGE_TYPE = $this->request->getPost("EXCHANGE_TYPE");
        $iteminfo->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        $iteminfo->IS_REALNAME = $this->request->getPost("IS_REALNAME");
        if (!$iteminfo->save()) {
            foreach ($iteminfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "new"));
        } else {
            $this->flash->success("item info was created successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $iteminfo = ItemInfo::findFirst("ID='$ID'");
        if (!$iteminfo) {
            $this->flash->error("item info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }
        $iteminfo->ID = $this->request->getPost("ID");
        $iteminfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfo->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $iteminfo->ITEM_SHORT_TITLE = $this->request->getPost("ITEM_SHORT_TITLE");
        $iteminfo->CITY_ID = $this->request->getPost("CITY_ID");
        $iteminfo->VENUE_ID = $this->request->getPost("VENUE_ID");
        $iteminfo->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $iteminfo->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $iteminfo->PROXY_TYPE = $this->request->getPost("PROXY_TYPE");
        $iteminfo->SHOW_TYPE = $this->request->getPost("SHOW_TYPE");
        $iteminfo->SHOW_TIME = $this->request->getPost("SHOW_TIME");
        $iteminfo->PRICE_INFO = $this->request->getPost("PRICE_INFO");
        $iteminfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $iteminfo->ITEM_TYPE_ID = $this->request->getPost("ITEM_TYPE_ID");
        $iteminfo->ITEM_TYPE_PID = $this->request->getPost("ITEM_TYPE_PID");
        $iteminfo->ITEM_IMAGE_URL = $this->request->getPost("ITEM_IMAGE_URL");
        $iteminfo->SEATS_IMAGE_URL = $this->request->getPost("SEATS_IMAGE_URL");
        $iteminfo->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $iteminfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $iteminfo->ASSOCIATE_ITEM_ID = $this->request->getPost("ASSOCIATE_ITEM_ID");
        $iteminfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $iteminfo->ITEM_TAG = $this->request->getPost("ITEM_TAG");
        $iteminfo->DOUBAN_REVIEW_ID = $this->request->getPost("DOUBAN_REVIEW_ID");
        $iteminfo->SHOW_END_TIME = $this->request->getPost("SHOW_END_TIME");
        $iteminfo->PROXY_TAX = $this->request->getPost("PROXY_TAX");
        $iteminfo->IS_ETICKET = $this->request->getPost("IS_ETICKET");
        $iteminfo->LIMIT_CHOICE = $this->request->getPost("LIMIT_CHOICE");
        $iteminfo->EXCHANGE_TYPE = $this->request->getPost("EXCHANGE_TYPE");
        $iteminfo->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        $iteminfo->IS_REALNAME = $this->request->getPost("IS_REALNAME");
        if (!$iteminfo->save()) {
            foreach ($iteminfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "edit", "params" => array($iteminfo->ID)));
        } else {
            $this->flash->success("item info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $iteminfo = ItemInfo::findFirst('ID="'.$ID.'"');
        if (!$iteminfo) {
            $this->flash->error("item info was not found");
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }

        if (!$iteminfo->delete()) {
            foreach ($iteminfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "search"));
        } else {
            $this->flash->success("item info was deleted");
            return $this->dispatcher->forward(array("controller" => "iteminfo", "action" => "index"));
        }
    }

}
