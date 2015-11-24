<?php

use \Phalcon\Tag as Tag;

class ItemVideoInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemVideoInfo", $_POST);
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

        $itemvideoinfo = ItemVideoInfo::find($parameters);
        if (count($itemvideoinfo) == 0) {
            $this->flash->notice("The search did not find any item video info");
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemvideoinfo,
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

            $itemvideoinfo = ItemVideoInfo::findFirst('ID="'.$ID.'"');
            if (!$itemvideoinfo) {
                $this->flash->error("item video info was not found");
                return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $itemvideoinfo->ID);
        
            Tag::displayTo("ID", $itemvideoinfo->ID);
            Tag::displayTo("ITEM_ID", $itemvideoinfo->ITEM_ID);
            Tag::displayTo("VIDEO_URL", $itemvideoinfo->VIDEO_URL);
            Tag::displayTo("IS_VISIBLE", $itemvideoinfo->IS_VISIBLE);
            Tag::displayTo("CREATE_TIME", $itemvideoinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $itemvideoinfo->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

        $itemvideoinfo = new ItemVideoInfo();
        $itemvideoinfo->ID = $this->request->getPost("ID");
        $itemvideoinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemvideoinfo->VIDEO_URL = $this->request->getPost("VIDEO_URL");
        $itemvideoinfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemvideoinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemvideoinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$itemvideoinfo->save()) {
            foreach ($itemvideoinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "new"));
        } else {
            $this->flash->success("item video info was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itemvideoinfo = ItemVideoInfo::findFirst("ID='$ID'");
        if (!$itemvideoinfo) {
            $this->flash->error("item video info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }
        $itemvideoinfo->ID = $this->request->getPost("ID");
        $itemvideoinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemvideoinfo->VIDEO_URL = $this->request->getPost("VIDEO_URL");
        $itemvideoinfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemvideoinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemvideoinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$itemvideoinfo->save()) {
            foreach ($itemvideoinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "edit", "params" => array($itemvideoinfo->ID)));
        } else {
            $this->flash->success("item video info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itemvideoinfo = ItemVideoInfo::findFirst('ID="'.$ID.'"');
        if (!$itemvideoinfo) {
            $this->flash->error("item video info was not found");
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }

        if (!$itemvideoinfo->delete()) {
            foreach ($itemvideoinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "search"));
        } else {
            $this->flash->success("item video info was deleted");
            return $this->dispatcher->forward(array("controller" => "itemvideoinfo", "action" => "index"));
        }
    }

}
