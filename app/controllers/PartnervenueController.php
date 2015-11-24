<?php

use \Phalcon\Tag as Tag;

class PartnerVenueController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PartnerVenue", $_POST);
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

        $partnervenue = PartnerVenue::find($parameters);
        if (count($partnervenue) == 0) {
            $this->flash->notice("The search did not find any partner venue");
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $partnervenue,
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

            $partnervenue = PartnerVenue::findFirst('ID="'.$ID.'"');
            if (!$partnervenue) {
                $this->flash->error("partner venue was not found");
                return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
            }
            $this->view->setVar("ID", $partnervenue->ID);
        
            Tag::displayTo("ID", $partnervenue->ID);
            Tag::displayTo("VENUE_ID", $partnervenue->VENUE_ID);
            Tag::displayTo("PARTNER_ID", $partnervenue->PARTNER_ID);
            Tag::displayTo("CREATE_TIME", $partnervenue->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $partnervenue->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

        $partnervenue = new PartnerVenue();
        $partnervenue->ID = $this->request->getPost("ID");
        $partnervenue->VENUE_ID = $this->request->getPost("VENUE_ID");
        $partnervenue->PARTNER_ID = $this->request->getPost("PARTNER_ID");
        $partnervenue->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $partnervenue->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$partnervenue->save()) {
            foreach ($partnervenue->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "new"));
        } else {
            $this->flash->success("partner venue was created successfully");
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $partnervenue = PartnerVenue::findFirst("ID='$ID'");
        if (!$partnervenue) {
            $this->flash->error("partner venue does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }
        $partnervenue->ID = $this->request->getPost("ID");
        $partnervenue->VENUE_ID = $this->request->getPost("VENUE_ID");
        $partnervenue->PARTNER_ID = $this->request->getPost("PARTNER_ID");
        $partnervenue->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $partnervenue->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$partnervenue->save()) {
            foreach ($partnervenue->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "edit", "params" => array($partnervenue->ID)));
        } else {
            $this->flash->success("partner venue was updated successfully");
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $partnervenue = PartnerVenue::findFirst('ID="'.$ID.'"');
        if (!$partnervenue) {
            $this->flash->error("partner venue was not found");
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }

        if (!$partnervenue->delete()) {
            foreach ($partnervenue->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "search"));
        } else {
            $this->flash->success("partner venue was deleted");
            return $this->dispatcher->forward(array("controller" => "partnervenue", "action" => "index"));
        }
    }

}
