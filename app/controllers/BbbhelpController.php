<?php

use \Phalcon\Tag as Tag;

class BbbHelpController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "BbbHelp", $_POST);
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

        $bbbhelp = BbbHelp::find($parameters);
        if (count($bbbhelp) == 0) {
            $this->flash->notice("The search did not find any bbb help");
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $bbbhelp,
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

            $bbbhelp = BbbHelp::findFirst('ID="'.$ID.'"');
            if (!$bbbhelp) {
                $this->flash->error("bbb help was not found");
                return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
            }
            $this->view->setVar("ID", $bbbhelp->ID);
        
            Tag::displayTo("ID", $bbbhelp->ID);
            Tag::displayTo("PHONE", $bbbhelp->PHONE);
            Tag::displayTo("SCORE", $bbbhelp->SCORE);
            Tag::displayTo("UPDATETIME", $bbbhelp->UPDATETIME);
            Tag::displayTo("CRTIME", $bbbhelp->CRTIME);
            Tag::displayTo("COOKIESID", $bbbhelp->COOKIESID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

        $bbbhelp = new BbbHelp();
        $bbbhelp->ID = $this->request->getPost("ID");
        $bbbhelp->PHONE = $this->request->getPost("PHONE");
        $bbbhelp->SCORE = $this->request->getPost("SCORE");
        $bbbhelp->UPDATETIME = $this->request->getPost("UPDATETIME");
        $bbbhelp->CRTIME = $this->request->getPost("CRTIME");
        $bbbhelp->COOKIESID = $this->request->getPost("COOKIESID");
        if (!$bbbhelp->save()) {
            foreach ($bbbhelp->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "new"));
        } else {
            $this->flash->success("bbb help was created successfully");
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $bbbhelp = BbbHelp::findFirst("ID='$ID'");
        if (!$bbbhelp) {
            $this->flash->error("bbb help does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }
        $bbbhelp->ID = $this->request->getPost("ID");
        $bbbhelp->PHONE = $this->request->getPost("PHONE");
        $bbbhelp->SCORE = $this->request->getPost("SCORE");
        $bbbhelp->UPDATETIME = $this->request->getPost("UPDATETIME");
        $bbbhelp->CRTIME = $this->request->getPost("CRTIME");
        $bbbhelp->COOKIESID = $this->request->getPost("COOKIESID");
        if (!$bbbhelp->save()) {
            foreach ($bbbhelp->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "edit", "params" => array($bbbhelp->ID)));
        } else {
            $this->flash->success("bbb help was updated successfully");
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $bbbhelp = BbbHelp::findFirst('ID="'.$ID.'"');
        if (!$bbbhelp) {
            $this->flash->error("bbb help was not found");
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }

        if (!$bbbhelp->delete()) {
            foreach ($bbbhelp->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "search"));
        } else {
            $this->flash->success("bbb help was deleted");
            return $this->dispatcher->forward(array("controller" => "bbbhelp", "action" => "index"));
        }
    }

}
