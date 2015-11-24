<?php

use \Phalcon\Tag as Tag;

class FapiaoInfoDetailController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "FapiaoInfoDetail", $_POST);
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

        $fapiaoinfodetail = FapiaoInfoDetail::find($parameters);
        if (count($fapiaoinfodetail) == 0) {
            $this->flash->notice("The search did not find any fapiao info detail");
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $fapiaoinfodetail,
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

            $fapiaoinfodetail = FapiaoInfoDetail::findFirst('ID="'.$ID.'"');
            if (!$fapiaoinfodetail) {
                $this->flash->error("fapiao info detail was not found");
                return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
            }
            $this->view->setVar("ID", $fapiaoinfodetail->ID);
        
            Tag::displayTo("ID", $fapiaoinfodetail->ID);
            Tag::displayTo("UUID", $fapiaoinfodetail->UUID);
            Tag::displayTo("FAPIAO_NO", $fapiaoinfodetail->FAPIAO_NO);
            Tag::displayTo("MONEY", $fapiaoinfodetail->MONEY);
            Tag::displayTo("OPT_TIME", $fapiaoinfodetail->OPT_TIME);
            Tag::displayTo("OPT_NAME", $fapiaoinfodetail->OPT_NAME);
            Tag::displayTo("REMARK", $fapiaoinfodetail->REMARK);
            Tag::displayTo("FAPIAO_INFO_ID", $fapiaoinfodetail->FAPIAO_INFO_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

        $fapiaoinfodetail = new FapiaoInfoDetail();
        $fapiaoinfodetail->ID = $this->request->getPost("ID");
        $fapiaoinfodetail->UUID = $this->request->getPost("UUID");
        $fapiaoinfodetail->FAPIAO_NO = $this->request->getPost("FAPIAO_NO");
        $fapiaoinfodetail->MONEY = $this->request->getPost("MONEY");
        $fapiaoinfodetail->OPT_TIME = $this->request->getPost("OPT_TIME");
        $fapiaoinfodetail->OPT_NAME = $this->request->getPost("OPT_NAME");
        $fapiaoinfodetail->REMARK = $this->request->getPost("REMARK");
        $fapiaoinfodetail->FAPIAO_INFO_ID = $this->request->getPost("FAPIAO_INFO_ID");
        if (!$fapiaoinfodetail->save()) {
            foreach ($fapiaoinfodetail->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "new"));
        } else {
            $this->flash->success("fapiao info detail was created successfully");
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $fapiaoinfodetail = FapiaoInfoDetail::findFirst("ID='$ID'");
        if (!$fapiaoinfodetail) {
            $this->flash->error("fapiao info detail does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }
        $fapiaoinfodetail->ID = $this->request->getPost("ID");
        $fapiaoinfodetail->UUID = $this->request->getPost("UUID");
        $fapiaoinfodetail->FAPIAO_NO = $this->request->getPost("FAPIAO_NO");
        $fapiaoinfodetail->MONEY = $this->request->getPost("MONEY");
        $fapiaoinfodetail->OPT_TIME = $this->request->getPost("OPT_TIME");
        $fapiaoinfodetail->OPT_NAME = $this->request->getPost("OPT_NAME");
        $fapiaoinfodetail->REMARK = $this->request->getPost("REMARK");
        $fapiaoinfodetail->FAPIAO_INFO_ID = $this->request->getPost("FAPIAO_INFO_ID");
        if (!$fapiaoinfodetail->save()) {
            foreach ($fapiaoinfodetail->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "edit", "params" => array($fapiaoinfodetail->ID)));
        } else {
            $this->flash->success("fapiao info detail was updated successfully");
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $fapiaoinfodetail = FapiaoInfoDetail::findFirst('ID="'.$ID.'"');
        if (!$fapiaoinfodetail) {
            $this->flash->error("fapiao info detail was not found");
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }

        if (!$fapiaoinfodetail->delete()) {
            foreach ($fapiaoinfodetail->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "search"));
        } else {
            $this->flash->success("fapiao info detail was deleted");
            return $this->dispatcher->forward(array("controller" => "fapiaoinfodetail", "action" => "index"));
        }
    }

}
