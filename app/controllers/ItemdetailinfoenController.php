<?php

use \Phalcon\Tag as Tag;

class ItemDetailInfoEnController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemDetailInfoEn", $_POST);
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

        $itemdetailinfoen = ItemDetailInfoEn::find($parameters);
        if (count($itemdetailinfoen) == 0) {
            $this->flash->notice("The search did not find any item detail info en");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemdetailinfoen,
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

            $itemdetailinfoen = ItemDetailInfoEn::findFirst('1="'.$1.'"');
            if (!$itemdetailinfoen) {
                $this->flash->error("item detail info en was not found");
                return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
            }
            $this->view->setVar("1", $itemdetailinfoen->1);
        
            Tag::displayTo("ID", $itemdetailinfoen->ID);
            Tag::displayTo("ITEM_ID", $itemdetailinfoen->ITEM_ID);
            Tag::displayTo("ITEM_DESC", $itemdetailinfoen->ITEM_DESC);
            Tag::displayTo("ITEM_DETAIL_DESC", $itemdetailinfoen->ITEM_DETAIL_DESC);
            Tag::displayTo("CREATE_TIME", $itemdetailinfoen->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $itemdetailinfoen->UPDATE_TIME);
            Tag::displayTo("ITEM_IMAGE_LIST", $itemdetailinfoen->ITEM_IMAGE_LIST);
            Tag::displayTo("MATE_TITLE", $itemdetailinfoen->MATE_TITLE);
            Tag::displayTo("MATE_KEYWORDS", $itemdetailinfoen->MATE_KEYWORDS);
            Tag::displayTo("MATE_DESC", $itemdetailinfoen->MATE_DESC);
            Tag::displayTo("HELP_INFORMATION", $itemdetailinfoen->HELP_INFORMATION);
            Tag::displayTo("ITEM_APP_DESC", $itemdetailinfoen->ITEM_APP_DESC);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

        $itemdetailinfoen = new ItemDetailInfoEn();
        $itemdetailinfoen->ID = $this->request->getPost("ID");
        $itemdetailinfoen->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemdetailinfoen->ITEM_DESC = $this->request->getPost("ITEM_DESC");
        $itemdetailinfoen->ITEM_DETAIL_DESC = $this->request->getPost("ITEM_DETAIL_DESC");
        $itemdetailinfoen->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemdetailinfoen->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemdetailinfoen->ITEM_IMAGE_LIST = $this->request->getPost("ITEM_IMAGE_LIST");
        $itemdetailinfoen->MATE_TITLE = $this->request->getPost("MATE_TITLE");
        $itemdetailinfoen->MATE_KEYWORDS = $this->request->getPost("MATE_KEYWORDS");
        $itemdetailinfoen->MATE_DESC = $this->request->getPost("MATE_DESC");
        $itemdetailinfoen->HELP_INFORMATION = $this->request->getPost("HELP_INFORMATION");
        $itemdetailinfoen->ITEM_APP_DESC = $this->request->getPost("ITEM_APP_DESC");
        if (!$itemdetailinfoen->save()) {
            foreach ($itemdetailinfoen->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "new"));
        } else {
            $this->flash->success("item detail info en was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $itemdetailinfoen = ItemDetailInfoEn::findFirst("1='$1'");
        if (!$itemdetailinfoen) {
            $this->flash->error("item detail info en does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }
        $itemdetailinfoen->ID = $this->request->getPost("ID");
        $itemdetailinfoen->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemdetailinfoen->ITEM_DESC = $this->request->getPost("ITEM_DESC");
        $itemdetailinfoen->ITEM_DETAIL_DESC = $this->request->getPost("ITEM_DETAIL_DESC");
        $itemdetailinfoen->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemdetailinfoen->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemdetailinfoen->ITEM_IMAGE_LIST = $this->request->getPost("ITEM_IMAGE_LIST");
        $itemdetailinfoen->MATE_TITLE = $this->request->getPost("MATE_TITLE");
        $itemdetailinfoen->MATE_KEYWORDS = $this->request->getPost("MATE_KEYWORDS");
        $itemdetailinfoen->MATE_DESC = $this->request->getPost("MATE_DESC");
        $itemdetailinfoen->HELP_INFORMATION = $this->request->getPost("HELP_INFORMATION");
        $itemdetailinfoen->ITEM_APP_DESC = $this->request->getPost("ITEM_APP_DESC");
        if (!$itemdetailinfoen->save()) {
            foreach ($itemdetailinfoen->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "edit", "params" => array($itemdetailinfoen->1)));
        } else {
            $this->flash->success("item detail info en was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $itemdetailinfoen = ItemDetailInfoEn::findFirst('1="'.$1.'"');
        if (!$itemdetailinfoen) {
            $this->flash->error("item detail info en was not found");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }

        if (!$itemdetailinfoen->delete()) {
            foreach ($itemdetailinfoen->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "search"));
        } else {
            $this->flash->success("item detail info en was deleted");
            return $this->dispatcher->forward(array("controller" => "itemdetailinfoen", "action" => "index"));
        }
    }

}
