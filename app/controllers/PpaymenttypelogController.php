<?php

use \Phalcon\Tag as Tag;

class PPaymentTypeLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PPaymentTypeLog", $_POST);
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

        $ppaymenttypelog = PPaymentTypeLog::find($parameters);
        if (count($ppaymenttypelog) == 0) {
            $this->flash->notice("The search did not find any p payment type log");
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ppaymenttypelog,
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

            $ppaymenttypelog = PPaymentTypeLog::findFirst('ID="'.$ID.'"');
            if (!$ppaymenttypelog) {
                $this->flash->error("p payment type log was not found");
                return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
            }
            $this->view->setVar("ID", $ppaymenttypelog->ID);
        
            Tag::displayTo("ID", $ppaymenttypelog->ID);
            Tag::displayTo("USER_ID", $ppaymenttypelog->USER_ID);
            Tag::displayTo("COMM", $ppaymenttypelog->COMM);
            Tag::displayTo("CREATE_TIME", $ppaymenttypelog->CREATE_TIME);
            Tag::displayTo("TYPE_ID", $ppaymenttypelog->TYPE_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

        $ppaymenttypelog = new PPaymentTypeLog();
        $ppaymenttypelog->ID = $this->request->getPost("ID");
        $ppaymenttypelog->USER_ID = $this->request->getPost("USER_ID");
        $ppaymenttypelog->COMM = $this->request->getPost("COMM");
        $ppaymenttypelog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymenttypelog->TYPE_ID = $this->request->getPost("TYPE_ID");
        if (!$ppaymenttypelog->save()) {
            foreach ($ppaymenttypelog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "new"));
        } else {
            $this->flash->success("p payment type log was created successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $ppaymenttypelog = PPaymentTypeLog::findFirst("ID='$ID'");
        if (!$ppaymenttypelog) {
            $this->flash->error("p payment type log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }
        $ppaymenttypelog->ID = $this->request->getPost("ID");
        $ppaymenttypelog->USER_ID = $this->request->getPost("USER_ID");
        $ppaymenttypelog->COMM = $this->request->getPost("COMM");
        $ppaymenttypelog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymenttypelog->TYPE_ID = $this->request->getPost("TYPE_ID");
        if (!$ppaymenttypelog->save()) {
            foreach ($ppaymenttypelog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "edit", "params" => array($ppaymenttypelog->ID)));
        } else {
            $this->flash->success("p payment type log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $ppaymenttypelog = PPaymentTypeLog::findFirst('ID="'.$ID.'"');
        if (!$ppaymenttypelog) {
            $this->flash->error("p payment type log was not found");
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }

        if (!$ppaymenttypelog->delete()) {
            foreach ($ppaymenttypelog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "search"));
        } else {
            $this->flash->success("p payment type log was deleted");
            return $this->dispatcher->forward(array("controller" => "ppaymenttypelog", "action" => "index"));
        }
    }

}
