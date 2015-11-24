<?php

use \Phalcon\Tag as Tag;

class GhostFreeApplayController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "GhostFreeApplay", $_POST);
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

        $ghostfreeapplay = GhostFreeApplay::find($parameters);
        if (count($ghostfreeapplay) == 0) {
            $this->flash->notice("The search did not find any ghost free applay");
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ghostfreeapplay,
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

            $ghostfreeapplay = GhostFreeApplay::findFirst('ID="'.$ID.'"');
            if (!$ghostfreeapplay) {
                $this->flash->error("ghost free applay was not found");
                return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
            }
            $this->view->setVar("ID", $ghostfreeapplay->ID);
        
            Tag::displayTo("ID", $ghostfreeapplay->ID);
            Tag::displayTo("NAME", $ghostfreeapplay->NAME);
            Tag::displayTo("PHONE", $ghostfreeapplay->PHONE);
            Tag::displayTo("APPLAYNUM", $ghostfreeapplay->APPLAYNUM);
            Tag::displayTo("UPDATETIME", $ghostfreeapplay->UPDATETIME);
            Tag::displayTo("CRTIME", $ghostfreeapplay->CRTIME);
            Tag::displayTo("REASON", $ghostfreeapplay->REASON);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

        $ghostfreeapplay = new GhostFreeApplay();
        $ghostfreeapplay->ID = $this->request->getPost("ID");
        $ghostfreeapplay->NAME = $this->request->getPost("NAME");
        $ghostfreeapplay->PHONE = $this->request->getPost("PHONE");
        $ghostfreeapplay->APPLAYNUM = $this->request->getPost("APPLAYNUM");
        $ghostfreeapplay->UPDATETIME = $this->request->getPost("UPDATETIME");
        $ghostfreeapplay->CRTIME = $this->request->getPost("CRTIME");
        $ghostfreeapplay->REASON = $this->request->getPost("REASON");
        if (!$ghostfreeapplay->save()) {
            foreach ($ghostfreeapplay->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "new"));
        } else {
            $this->flash->success("ghost free applay was created successfully");
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $ghostfreeapplay = GhostFreeApplay::findFirst("ID='$ID'");
        if (!$ghostfreeapplay) {
            $this->flash->error("ghost free applay does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }
        $ghostfreeapplay->ID = $this->request->getPost("ID");
        $ghostfreeapplay->NAME = $this->request->getPost("NAME");
        $ghostfreeapplay->PHONE = $this->request->getPost("PHONE");
        $ghostfreeapplay->APPLAYNUM = $this->request->getPost("APPLAYNUM");
        $ghostfreeapplay->UPDATETIME = $this->request->getPost("UPDATETIME");
        $ghostfreeapplay->CRTIME = $this->request->getPost("CRTIME");
        $ghostfreeapplay->REASON = $this->request->getPost("REASON");
        if (!$ghostfreeapplay->save()) {
            foreach ($ghostfreeapplay->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "edit", "params" => array($ghostfreeapplay->ID)));
        } else {
            $this->flash->success("ghost free applay was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $ghostfreeapplay = GhostFreeApplay::findFirst('ID="'.$ID.'"');
        if (!$ghostfreeapplay) {
            $this->flash->error("ghost free applay was not found");
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }

        if (!$ghostfreeapplay->delete()) {
            foreach ($ghostfreeapplay->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "search"));
        } else {
            $this->flash->success("ghost free applay was deleted");
            return $this->dispatcher->forward(array("controller" => "ghostfreeapplay", "action" => "index"));
        }
    }

}
