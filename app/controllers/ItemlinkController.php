<?php

use \Phalcon\Tag as Tag;

class ItemLinkController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemLink", $_POST);
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

        $itemlink = ItemLink::find($parameters);
        if (count($itemlink) == 0) {
            $this->flash->notice("The search did not find any item link");
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemlink,
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

            $itemlink = ItemLink::findFirst('1="'.$1.'"');
            if (!$itemlink) {
                $this->flash->error("item link was not found");
                return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
            }
            $this->view->setVar("1", $itemlink->1);
        
            Tag::displayTo("ID", $itemlink->ID);
            Tag::displayTo("ITEM_ID", $itemlink->ITEM_ID);
            Tag::displayTo("ONLINE_ID", $itemlink->ONLINE_ID);
            Tag::displayTo("LINK", $itemlink->LINK);
            Tag::displayTo("CREATE_TIME", $itemlink->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

        $itemlink = new ItemLink();
        $itemlink->ID = $this->request->getPost("ID");
        $itemlink->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemlink->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $itemlink->LINK = $this->request->getPost("LINK");
        $itemlink->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$itemlink->save()) {
            foreach ($itemlink->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "new"));
        } else {
            $this->flash->success("item link was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $itemlink = ItemLink::findFirst("1='$1'");
        if (!$itemlink) {
            $this->flash->error("item link does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }
        $itemlink->ID = $this->request->getPost("ID");
        $itemlink->ITEM_ID = $this->request->getPost("ITEM_ID");
        $itemlink->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $itemlink->LINK = $this->request->getPost("LINK");
        $itemlink->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$itemlink->save()) {
            foreach ($itemlink->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "edit", "params" => array($itemlink->1)));
        } else {
            $this->flash->success("item link was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $itemlink = ItemLink::findFirst('1="'.$1.'"');
        if (!$itemlink) {
            $this->flash->error("item link was not found");
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }

        if (!$itemlink->delete()) {
            foreach ($itemlink->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "search"));
        } else {
            $this->flash->success("item link was deleted");
            return $this->dispatcher->forward(array("controller" => "itemlink", "action" => "index"));
        }
    }

}
