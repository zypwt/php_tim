<?php

use \Phalcon\Tag as Tag;

class OOrderTicketLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OOrderTicketLog", $_POST);
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

        $oorderticketlog = OOrderTicketLog::find($parameters);
        if (count($oorderticketlog) == 0) {
            $this->flash->notice("The search did not find any o order ticket log");
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oorderticketlog,
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

            $oorderticketlog = OOrderTicketLog::findFirst('ID="'.$ID.'"');
            if (!$oorderticketlog) {
                $this->flash->error("o order ticket log was not found");
                return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
            }
            $this->view->setVar("ID", $oorderticketlog->ID);
        
            Tag::displayTo("ID", $oorderticketlog->ID);
            Tag::displayTo("ORDER_ID", $oorderticketlog->ORDER_ID);
            Tag::displayTo("TICKET_ID", $oorderticketlog->TICKET_ID);
            Tag::displayTo("SCREENINGS", $oorderticketlog->SCREENINGS);
            Tag::displayTo("UUID", $oorderticketlog->UUID);
            Tag::displayTo("NAME", $oorderticketlog->NAME);
            Tag::displayTo("OLD_STATUS", $oorderticketlog->OLD_STATUS);
            Tag::displayTo("NEW_STATUS", $oorderticketlog->NEW_STATUS);
            Tag::displayTo("DESCRIBE", $oorderticketlog->DESCRIBE);
            Tag::displayTo("CREATE_TIME", $oorderticketlog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

        $oorderticketlog = new OOrderTicketLog();
        $oorderticketlog->ID = $this->request->getPost("ID");
        $oorderticketlog->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oorderticketlog->TICKET_ID = $this->request->getPost("TICKET_ID");
        $oorderticketlog->SCREENINGS = $this->request->getPost("SCREENINGS");
        $oorderticketlog->UUID = $this->request->getPost("UUID");
        $oorderticketlog->NAME = $this->request->getPost("NAME");
        $oorderticketlog->OLD_STATUS = $this->request->getPost("OLD_STATUS");
        $oorderticketlog->NEW_STATUS = $this->request->getPost("NEW_STATUS");
        $oorderticketlog->DESCRIBE = $this->request->getPost("DESCRIBE");
        $oorderticketlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$oorderticketlog->save()) {
            foreach ($oorderticketlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "new"));
        } else {
            $this->flash->success("o order ticket log was created successfully");
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $oorderticketlog = OOrderTicketLog::findFirst("ID='$ID'");
        if (!$oorderticketlog) {
            $this->flash->error("o order ticket log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }
        $oorderticketlog->ID = $this->request->getPost("ID");
        $oorderticketlog->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oorderticketlog->TICKET_ID = $this->request->getPost("TICKET_ID");
        $oorderticketlog->SCREENINGS = $this->request->getPost("SCREENINGS");
        $oorderticketlog->UUID = $this->request->getPost("UUID");
        $oorderticketlog->NAME = $this->request->getPost("NAME");
        $oorderticketlog->OLD_STATUS = $this->request->getPost("OLD_STATUS");
        $oorderticketlog->NEW_STATUS = $this->request->getPost("NEW_STATUS");
        $oorderticketlog->DESCRIBE = $this->request->getPost("DESCRIBE");
        $oorderticketlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$oorderticketlog->save()) {
            foreach ($oorderticketlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "edit", "params" => array($oorderticketlog->ID)));
        } else {
            $this->flash->success("o order ticket log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $oorderticketlog = OOrderTicketLog::findFirst('ID="'.$ID.'"');
        if (!$oorderticketlog) {
            $this->flash->error("o order ticket log was not found");
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }

        if (!$oorderticketlog->delete()) {
            foreach ($oorderticketlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "search"));
        } else {
            $this->flash->success("o order ticket log was deleted");
            return $this->dispatcher->forward(array("controller" => "oorderticketlog", "action" => "index"));
        }
    }

}
