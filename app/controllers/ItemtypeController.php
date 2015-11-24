<?php

use \Phalcon\Tag as Tag;

class ItemTypeController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemType", $_POST);
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

        $itemtype = ItemType::find($parameters);
        if (count($itemtype) == 0) {
            $this->flash->notice("The search did not find any item type");
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemtype,
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

            $itemtype = ItemType::findFirst('ID="'.$ID.'"');
            if (!$itemtype) {
                $this->flash->error("item type was not found");
                return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
            }
            $this->view->setVar("ID", $itemtype->ID);
        
            Tag::displayTo("ID", $itemtype->ID);
            Tag::displayTo("PID", $itemtype->PID);
            Tag::displayTo("NAME", $itemtype->NAME);
            Tag::displayTo("SORT", $itemtype->SORT);
            Tag::displayTo("SN", $itemtype->SN);
            Tag::displayTo("IS_VISIBLE", $itemtype->IS_VISIBLE);
            Tag::displayTo("CREATE_TIME", $itemtype->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $itemtype->UPDATE_TIME);
            Tag::displayTo("NAME_EN", $itemtype->NAME_EN);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

        $itemtype = new ItemType();
        $itemtype->ID = $this->request->getPost("ID");
        $itemtype->PID = $this->request->getPost("PID");
        $itemtype->NAME = $this->request->getPost("NAME");
        $itemtype->SORT = $this->request->getPost("SORT");
        $itemtype->SN = $this->request->getPost("SN");
        $itemtype->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemtype->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemtype->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemtype->NAME_EN = $this->request->getPost("NAME_EN");
        if (!$itemtype->save()) {
            foreach ($itemtype->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "new"));
        } else {
            $this->flash->success("item type was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itemtype = ItemType::findFirst("ID='$ID'");
        if (!$itemtype) {
            $this->flash->error("item type does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }
        $itemtype->ID = $this->request->getPost("ID");
        $itemtype->PID = $this->request->getPost("PID");
        $itemtype->NAME = $this->request->getPost("NAME");
        $itemtype->SORT = $this->request->getPost("SORT");
        $itemtype->SN = $this->request->getPost("SN");
        $itemtype->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $itemtype->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itemtype->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itemtype->NAME_EN = $this->request->getPost("NAME_EN");
        if (!$itemtype->save()) {
            foreach ($itemtype->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "edit", "params" => array($itemtype->ID)));
        } else {
            $this->flash->success("item type was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itemtype = ItemType::findFirst('ID="'.$ID.'"');
        if (!$itemtype) {
            $this->flash->error("item type was not found");
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }

        if (!$itemtype->delete()) {
            foreach ($itemtype->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "search"));
        } else {
            $this->flash->success("item type was deleted");
            return $this->dispatcher->forward(array("controller" => "itemtype", "action" => "index"));
        }
    }

}
