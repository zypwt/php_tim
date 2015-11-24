<?php

use \Phalcon\Tag as Tag;

class ItemBlockController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemBlock", $_POST);
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

        $itemblock = ItemBlock::find($parameters);
        if (count($itemblock) == 0) {
            $this->flash->notice("The search did not find any item block");
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemblock,
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

            $itemblock = ItemBlock::findFirst('ID="'.$ID.'"');
            if (!$itemblock) {
                $this->flash->error("item block was not found");
                return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
            }
            $this->view->setVar("ID", $itemblock->ID);
        
            Tag::displayTo("ID", $itemblock->ID);
            Tag::displayTo("ITEM_ID", $itemblock->ITEM_ID);
            Tag::displayTo("ITEM_TITLE", $itemblock->ITEM_TITLE);
            Tag::displayTo("OP_NAME", $itemblock->OP_NAME);
            Tag::displayTo("IS_BLOCK", $itemblock->IS_BLOCK);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

        $itemblock = new ItemBlock();
        $itemblock->ID = $this->request->getPost("ID");
        $itemblock->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemblock->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $itemblock->OP_NAME = $this->request->getPost("OP_NAME");
        $itemblock->IS_BLOCK = $this->request->getPost("IS_BLOCK");
        if (!$itemblock->save()) {
            foreach ($itemblock->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "new"));
        } else {
            $this->flash->success("item block was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itemblock = ItemBlock::findFirst("ID='$ID'");
        if (!$itemblock) {
            $this->flash->error("item block does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }
        $itemblock->ID = $this->request->getPost("ID");
        $itemblock->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemblock->ITEM_TITLE = $this->request->getPost("ITEM_TITLE");
        $itemblock->OP_NAME = $this->request->getPost("OP_NAME");
        $itemblock->IS_BLOCK = $this->request->getPost("IS_BLOCK");
        if (!$itemblock->save()) {
            foreach ($itemblock->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "edit", "params" => array($itemblock->ID)));
        } else {
            $this->flash->success("item block was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itemblock = ItemBlock::findFirst('ID="'.$ID.'"');
        if (!$itemblock) {
            $this->flash->error("item block was not found");
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }

        if (!$itemblock->delete()) {
            foreach ($itemblock->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "search"));
        } else {
            $this->flash->success("item block was deleted");
            return $this->dispatcher->forward(array("controller" => "itemblock", "action" => "index"));
        }
    }

}
