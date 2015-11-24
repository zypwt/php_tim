<?php

use \Phalcon\Tag as Tag;

class ItemTypeLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemTypeLog", $_POST);
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

        $itemtypelog = ItemTypeLog::find($parameters);
        if (count($itemtypelog) == 0) {
            $this->flash->notice("The search did not find any item type log");
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itemtypelog,
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

            $itemtypelog = ItemTypeLog::findFirst('ID="'.$ID.'"');
            if (!$itemtypelog) {
                $this->flash->error("item type log was not found");
                return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
            }
            $this->view->setVar("ID", $itemtypelog->ID);
        
            Tag::displayTo("ID", $itemtypelog->ID);
            Tag::displayTo("T_ID", $itemtypelog->T_ID);
            Tag::displayTo("USER_UUID", $itemtypelog->USER_UUID);
            Tag::displayTo("USER_NAME", $itemtypelog->USER_NAME);
            Tag::displayTo("CONTENT", $itemtypelog->CONTENT);
            Tag::displayTo("CREATE_TIME", $itemtypelog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

        $itemtypelog = new ItemTypeLog();
        $itemtypelog->ID = $this->request->getPost("ID");
        $itemtypelog->T_ID = $this->request->getPost("T_ID");
        $itemtypelog->USER_UUID = $this->request->getPost("USER_UUID");
        $itemtypelog->USER_NAME = $this->request->getPost("USER_NAME");
        $itemtypelog->CONTENT = $this->request->getPost("CONTENT");
        $itemtypelog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$itemtypelog->save()) {
            foreach ($itemtypelog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "new"));
        } else {
            $this->flash->success("item type log was created successfully");
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itemtypelog = ItemTypeLog::findFirst("ID='$ID'");
        if (!$itemtypelog) {
            $this->flash->error("item type log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }
        $itemtypelog->ID = $this->request->getPost("ID");
        $itemtypelog->T_ID = $this->request->getPost("T_ID");
        $itemtypelog->USER_UUID = $this->request->getPost("USER_UUID");
        $itemtypelog->USER_NAME = $this->request->getPost("USER_NAME");
        $itemtypelog->CONTENT = $this->request->getPost("CONTENT");
        $itemtypelog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$itemtypelog->save()) {
            foreach ($itemtypelog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "edit", "params" => array($itemtypelog->ID)));
        } else {
            $this->flash->success("item type log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itemtypelog = ItemTypeLog::findFirst('ID="'.$ID.'"');
        if (!$itemtypelog) {
            $this->flash->error("item type log was not found");
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }

        if (!$itemtypelog->delete()) {
            foreach ($itemtypelog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "search"));
        } else {
            $this->flash->success("item type log was deleted");
            return $this->dispatcher->forward(array("controller" => "itemtypelog", "action" => "index"));
        }
    }

}
