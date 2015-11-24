<?php

use \Phalcon\Tag as Tag;

class CDiscountUserController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CDiscountUser", $_POST);
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

        $cdiscountuser = CDiscountUser::find($parameters);
        if (count($cdiscountuser) == 0) {
            $this->flash->notice("The search did not find any c discount user");
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cdiscountuser,
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

            $cdiscountuser = CDiscountUser::findFirst('ID="'.$ID.'"');
            if (!$cdiscountuser) {
                $this->flash->error("c discount user was not found");
                return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
            }
            $this->view->setVar("ID", $cdiscountuser->ID);
        
            Tag::displayTo("ID", $cdiscountuser->ID);
            Tag::displayTo("NAME", $cdiscountuser->NAME);
            Tag::displayTo("MOBILE_PHONE", $cdiscountuser->MOBILE_PHONE);
            Tag::displayTo("CONTACT_PHONE", $cdiscountuser->CONTACT_PHONE);
            Tag::displayTo("ADDRESS", $cdiscountuser->ADDRESS);
            Tag::displayTo("OFFICE", $cdiscountuser->OFFICE);
            Tag::displayTo("DESCRIPTION", $cdiscountuser->DESCRIPTION);
            Tag::displayTo("CREATE_TIME", $cdiscountuser->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $cdiscountuser->UPDATE_TIME);
            Tag::displayTo("MAX_DISCOUNT", $cdiscountuser->MAX_DISCOUNT);
            Tag::displayTo("RELATE_CITY_IDS", $cdiscountuser->RELATE_CITY_IDS);
            Tag::displayTo("HIDDEN", $cdiscountuser->HIDDEN);
            Tag::displayTo("AGENCY_ID", $cdiscountuser->AGENCY_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

        $cdiscountuser = new CDiscountUser();
        $cdiscountuser->ID = $this->request->getPost("ID");
        $cdiscountuser->NAME = $this->request->getPost("NAME");
        $cdiscountuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $cdiscountuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $cdiscountuser->ADDRESS = $this->request->getPost("ADDRESS");
        $cdiscountuser->OFFICE = $this->request->getPost("OFFICE");
        $cdiscountuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $cdiscountuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cdiscountuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cdiscountuser->MAX_DISCOUNT = $this->request->getPost("MAX_DISCOUNT");
        $cdiscountuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $cdiscountuser->HIDDEN = $this->request->getPost("HIDDEN");
        $cdiscountuser->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        if (!$cdiscountuser->save()) {
            foreach ($cdiscountuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "new"));
        } else {
            $this->flash->success("c discount user was created successfully");
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cdiscountuser = CDiscountUser::findFirst("ID='$ID'");
        if (!$cdiscountuser) {
            $this->flash->error("c discount user does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }
        $cdiscountuser->ID = $this->request->getPost("ID");
        $cdiscountuser->NAME = $this->request->getPost("NAME");
        $cdiscountuser->MOBILE_PHONE = $this->request->getPost("MOBILE_PHONE");
        $cdiscountuser->CONTACT_PHONE = $this->request->getPost("CONTACT_PHONE");
        $cdiscountuser->ADDRESS = $this->request->getPost("ADDRESS");
        $cdiscountuser->OFFICE = $this->request->getPost("OFFICE");
        $cdiscountuser->DESCRIPTION = $this->request->getPost("DESCRIPTION");
        $cdiscountuser->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cdiscountuser->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cdiscountuser->MAX_DISCOUNT = $this->request->getPost("MAX_DISCOUNT");
        $cdiscountuser->RELATE_CITY_IDS = $this->request->getPost("RELATE_CITY_IDS");
        $cdiscountuser->HIDDEN = $this->request->getPost("HIDDEN");
        $cdiscountuser->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        if (!$cdiscountuser->save()) {
            foreach ($cdiscountuser->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "edit", "params" => array($cdiscountuser->ID)));
        } else {
            $this->flash->success("c discount user was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cdiscountuser = CDiscountUser::findFirst('ID="'.$ID.'"');
        if (!$cdiscountuser) {
            $this->flash->error("c discount user was not found");
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }

        if (!$cdiscountuser->delete()) {
            foreach ($cdiscountuser->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "search"));
        } else {
            $this->flash->success("c discount user was deleted");
            return $this->dispatcher->forward(array("controller" => "cdiscountuser", "action" => "index"));
        }
    }

}
