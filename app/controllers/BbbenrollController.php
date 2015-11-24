<?php

use \Phalcon\Tag as Tag;

class BbbEnrollController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "BbbEnroll", $_POST);
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

        $bbbenroll = BbbEnroll::find($parameters);
        if (count($bbbenroll) == 0) {
            $this->flash->notice("The search did not find any bbb enroll");
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $bbbenroll,
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

            $bbbenroll = BbbEnroll::findFirst('ID="'.$ID.'"');
            if (!$bbbenroll) {
                $this->flash->error("bbb enroll was not found");
                return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
            }
            $this->view->setVar("ID", $bbbenroll->ID);
        
            Tag::displayTo("ID", $bbbenroll->ID);
            Tag::displayTo("NAME", $bbbenroll->NAME);
            Tag::displayTo("PHONE", $bbbenroll->PHONE);
            Tag::displayTo("SCORE", $bbbenroll->SCORE);
            Tag::displayTo("UPDATETIME", $bbbenroll->UPDATETIME);
            Tag::displayTo("CRTIME", $bbbenroll->CRTIME);
            Tag::displayTo("VERSION", $bbbenroll->VERSION);
            Tag::displayTo("SHARELINK", $bbbenroll->SHARELINK);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

        $bbbenroll = new BbbEnroll();
        $bbbenroll->ID = $this->request->getPost("ID");
        $bbbenroll->NAME = $this->request->getPost("NAME");
        $bbbenroll->PHONE = $this->request->getPost("PHONE");
        $bbbenroll->SCORE = $this->request->getPost("SCORE");
        $bbbenroll->UPDATETIME = $this->request->getPost("UPDATETIME");
        $bbbenroll->CRTIME = $this->request->getPost("CRTIME");
        $bbbenroll->VERSION = $this->request->getPost("VERSION");
        $bbbenroll->SHARELINK = $this->request->getPost("SHARELINK");
        if (!$bbbenroll->save()) {
            foreach ($bbbenroll->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "new"));
        } else {
            $this->flash->success("bbb enroll was created successfully");
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $bbbenroll = BbbEnroll::findFirst("ID='$ID'");
        if (!$bbbenroll) {
            $this->flash->error("bbb enroll does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }
        $bbbenroll->ID = $this->request->getPost("ID");
        $bbbenroll->NAME = $this->request->getPost("NAME");
        $bbbenroll->PHONE = $this->request->getPost("PHONE");
        $bbbenroll->SCORE = $this->request->getPost("SCORE");
        $bbbenroll->UPDATETIME = $this->request->getPost("UPDATETIME");
        $bbbenroll->CRTIME = $this->request->getPost("CRTIME");
        $bbbenroll->VERSION = $this->request->getPost("VERSION");
        $bbbenroll->SHARELINK = $this->request->getPost("SHARELINK");
        if (!$bbbenroll->save()) {
            foreach ($bbbenroll->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "edit", "params" => array($bbbenroll->ID)));
        } else {
            $this->flash->success("bbb enroll was updated successfully");
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $bbbenroll = BbbEnroll::findFirst('ID="'.$ID.'"');
        if (!$bbbenroll) {
            $this->flash->error("bbb enroll was not found");
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }

        if (!$bbbenroll->delete()) {
            foreach ($bbbenroll->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "search"));
        } else {
            $this->flash->success("bbb enroll was deleted");
            return $this->dispatcher->forward(array("controller" => "bbbenroll", "action" => "index"));
        }
    }

}
