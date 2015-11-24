<?php

use \Phalcon\Tag as Tag;

class COthersDbuserLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "COthersDbuserLog", $_POST);
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

        $cothersdbuserlog = COthersDbuserLog::find($parameters);
        if (count($cothersdbuserlog) == 0) {
            $this->flash->notice("The search did not find any c others dbuser log");
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cothersdbuserlog,
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

            $cothersdbuserlog = COthersDbuserLog::findFirst('ID="'.$ID.'"');
            if (!$cothersdbuserlog) {
                $this->flash->error("c others dbuser log was not found");
                return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
            }
            $this->view->setVar("ID", $cothersdbuserlog->ID);
        
            Tag::displayTo("ID", $cothersdbuserlog->ID);
            Tag::displayTo("USER_ID", $cothersdbuserlog->USER_ID);
            Tag::displayTo("COMM", $cothersdbuserlog->COMM);
            Tag::displayTo("CREATE_TIME", $cothersdbuserlog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

        $cothersdbuserlog = new COthersDbuserLog();
        $cothersdbuserlog->ID = $this->request->getPost("ID");
        $cothersdbuserlog->USER_ID = $this->request->getPost("USER_ID");
        $cothersdbuserlog->COMM = $this->request->getPost("COMM");
        $cothersdbuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$cothersdbuserlog->save()) {
            foreach ($cothersdbuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "new"));
        } else {
            $this->flash->success("c others dbuser log was created successfully");
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cothersdbuserlog = COthersDbuserLog::findFirst("ID='$ID'");
        if (!$cothersdbuserlog) {
            $this->flash->error("c others dbuser log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }
        $cothersdbuserlog->ID = $this->request->getPost("ID");
        $cothersdbuserlog->USER_ID = $this->request->getPost("USER_ID");
        $cothersdbuserlog->COMM = $this->request->getPost("COMM");
        $cothersdbuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$cothersdbuserlog->save()) {
            foreach ($cothersdbuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "edit", "params" => array($cothersdbuserlog->ID)));
        } else {
            $this->flash->success("c others dbuser log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cothersdbuserlog = COthersDbuserLog::findFirst('ID="'.$ID.'"');
        if (!$cothersdbuserlog) {
            $this->flash->error("c others dbuser log was not found");
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }

        if (!$cothersdbuserlog->delete()) {
            foreach ($cothersdbuserlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "search"));
        } else {
            $this->flash->success("c others dbuser log was deleted");
            return $this->dispatcher->forward(array("controller" => "cothersdbuserlog", "action" => "index"));
        }
    }

}
