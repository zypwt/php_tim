<?php

use \Phalcon\Tag as Tag;

class AppIndexModuleController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "AppIndexModule", $_POST);
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

        $appindexmodule = AppIndexModule::find($parameters);
        if (count($appindexmodule) == 0) {
            $this->flash->notice("The search did not find any app index module");
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $appindexmodule,
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

            $appindexmodule = AppIndexModule::findFirst('ID="'.$ID.'"');
            if (!$appindexmodule) {
                $this->flash->error("app index module was not found");
                return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
            }
            $this->view->setVar("ID", $appindexmodule->ID);
        
            Tag::displayTo("ID", $appindexmodule->ID);
            Tag::displayTo("TYPE", $appindexmodule->TYPE);
            Tag::displayTo("CATEGORY", $appindexmodule->CATEGORY);
            Tag::displayTo("BIGPIC", $appindexmodule->BIGPIC);
            Tag::displayTo("SMALLPIC", $appindexmodule->SMALLPIC);
            Tag::displayTo("TOPPIC", $appindexmodule->TOPPIC);
            Tag::displayTo("URL", $appindexmodule->URL);
            Tag::displayTo("REMARK", $appindexmodule->REMARK);
            Tag::displayTo("RANK", $appindexmodule->RANK);
            Tag::displayTo("CITYID", $appindexmodule->CITYID);
            Tag::displayTo("ISVISIBLE", $appindexmodule->ISVISIBLE);
            Tag::displayTo("CREATEUSER", $appindexmodule->CREATEUSER);
            Tag::displayTo("CREATETIME", $appindexmodule->CREATETIME);
            Tag::displayTo("UPDATETIME", $appindexmodule->UPDATETIME);
            Tag::displayTo("UPDATEUSER", $appindexmodule->UPDATEUSER);
            Tag::displayTo("NAME", $appindexmodule->NAME);
            Tag::displayTo("STATUS", $appindexmodule->STATUS);
            Tag::displayTo("AUDITSTATUS", $appindexmodule->AUDITSTATUS);
            Tag::displayTo("STARTIME", $appindexmodule->STARTIME);
            Tag::displayTo("ENDTIME", $appindexmodule->ENDTIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

        $appindexmodule = new AppIndexModule();
        $appindexmodule->ID = $this->request->getPost("ID");
        $appindexmodule->TYPE = $this->request->getPost("TYPE");
        $appindexmodule->CATEGORY = $this->request->getPost("CATEGORY");
        $appindexmodule->BIGPIC = $this->request->getPost("BIGPIC");
        $appindexmodule->SMALLPIC = $this->request->getPost("SMALLPIC");
        $appindexmodule->TOPPIC = $this->request->getPost("TOPPIC");
        $appindexmodule->URL = $this->request->getPost("URL");
        $appindexmodule->REMARK = $this->request->getPost("REMARK");
        $appindexmodule->RANK = $this->request->getPost("RANK");
        $appindexmodule->CITYID = $this->request->getPost("CITYID");
        $appindexmodule->ISVISIBLE = $this->request->getPost("ISVISIBLE");
        $appindexmodule->CREATEUSER = $this->request->getPost("CREATEUSER");
        $appindexmodule->CREATETIME = $this->request->getPost("CREATETIME");
        $appindexmodule->UPDATETIME = $this->request->getPost("UPDATETIME");
        $appindexmodule->UPDATEUSER = $this->request->getPost("UPDATEUSER");
        $appindexmodule->NAME = $this->request->getPost("NAME");
        $appindexmodule->STATUS = $this->request->getPost("STATUS");
        $appindexmodule->AUDITSTATUS = $this->request->getPost("AUDITSTATUS");
        $appindexmodule->STARTIME = $this->request->getPost("STARTIME");
        $appindexmodule->ENDTIME = $this->request->getPost("ENDTIME");
        if (!$appindexmodule->save()) {
            foreach ($appindexmodule->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "new"));
        } else {
            $this->flash->success("app index module was created successfully");
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $appindexmodule = AppIndexModule::findFirst("ID='$ID'");
        if (!$appindexmodule) {
            $this->flash->error("app index module does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }
        $appindexmodule->ID = $this->request->getPost("ID");
        $appindexmodule->TYPE = $this->request->getPost("TYPE");
        $appindexmodule->CATEGORY = $this->request->getPost("CATEGORY");
        $appindexmodule->BIGPIC = $this->request->getPost("BIGPIC");
        $appindexmodule->SMALLPIC = $this->request->getPost("SMALLPIC");
        $appindexmodule->TOPPIC = $this->request->getPost("TOPPIC");
        $appindexmodule->URL = $this->request->getPost("URL");
        $appindexmodule->REMARK = $this->request->getPost("REMARK");
        $appindexmodule->RANK = $this->request->getPost("RANK");
        $appindexmodule->CITYID = $this->request->getPost("CITYID");
        $appindexmodule->ISVISIBLE = $this->request->getPost("ISVISIBLE");
        $appindexmodule->CREATEUSER = $this->request->getPost("CREATEUSER");
        $appindexmodule->CREATETIME = $this->request->getPost("CREATETIME");
        $appindexmodule->UPDATETIME = $this->request->getPost("UPDATETIME");
        $appindexmodule->UPDATEUSER = $this->request->getPost("UPDATEUSER");
        $appindexmodule->NAME = $this->request->getPost("NAME");
        $appindexmodule->STATUS = $this->request->getPost("STATUS");
        $appindexmodule->AUDITSTATUS = $this->request->getPost("AUDITSTATUS");
        $appindexmodule->STARTIME = $this->request->getPost("STARTIME");
        $appindexmodule->ENDTIME = $this->request->getPost("ENDTIME");
        if (!$appindexmodule->save()) {
            foreach ($appindexmodule->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "edit", "params" => array($appindexmodule->ID)));
        } else {
            $this->flash->success("app index module was updated successfully");
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $appindexmodule = AppIndexModule::findFirst('ID="'.$ID.'"');
        if (!$appindexmodule) {
            $this->flash->error("app index module was not found");
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }

        if (!$appindexmodule->delete()) {
            foreach ($appindexmodule->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "search"));
        } else {
            $this->flash->success("app index module was deleted");
            return $this->dispatcher->forward(array("controller" => "appindexmodule", "action" => "index"));
        }
    }

}
