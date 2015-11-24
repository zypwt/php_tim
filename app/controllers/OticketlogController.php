<?php

use \Phalcon\Tag as Tag;

class OTicketLogController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OTicketLog", $_POST);
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

        $oticketlog = OTicketLog::find($parameters);
        if (count($oticketlog) == 0) {
            $this->flash->notice("The search did not find any o ticket log");
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oticketlog,
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

            $oticketlog = OTicketLog::findFirst('ID="'.$ID.'"');
            if (!$oticketlog) {
                $this->flash->error("o ticket log was not found");
                return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
            }
            $this->view->setVar("ID", $oticketlog->ID);
        
            Tag::displayTo("ID", $oticketlog->ID);
            Tag::displayTo("ORDER_ID", $oticketlog->ORDER_ID);
            Tag::displayTo("TICKET_ID", $oticketlog->TICKET_ID);
            Tag::displayTo("SCREENINGS", $oticketlog->SCREENINGS);
            Tag::displayTo("UUID", $oticketlog->UUID);
            Tag::displayTo("NAME", $oticketlog->NAME);
            Tag::displayTo("T_TICKETSOURCE", $oticketlog->T_TICKETSOURCE);
            Tag::displayTo("DESCRIBE", $oticketlog->DESCRIBE);
            Tag::displayTo("CREATE_TIME", $oticketlog->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

        $oticketlog = new OTicketLog();
        $oticketlog->ID = $this->request->getPost("ID");
        $oticketlog->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oticketlog->TICKET_ID = $this->request->getPost("TICKET_ID");
        $oticketlog->SCREENINGS = $this->request->getPost("SCREENINGS");
        $oticketlog->UUID = $this->request->getPost("UUID");
        $oticketlog->NAME = $this->request->getPost("NAME");
        $oticketlog->T_TICKETSOURCE = $this->request->getPost("T_TICKETSOURCE");
        $oticketlog->DESCRIBE = $this->request->getPost("DESCRIBE");
        $oticketlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$oticketlog->save()) {
            foreach ($oticketlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "new"));
        } else {
            $this->flash->success("o ticket log was created successfully");
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $oticketlog = OTicketLog::findFirst("ID='$ID'");
        if (!$oticketlog) {
            $this->flash->error("o ticket log does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }
        $oticketlog->ID = $this->request->getPost("ID");
        $oticketlog->ORDER_ID = $this->request->getPost("ORDER_ID");
        $oticketlog->TICKET_ID = $this->request->getPost("TICKET_ID");
        $oticketlog->SCREENINGS = $this->request->getPost("SCREENINGS");
        $oticketlog->UUID = $this->request->getPost("UUID");
        $oticketlog->NAME = $this->request->getPost("NAME");
        $oticketlog->T_TICKETSOURCE = $this->request->getPost("T_TICKETSOURCE");
        $oticketlog->DESCRIBE = $this->request->getPost("DESCRIBE");
        $oticketlog->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$oticketlog->save()) {
            foreach ($oticketlog->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "edit", "params" => array($oticketlog->ID)));
        } else {
            $this->flash->success("o ticket log was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $oticketlog = OTicketLog::findFirst('ID="'.$ID.'"');
        if (!$oticketlog) {
            $this->flash->error("o ticket log was not found");
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }

        if (!$oticketlog->delete()) {
            foreach ($oticketlog->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "search"));
        } else {
            $this->flash->success("o ticket log was deleted");
            return $this->dispatcher->forward(array("controller" => "oticketlog", "action" => "index"));
        }
    }

}
