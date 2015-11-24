<?php

use \Phalcon\Tag as Tag;

class ItemInfoLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemInfoLog", $_POST);
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

        $iteminfolog = ItemInfoLog::find($parameters);
        if (count($iteminfolog) == 0) {
            $this->flash->notice("The search did not find any item info log");
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $iteminfolog,
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

            $iteminfolog = ItemInfoLog::findFirst('ID="'.$ID.'"');
            if (!$iteminfolog) {
                $this->flash->error("item info log was not found");
                return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
            }
            $this->view->setVar("ID", $iteminfolog->ID);
        
            Tag::displayTo("ID", $iteminfolog->ID);
            Tag::displayTo("ITEM_ID", $iteminfolog->ITEM_ID);
            Tag::displayTo("ONLINE_ID", $iteminfolog->ONLINE_ID);
            Tag::displayTo("CONTENT", $iteminfolog->CONTENT);
            Tag::displayTo("CREATE_TIME", $iteminfolog->CREATE_TIME);
            Tag::displayTo("PERSON_UUID", $iteminfolog->PERSON_UUID);
            Tag::displayTo("PERSON_NAME", $iteminfolog->PERSON_NAME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

        $iteminfolog = new ItemInfoLog();
        $iteminfolog->ID = $this->request->getPost("ID");
        $iteminfolog->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfolog->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $iteminfolog->CONTENT = $this->request->getPost("CONTENT");
        $iteminfolog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfolog->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $iteminfolog->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        if (!$iteminfolog->save()) {
            foreach ($iteminfolog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "new"));
        } else {
            $this->flash->success("item info log was created successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $iteminfolog = ItemInfoLog::findFirst("ID='$ID'");
        if (!$iteminfolog) {
            $this->flash->error("item info log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }
        $iteminfolog->ID = $this->request->getPost("ID");
        $iteminfolog->ITEM_ID = $this->request->getPost("ITEM_ID");
        $iteminfolog->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $iteminfolog->CONTENT = $this->request->getPost("CONTENT");
        $iteminfolog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $iteminfolog->PERSON_UUID = $this->request->getPost("PERSON_UUID");
        $iteminfolog->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        if (!$iteminfolog->save()) {
            foreach ($iteminfolog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "edit", "params" => array($iteminfolog->ID)));
        } else {
            $this->flash->success("item info log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $iteminfolog = ItemInfoLog::findFirst('ID="'.$ID.'"');
        if (!$iteminfolog) {
            $this->flash->error("item info log was not found");
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }

        if (!$iteminfolog->delete()) {
            foreach ($iteminfolog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "search"));
        } else {
            $this->flash->success("item info log was deleted");
            return $this->dispatcher->forward(array("controller" => "iteminfolog", "action" => "index"));
        }
    }

}
