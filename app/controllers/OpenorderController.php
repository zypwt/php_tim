<?php

use \Phalcon\Tag as Tag;

class OpenorderController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "Openorder", $_POST);
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

        $openorder = Openorder::find($parameters);
        if (count($openorder) == 0) {
            $this->flash->notice("The search did not find any openorder");
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $openorder,
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

            $openorder = Openorder::findFirst('ID="'.$ID.'"');
            if (!$openorder) {
                $this->flash->error("openorder was not found");
                return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
            }
            $this->view->setVar("ID", $openorder->ID);
        
            Tag::displayTo("ID", $openorder->ID);
            Tag::displayTo("IDNO", $openorder->IDNO);
            Tag::displayTo("TYPE", $openorder->TYPE);
            Tag::displayTo("STATE", $openorder->STATE);
            Tag::displayTo("TIME", $openorder->TIME);
            Tag::displayTo("CREATETIME", $openorder->CREATETIME);
            Tag::displayTo("READSTATUS", $openorder->READSTATUS);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

        $openorder = new Openorder();
        $openorder->ID = $this->request->getPost("ID");
        $openorder->IDNO = $this->request->getPost("IDNO");
        $openorder->TYPE = $this->request->getPost("TYPE");
        $openorder->STATE = $this->request->getPost("STATE");
        $openorder->TIME = $this->request->getPost("TIME");
        $openorder->CREATETIME = $this->request->getPost("CREATETIME");
        $openorder->READSTATUS = $this->request->getPost("READSTATUS");
        if (!$openorder->save()) {
            foreach ($openorder->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "new"));
        } else {
            $this->flash->success("openorder was created successfully");
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $openorder = Openorder::findFirst("ID='$ID'");
        if (!$openorder) {
            $this->flash->error("openorder does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }
        $openorder->ID = $this->request->getPost("ID");
        $openorder->IDNO = $this->request->getPost("IDNO");
        $openorder->TYPE = $this->request->getPost("TYPE");
        $openorder->STATE = $this->request->getPost("STATE");
        $openorder->TIME = $this->request->getPost("TIME");
        $openorder->CREATETIME = $this->request->getPost("CREATETIME");
        $openorder->READSTATUS = $this->request->getPost("READSTATUS");
        if (!$openorder->save()) {
            foreach ($openorder->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "edit", "params" => array($openorder->ID)));
        } else {
            $this->flash->success("openorder was updated successfully");
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $openorder = Openorder::findFirst('ID="'.$ID.'"');
        if (!$openorder) {
            $this->flash->error("openorder was not found");
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }

        if (!$openorder->delete()) {
            foreach ($openorder->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "search"));
        } else {
            $this->flash->success("openorder was deleted");
            return $this->dispatcher->forward(array("controller" => "openorder", "action" => "index"));
        }
    }

}
