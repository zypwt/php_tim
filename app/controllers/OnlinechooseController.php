<?php

use \Phalcon\Tag as Tag;

class OnlineChooseController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OnlineChoose", $_POST);
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

        $onlinechoose = OnlineChoose::find($parameters);
        if (count($onlinechoose) == 0) {
            $this->flash->notice("The search did not find any online choose");
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $onlinechoose,
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

            $onlinechoose = OnlineChoose::findFirst('ID="'.$ID.'"');
            if (!$onlinechoose) {
                $this->flash->error("online choose was not found");
                return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
            }
            $this->view->setVar("ID", $onlinechoose->ID);
        
            Tag::displayTo("ID", $onlinechoose->ID);
            Tag::displayTo("ITEM_ID", $onlinechoose->ITEM_ID);
            Tag::displayTo("SENCE_ID", $onlinechoose->SENCE_ID);
            Tag::displayTo("FILE_ID", $onlinechoose->FILE_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

        $onlinechoose = new OnlineChoose();
        $onlinechoose->ID = $this->request->getPost("ID");
        $onlinechoose->ITEM_ID = $this->request->getPost("ITEM_ID");
        $onlinechoose->SENCE_ID = $this->request->getPost("SENCE_ID");
        $onlinechoose->FILE_ID = $this->request->getPost("FILE_ID");
        if (!$onlinechoose->save()) {
            foreach ($onlinechoose->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "new"));
        } else {
            $this->flash->success("online choose was created successfully");
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $onlinechoose = OnlineChoose::findFirst("ID='$ID'");
        if (!$onlinechoose) {
            $this->flash->error("online choose does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }
        $onlinechoose->ID = $this->request->getPost("ID");
        $onlinechoose->ITEM_ID = $this->request->getPost("ITEM_ID");
        $onlinechoose->SENCE_ID = $this->request->getPost("SENCE_ID");
        $onlinechoose->FILE_ID = $this->request->getPost("FILE_ID");
        if (!$onlinechoose->save()) {
            foreach ($onlinechoose->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "edit", "params" => array($onlinechoose->ID)));
        } else {
            $this->flash->success("online choose was updated successfully");
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $onlinechoose = OnlineChoose::findFirst('ID="'.$ID.'"');
        if (!$onlinechoose) {
            $this->flash->error("online choose was not found");
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }

        if (!$onlinechoose->delete()) {
            foreach ($onlinechoose->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "search"));
        } else {
            $this->flash->success("online choose was deleted");
            return $this->dispatcher->forward(array("controller" => "onlinechoose", "action" => "index"));
        }
    }

}
