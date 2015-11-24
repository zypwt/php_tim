<?php

use \Phalcon\Tag as Tag;

class ItemDetailInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemDetailInfo", $_POST);
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

        $itemdetailinfo = ItemDetailInfo::find($parameters);
        if (count($itemdetailinfo) == 0) {
            $this->flash->notice("The search did not find any item detail info");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemdetailinfo,
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

            $itemdetailinfo = ItemDetailInfo::findFirst('ID="'.$ID.'"');
            if (!$itemdetailinfo) {
                $this->flash->error("item detail info was not found");
                return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $itemdetailinfo->ID);
        
            Tag::displayTo("ID", $itemdetailinfo->ID);
            Tag::displayTo("ITEM_ID", $itemdetailinfo->ITEM_ID);
            Tag::displayTo("ITEM_DESC", $itemdetailinfo->ITEM_DESC);
            Tag::displayTo("ITEM_DETAIL_DESC", $itemdetailinfo->ITEM_DETAIL_DESC);
            Tag::displayTo("CREATE_TIME", $itemdetailinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $itemdetailinfo->UPDATE_TIME);
            Tag::displayTo("ITEM_IMAGE_LIST", $itemdetailinfo->ITEM_IMAGE_LIST);
            Tag::displayTo("MATE_TITLE", $itemdetailinfo->MATE_TITLE);
            Tag::displayTo("MATE_KEYWORDS", $itemdetailinfo->MATE_KEYWORDS);
            Tag::displayTo("MATE_DESC", $itemdetailinfo->MATE_DESC);
            Tag::displayTo("HELP_INFORMATION", $itemdetailinfo->HELP_INFORMATION);
            Tag::displayTo("ITEM_APP_DESC", $itemdetailinfo->ITEM_APP_DESC);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

        $itemdetailinfo = new ItemDetailInfo();
        $itemdetailinfo->ID = $this->request->getPost("ID");
        $itemdetailinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemdetailinfo->ITEM_DESC = $this->request->getPost("ITEM_DESC");
        $itemdetailinfo->ITEM_DETAIL_DESC = $this->request->getPost("ITEM_DETAIL_DESC");
        $itemdetailinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemdetailinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemdetailinfo->ITEM_IMAGE_LIST = $this->request->getPost("ITEM_IMAGE_LIST");
        $itemdetailinfo->MATE_TITLE = $this->request->getPost("MATE_TITLE");
        $itemdetailinfo->MATE_KEYWORDS = $this->request->getPost("MATE_KEYWORDS");
        $itemdetailinfo->MATE_DESC = $this->request->getPost("MATE_DESC");
        $itemdetailinfo->HELP_INFORMATION = $this->request->getPost("HELP_INFORMATION");
        $itemdetailinfo->ITEM_APP_DESC = $this->request->getPost("ITEM_APP_DESC");
        if (!$itemdetailinfo->save()) {
            foreach ($itemdetailinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "new"));
        } else {
            $this->flash->success("item detail info was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itemdetailinfo = ItemDetailInfo::findFirst("ID='$ID'");
        if (!$itemdetailinfo) {
            $this->flash->error("item detail info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }
        $itemdetailinfo->ID = $this->request->getPost("ID");
        $itemdetailinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemdetailinfo->ITEM_DESC = $this->request->getPost("ITEM_DESC");
        $itemdetailinfo->ITEM_DETAIL_DESC = $this->request->getPost("ITEM_DETAIL_DESC");
        $itemdetailinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemdetailinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemdetailinfo->ITEM_IMAGE_LIST = $this->request->getPost("ITEM_IMAGE_LIST");
        $itemdetailinfo->MATE_TITLE = $this->request->getPost("MATE_TITLE");
        $itemdetailinfo->MATE_KEYWORDS = $this->request->getPost("MATE_KEYWORDS");
        $itemdetailinfo->MATE_DESC = $this->request->getPost("MATE_DESC");
        $itemdetailinfo->HELP_INFORMATION = $this->request->getPost("HELP_INFORMATION");
        $itemdetailinfo->ITEM_APP_DESC = $this->request->getPost("ITEM_APP_DESC");
        if (!$itemdetailinfo->save()) {
            foreach ($itemdetailinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "edit", "params" => array($itemdetailinfo->ID)));
        } else {
            $this->flash->success("item detail info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itemdetailinfo = ItemDetailInfo::findFirst('ID="'.$ID.'"');
        if (!$itemdetailinfo) {
            $this->flash->error("item detail info was not found");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }

        if (!$itemdetailinfo->delete()) {
            foreach ($itemdetailinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "search"));
        } else {
            $this->flash->success("item detail info was deleted");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfo", "action" => "index"));
        }
    }

}
