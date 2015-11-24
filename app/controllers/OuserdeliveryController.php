<?php

use \Phalcon\Tag as Tag;

class OUserDeliveryController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OUserDelivery", $_POST);
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

        $ouserdelivery = OUserDelivery::find($parameters);
        if (count($ouserdelivery) == 0) {
            $this->flash->notice("The search did not find any o user delivery");
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $ouserdelivery,
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

            $ouserdelivery = OUserDelivery::findFirst('ID="'.$ID.'"');
            if (!$ouserdelivery) {
                $this->flash->error("o user delivery was not found");
                return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
            }
            $this->view->setVar("ID", $ouserdelivery->ID);
        
            Tag::displayTo("ID", $ouserdelivery->ID);
            Tag::displayTo("ORDER_ID", $ouserdelivery->ORDER_ID);
            Tag::displayTo("UUID", $ouserdelivery->UUID);
            Tag::displayTo("INVOICE", $ouserdelivery->INVOICE);
            Tag::displayTo("INVOICE_TITLE", $ouserdelivery->INVOICE_TITLE);
            Tag::displayTo("INVOICE_CONTENT", $ouserdelivery->INVOICE_CONTENT);
            Tag::displayTo("REACH_CITY_ID", $ouserdelivery->REACH_CITY_ID);
            Tag::displayTo("DELIVER_CITY_ID", $ouserdelivery->DELIVER_CITY_ID);
            Tag::displayTo("DELIVER_TYPE", $ouserdelivery->DELIVER_TYPE);
            Tag::displayTo("DELIVER_TIME", $ouserdelivery->DELIVER_TIME);
            Tag::displayTo("REACH_USERNAME", $ouserdelivery->REACH_USERNAME);
            Tag::displayTo("REACH_USER_EMAIL", $ouserdelivery->REACH_USER_EMAIL);
            Tag::displayTo("REACH_USER_ADDRESS", $ouserdelivery->REACH_USER_ADDRESS);
            Tag::displayTo("REACH_USER_PHONE", $ouserdelivery->REACH_USER_PHONE);
            Tag::displayTo("REACH_USER_PROVINCE", $ouserdelivery->REACH_USER_PROVINCE);
            Tag::displayTo("REACH_USER_CITY", $ouserdelivery->REACH_USER_CITY);
            Tag::displayTo("REACH_USER_LOCALITY", $ouserdelivery->REACH_USER_LOCALITY);
            Tag::displayTo("REACH_USER_ZONE", $ouserdelivery->REACH_USER_ZONE);
            Tag::displayTo("REACH_USER_ZIPCODE", $ouserdelivery->REACH_USER_ZIPCODE);
            Tag::displayTo("DELIVER_PERSON_ID", $ouserdelivery->DELIVER_PERSON_ID);
            Tag::displayTo("DELIVER_PERSON_NAME", $ouserdelivery->DELIVER_PERSON_NAME);
            Tag::displayTo("DELIVER_STATUS", $ouserdelivery->DELIVER_STATUS);
            Tag::displayTo("REMARKS", $ouserdelivery->REMARKS);
            Tag::displayTo("CREATE_TIME", $ouserdelivery->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

        $ouserdelivery = new OUserDelivery();
        $ouserdelivery->ID = $this->request->getPost("ID");
        $ouserdelivery->ORDER_ID = $this->request->getPost("ORDER_ID");
        $ouserdelivery->UUID = $this->request->getPost("UUID");
        $ouserdelivery->INVOICE = $this->request->getPost("INVOICE");
        $ouserdelivery->INVOICE_TITLE = $this->request->getPost("INVOICE_TITLE");
        $ouserdelivery->INVOICE_CONTENT = $this->request->getPost("INVOICE_CONTENT");
        $ouserdelivery->REACH_CITY_ID = $this->request->getPost("REACH_CITY_ID");
        $ouserdelivery->DELIVER_CITY_ID = $this->request->getPost("DELIVER_CITY_ID");
        $ouserdelivery->DELIVER_TYPE = $this->request->getPost("DELIVER_TYPE");
        $ouserdelivery->DELIVER_TIME = $this->request->getPost("DELIVER_TIME");
        $ouserdelivery->REACH_USERNAME = $this->request->getPost("REACH_USERNAME");
        $ouserdelivery->REACH_USER_EMAIL = $this->request->getPost("REACH_USER_EMAIL");
        $ouserdelivery->REACH_USER_ADDRESS = $this->request->getPost("REACH_USER_ADDRESS");
        $ouserdelivery->REACH_USER_PHONE = $this->request->getPost("REACH_USER_PHONE");
        $ouserdelivery->REACH_USER_PROVINCE = $this->request->getPost("REACH_USER_PROVINCE");
        $ouserdelivery->REACH_USER_CITY = $this->request->getPost("REACH_USER_CITY");
        $ouserdelivery->REACH_USER_LOCALITY = $this->request->getPost("REACH_USER_LOCALITY");
        $ouserdelivery->REACH_USER_ZONE = $this->request->getPost("REACH_USER_ZONE");
        $ouserdelivery->REACH_USER_ZIPCODE = $this->request->getPost("REACH_USER_ZIPCODE");
        $ouserdelivery->DELIVER_PERSON_ID = $this->request->getPost("DELIVER_PERSON_ID");
        $ouserdelivery->DELIVER_PERSON_NAME = $this->request->getPost("DELIVER_PERSON_NAME");
        $ouserdelivery->DELIVER_STATUS = $this->request->getPost("DELIVER_STATUS");
        $ouserdelivery->REMARKS = $this->request->getPost("REMARKS");
        $ouserdelivery->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$ouserdelivery->save()) {
            foreach ($ouserdelivery->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "new"));
        } else {
            $this->flash->success("o user delivery was created successfully");
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $ouserdelivery = OUserDelivery::findFirst("ID='$ID'");
        if (!$ouserdelivery) {
            $this->flash->error("o user delivery does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }
        $ouserdelivery->ID = $this->request->getPost("ID");
        $ouserdelivery->ORDER_ID = $this->request->getPost("ORDER_ID");
        $ouserdelivery->UUID = $this->request->getPost("UUID");
        $ouserdelivery->INVOICE = $this->request->getPost("INVOICE");
        $ouserdelivery->INVOICE_TITLE = $this->request->getPost("INVOICE_TITLE");
        $ouserdelivery->INVOICE_CONTENT = $this->request->getPost("INVOICE_CONTENT");
        $ouserdelivery->REACH_CITY_ID = $this->request->getPost("REACH_CITY_ID");
        $ouserdelivery->DELIVER_CITY_ID = $this->request->getPost("DELIVER_CITY_ID");
        $ouserdelivery->DELIVER_TYPE = $this->request->getPost("DELIVER_TYPE");
        $ouserdelivery->DELIVER_TIME = $this->request->getPost("DELIVER_TIME");
        $ouserdelivery->REACH_USERNAME = $this->request->getPost("REACH_USERNAME");
        $ouserdelivery->REACH_USER_EMAIL = $this->request->getPost("REACH_USER_EMAIL");
        $ouserdelivery->REACH_USER_ADDRESS = $this->request->getPost("REACH_USER_ADDRESS");
        $ouserdelivery->REACH_USER_PHONE = $this->request->getPost("REACH_USER_PHONE");
        $ouserdelivery->REACH_USER_PROVINCE = $this->request->getPost("REACH_USER_PROVINCE");
        $ouserdelivery->REACH_USER_CITY = $this->request->getPost("REACH_USER_CITY");
        $ouserdelivery->REACH_USER_LOCALITY = $this->request->getPost("REACH_USER_LOCALITY");
        $ouserdelivery->REACH_USER_ZONE = $this->request->getPost("REACH_USER_ZONE");
        $ouserdelivery->REACH_USER_ZIPCODE = $this->request->getPost("REACH_USER_ZIPCODE");
        $ouserdelivery->DELIVER_PERSON_ID = $this->request->getPost("DELIVER_PERSON_ID");
        $ouserdelivery->DELIVER_PERSON_NAME = $this->request->getPost("DELIVER_PERSON_NAME");
        $ouserdelivery->DELIVER_STATUS = $this->request->getPost("DELIVER_STATUS");
        $ouserdelivery->REMARKS = $this->request->getPost("REMARKS");
        $ouserdelivery->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$ouserdelivery->save()) {
            foreach ($ouserdelivery->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "edit", "params" => array($ouserdelivery->ID)));
        } else {
            $this->flash->success("o user delivery was updated successfully");
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $ouserdelivery = OUserDelivery::findFirst('ID="'.$ID.'"');
        if (!$ouserdelivery) {
            $this->flash->error("o user delivery was not found");
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }

        if (!$ouserdelivery->delete()) {
            foreach ($ouserdelivery->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "search"));
        } else {
            $this->flash->success("o user delivery was deleted");
            return $this->dispatcher->forward(array("controller" => "ouserdelivery", "action" => "index"));
        }
    }

}
