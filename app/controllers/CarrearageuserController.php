<?php

use \Phalcon\Tag as Tag;

class CArrearageUserController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CArrearageUser", $_POST);
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

        $carrearageuser = CArrearageUser::find($parameters);
        if (count($carrearageuser) == 0) {
            $this->flash->notice("The search did not find any c arrearage user");
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $carrearageuser,
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

            $carrearageuser = CArrearageUser::findFirst('ID="'.$ID.'"');
            if (!$carrearageuser) {
                $this->flash->error("c arrearage user was not found");
                return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
            }
            $this->view->setVar("ID", $carrearageuser->ID);
        
            Tag::displayTo("ID", $carrearageuser->ID);
            Tag::displayTo("NAME", $carrearageuser->NAME);
            Tag::displayTo("MOBILE_PHONE", $carrearageuser->MOBILE_PHONE);
            Tag::displayTo("CONTACT_PHONE", $carrearageuser->CONTACT_PHONE);
            Tag::displayTo("ADDRESS", $carrearageuser->ADDRESS);
            Tag::displayTo("OFFICE", $carrearageuser->OFFICE);
            Tag::displayTo("DESCRIPTION", $carrearageuser->DESCRIPTION);
            Tag::displayTo("CREATE_TIME", $carrearageuser->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $carrearageuser->UPDATE_TIME);
            Tag::displayTo("MAX_OWED", $carrearageuser->MAX_OWED);
            Tag::displayTo("NOW_OWED", $carrearageuser->NOW_OWED);
            Tag::displayTo("DAY_OWED", $carrearageuser->DAY_OWED);
            Tag::displayTo("RELATE_CITY_IDS", $carrearageuser->RELATE_CITY_IDS);
            Tag::displayTo("HIDDEN", $carrearageuser->HIDDEN);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

        $carrearageuser = new CArrearageUser();
        $carrearageuser->ID = $this->request->getPost("ID");
        $carrearageuser->NAME = $this->request->getPost("NAME");
        $carrearageuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $carrearageuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $carrearageuser->ADDRESS = $this->request->getPost("ADDRESS");
        $carrearageuser->OFFICE = $this->request->getPost("OFFICE");
        $carrearageuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $carrearageuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $carrearageuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $carrearageuser->MAX_OWED = $this->request->getPost("MAX_OWED");
        $carrearageuser->NOW_OWED = $this->request->getPost("NOW_OWED");
        $carrearageuser->DAY_OWED = $this->request->getPost("DAY_OWED");
        $carrearageuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $carrearageuser->HIDDEN = $this->request->getPost("HIDDEN");
        if (!$carrearageuser->save()) {
            foreach ($carrearageuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "new"));
        } else {
            $this->flash->success("c arrearage user was created successfully");
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $carrearageuser = CArrearageUser::findFirst("ID='$ID'");
        if (!$carrearageuser) {
            $this->flash->error("c arrearage user does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }
        $carrearageuser->ID = $this->request->getPost("ID");
        $carrearageuser->NAME = $this->request->getPost("NAME");
        $carrearageuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $carrearageuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $carrearageuser->ADDRESS = $this->request->getPost("ADDRESS");
        $carrearageuser->OFFICE = $this->request->getPost("OFFICE");
        $carrearageuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $carrearageuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $carrearageuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $carrearageuser->MAX_OWED = $this->request->getPost("MAX_OWED");
        $carrearageuser->NOW_OWED = $this->request->getPost("NOW_OWED");
        $carrearageuser->DAY_OWED = $this->request->getPost("DAY_OWED");
        $carrearageuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $carrearageuser->HIDDEN = $this->request->getPost("HIDDEN");
        if (!$carrearageuser->save()) {
            foreach ($carrearageuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "edit", "params" => array($carrearageuser->ID)));
        } else {
            $this->flash->success("c arrearage user was updated successfully");
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $carrearageuser = CArrearageUser::findFirst('ID="'.$ID.'"');
        if (!$carrearageuser) {
            $this->flash->error("c arrearage user was not found");
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }

        if (!$carrearageuser->delete()) {
            foreach ($carrearageuser->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "search"));
        } else {
            $this->flash->success("c arrearage user was deleted");
            return $this->dispatcher->forward(array("controller" => "carrearageuser", "action" => "index"));
        }
    }

}
