<?php

use \Phalcon\Tag as Tag;

class CArrearageUserLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CArrearageUserLog", $_POST);
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

        $carrearageuserlog = CArrearageUserLog::find($parameters);
        if (count($carrearageuserlog) == 0) {
            $this->flash->notice("The search did not find any c arrearage user log");
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $carrearageuserlog,
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

            $carrearageuserlog = CArrearageUserLog::findFirst('ID="'.$ID.'"');
            if (!$carrearageuserlog) {
                $this->flash->error("c arrearage user log was not found");
                return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
            }
            $this->view->setVar("ID", $carrearageuserlog->ID);
        
            Tag::displayTo("ID", $carrearageuserlog->ID);
            Tag::displayTo("USER_ID", $carrearageuserlog->USER_ID);
            Tag::displayTo("COMM", $carrearageuserlog->COMM);
            Tag::displayTo("CREATE_TIME", $carrearageuserlog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

        $carrearageuserlog = new CArrearageUserLog();
        $carrearageuserlog->ID = $this->request->getPost("ID");
        $carrearageuserlog->USER_ID = $this->request->getPost("USER_ID");
        $carrearageuserlog->COMM = $this->request->getPost("COMM");
        $carrearageuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$carrearageuserlog->save()) {
            foreach ($carrearageuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "new"));
        } else {
            $this->flash->success("c arrearage user log was created successfully");
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $carrearageuserlog = CArrearageUserLog::findFirst("ID='$ID'");
        if (!$carrearageuserlog) {
            $this->flash->error("c arrearage user log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }
        $carrearageuserlog->ID = $this->request->getPost("ID");
        $carrearageuserlog->USER_ID = $this->request->getPost("USER_ID");
        $carrearageuserlog->COMM = $this->request->getPost("COMM");
        $carrearageuserlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$carrearageuserlog->save()) {
            foreach ($carrearageuserlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "edit", "params" => array($carrearageuserlog->ID)));
        } else {
            $this->flash->success("c arrearage user log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $carrearageuserlog = CArrearageUserLog::findFirst('ID="'.$ID.'"');
        if (!$carrearageuserlog) {
            $this->flash->error("c arrearage user log was not found");
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }

        if (!$carrearageuserlog->delete()) {
            foreach ($carrearageuserlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "search"));
        } else {
            $this->flash->success("c arrearage user log was deleted");
            return $this->dispatcher->forward(array("controller" => "carrearageuserlog", "action" => "index"));
        }
    }

}
