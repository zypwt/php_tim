<?php

use \Phalcon\Tag as Tag;

class PPaymentTypeController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PPaymentType", $_POST);
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

        $ppaymenttype = PPaymentType::find($parameters);
        if (count($ppaymenttype) == 0) {
            $this->flash->notice("The search did not find any p payment type");
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ppaymenttype,
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

            $ppaymenttype = PPaymentType::findFirst('ID="'.$ID.'"');
            if (!$ppaymenttype) {
                $this->flash->error("p payment type was not found");
                return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
            }
            $this->view->setVar("ID", $ppaymenttype->ID);
        
            Tag::displayTo("ID", $ppaymenttype->ID);
            Tag::displayTo("PARTNER_TYPE", $ppaymenttype->PARTNER_TYPE);
            Tag::displayTo("TYPE_NAME", $ppaymenttype->TYPE_NAME);
            Tag::displayTo("TYPE_PARAMS", $ppaymenttype->TYPE_PARAMS);
            Tag::displayTo("USE_STATUS", $ppaymenttype->USE_STATUS);
            Tag::displayTo("CREATE_TIME", $ppaymenttype->CREATE_TIME);
            Tag::displayTo("AGENCY_ID", $ppaymenttype->AGENCY_ID);
            Tag::displayTo("COMISSION_RATE", $ppaymenttype->COMISSION_RATE);
            Tag::displayTo("DEFAULT_PARTNER_TYPE", $ppaymenttype->DEFAULT_PARTNER_TYPE);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

        $ppaymenttype = new PPaymentType();
        $ppaymenttype->ID = $this->request->getPost("ID");
        $ppaymenttype->PARTNER_TYPE = $this->request->getPost("PARTNER_TYPE");
        $ppaymenttype->TYPE_NAME = $this->request->getPost("TYPE_NAME");
        $ppaymenttype->TYPE_PARAMS = $this->request->getPost("TYPE_PARAMS");
        $ppaymenttype->USE_STATUS = $this->request->getPost("USE_STATUS");
        $ppaymenttype->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymenttype->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $ppaymenttype->COMISSION_RATE = $this->request->getPost("COMISSION_RATE");
        $ppaymenttype->DEFAULT_PARTNER_TYPE = $this->request->getPost("DEFAULT_PARTNER_TYPE");
        if (!$ppaymenttype->save()) {
            foreach ($ppaymenttype->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "new"));
        } else {
            $this->flash->success("p payment type was created successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $ppaymenttype = PPaymentType::findFirst("ID='$ID'");
        if (!$ppaymenttype) {
            $this->flash->error("p payment type does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }
        $ppaymenttype->ID = $this->request->getPost("ID");
        $ppaymenttype->PARTNER_TYPE = $this->request->getPost("PARTNER_TYPE");
        $ppaymenttype->TYPE_NAME = $this->request->getPost("TYPE_NAME");
        $ppaymenttype->TYPE_PARAMS = $this->request->getPost("TYPE_PARAMS");
        $ppaymenttype->USE_STATUS = $this->request->getPost("USE_STATUS");
        $ppaymenttype->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $ppaymenttype->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $ppaymenttype->COMISSION_RATE = $this->request->getPost("COMISSION_RATE");
        $ppaymenttype->DEFAULT_PARTNER_TYPE = $this->request->getPost("DEFAULT_PARTNER_TYPE");
        if (!$ppaymenttype->save()) {
            foreach ($ppaymenttype->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "edit", "params" => array($ppaymenttype->ID)));
        } else {
            $this->flash->success("p payment type was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $ppaymenttype = PPaymentType::findFirst('ID="'.$ID.'"');
        if (!$ppaymenttype) {
            $this->flash->error("p payment type was not found");
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }

        if (!$ppaymenttype->delete()) {
            foreach ($ppaymenttype->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "search"));
        } else {
            $this->flash->success("p payment type was deleted");
            return $this->dispatcher->forward(array("controller" => "ppaymenttype", "action" => "index"));
        }
    }

}
