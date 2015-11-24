<?php

use \Phalcon\Tag as Tag;

class COthersDbuserController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "COthersDbuser", $_POST);
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

        $cothersdbuser = COthersDbuser::find($parameters);
        if (count($cothersdbuser) == 0) {
            $this->flash->notice("The search did not find any c others dbuser");
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cothersdbuser,
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

            $cothersdbuser = COthersDbuser::findFirst('ID="'.$ID.'"');
            if (!$cothersdbuser) {
                $this->flash->error("c others dbuser was not found");
                return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
            }
            $this->view->setVar("ID", $cothersdbuser->ID);
        
            Tag::displayTo("ID", $cothersdbuser->ID);
            Tag::displayTo("NAME", $cothersdbuser->NAME);
            Tag::displayTo("PERSON_NAME", $cothersdbuser->PERSON_NAME);
            Tag::displayTo("MOBILE_PHONE", $cothersdbuser->MOBILE_PHONE);
            Tag::displayTo("CONTACT_PHONE", $cothersdbuser->CONTACT_PHONE);
            Tag::displayTo("ADDRESS", $cothersdbuser->ADDRESS);
            Tag::displayTo("OFFICE", $cothersdbuser->OFFICE);
            Tag::displayTo("DESCRIPTION", $cothersdbuser->DESCRIPTION);
            Tag::displayTo("CREATE_TIME", $cothersdbuser->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $cothersdbuser->UPDATE_TIME);
            Tag::displayTo("RELATE_CITY_IDS", $cothersdbuser->RELATE_CITY_IDS);
            Tag::displayTo("HIDDEN", $cothersdbuser->HIDDEN);
            Tag::displayTo("UUID", $cothersdbuser->UUID);
            Tag::displayTo("PASSWORD", $cothersdbuser->PASSWORD);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

        $cothersdbuser = new COthersDbuser();
        $cothersdbuser->ID = $this->request->getPost("ID");
        $cothersdbuser->NAME = $this->request->getPost("NAME");
        $cothersdbuser->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $cothersdbuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $cothersdbuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $cothersdbuser->ADDRESS = $this->request->getPost("ADDRESS");
        $cothersdbuser->OFFICE = $this->request->getPost("OFFICE");
        $cothersdbuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $cothersdbuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cothersdbuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cothersdbuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $cothersdbuser->HIDDEN = $this->request->getPost("HIDDEN");
        $cothersdbuser->UUID = $this->request->getPost("UUID");
        $cothersdbuser->PASSWORD = $this->request->getPost("PASSWORD");
        if (!$cothersdbuser->save()) {
            foreach ($cothersdbuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "new"));
        } else {
            $this->flash->success("c others dbuser was created successfully");
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cothersdbuser = COthersDbuser::findFirst("ID='$ID'");
        if (!$cothersdbuser) {
            $this->flash->error("c others dbuser does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }
        $cothersdbuser->ID = $this->request->getPost("ID");
        $cothersdbuser->NAME = $this->request->getPost("NAME");
        $cothersdbuser->PERSON_NAME = $this->request->getPost("PERSON_NAME");
        $cothersdbuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $cothersdbuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $cothersdbuser->ADDRESS = $this->request->getPost("ADDRESS");
        $cothersdbuser->OFFICE = $this->request->getPost("OFFICE");
        $cothersdbuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $cothersdbuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cothersdbuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cothersdbuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $cothersdbuser->HIDDEN = $this->request->getPost("HIDDEN");
        $cothersdbuser->UUID = $this->request->getPost("UUID");
        $cothersdbuser->PASSWORD = $this->request->getPost("PASSWORD");
        if (!$cothersdbuser->save()) {
            foreach ($cothersdbuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "edit", "params" => array($cothersdbuser->ID)));
        } else {
            $this->flash->success("c others dbuser was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cothersdbuser = COthersDbuser::findFirst('ID="'.$ID.'"');
        if (!$cothersdbuser) {
            $this->flash->error("c others dbuser was not found");
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }

        if (!$cothersdbuser->delete()) {
            foreach ($cothersdbuser->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "search"));
        } else {
            $this->flash->success("c others dbuser was deleted");
            return $this->dispatcher->forward(array("controller" => "cothersdbuser", "action" => "index"));
        }
    }

}
