<?php

use \Phalcon\Tag as Tag;

class CashOnDeliveryConfigController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CashOnDeliveryConfig", $_POST);
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

        $cashondeliveryconfig = CashOnDeliveryConfig::find($parameters);
        if (count($cashondeliveryconfig) == 0) {
            $this->flash->notice("The search did not find any cash on delivery config");
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cashondeliveryconfig,
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

            $cashondeliveryconfig = CashOnDeliveryConfig::findFirst('ID="'.$ID.'"');
            if (!$cashondeliveryconfig) {
                $this->flash->error("cash on delivery config was not found");
                return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
            }
            $this->view->setVar("ID", $cashondeliveryconfig->ID);
        
            Tag::displayTo("ID", $cashondeliveryconfig->ID);
            Tag::displayTo("SEND_CITY_ID", $cashondeliveryconfig->SEND_CITY_ID);
            Tag::displayTo("RECEIVE_PROVINCE_ID", $cashondeliveryconfig->RECEIVE_PROVINCE_ID);
            Tag::displayTo("RECEIVE_CITY_ID", $cashondeliveryconfig->RECEIVE_CITY_ID);
            Tag::displayTo("RECEIVE_LOCAL_ID", $cashondeliveryconfig->RECEIVE_LOCAL_ID);
            Tag::displayTo("DELIVERY_TYPE", $cashondeliveryconfig->DELIVERY_TYPE);
            Tag::displayTo("PRICE", $cashondeliveryconfig->PRICE);
            Tag::displayTo("CREATE_TIME", $cashondeliveryconfig->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $cashondeliveryconfig->UPDATE_TIME);
            Tag::displayTo("AGENCY_ID", $cashondeliveryconfig->AGENCY_ID);
            Tag::displayTo("IS_VISIBLE", $cashondeliveryconfig->IS_VISIBLE);
            Tag::displayTo("RECEIVE_ZONE_ID", $cashondeliveryconfig->RECEIVE_ZONE_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

        $cashondeliveryconfig = new CashOnDeliveryConfig();
        $cashondeliveryconfig->ID = $this->request->getPost("ID");
        $cashondeliveryconfig->SEND_CITY_ID = $this->request->getPost("SEND_CITY_ID");
        $cashondeliveryconfig->RECEIVE_PROVINCE_ID = $this->request->getPost("RECEIVE_PROVINCE_ID");
        $cashondeliveryconfig->RECEIVE_CITY_ID = $this->request->getPost("RECEIVE_CITY_ID");
        $cashondeliveryconfig->RECEIVE_LOCAL_ID = $this->request->getPost("RECEIVE_LOCAL_ID");
        $cashondeliveryconfig->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $cashondeliveryconfig->PRICE = $this->request->getPost("PRICE");
        $cashondeliveryconfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cashondeliveryconfig->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cashondeliveryconfig->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $cashondeliveryconfig->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $cashondeliveryconfig->RECEIVE_ZONE_ID = $this->request->getPost("RECEIVE_ZONE_ID");
        if (!$cashondeliveryconfig->save()) {
            foreach ($cashondeliveryconfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "new"));
        } else {
            $this->flash->success("cash on delivery config was created successfully");
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cashondeliveryconfig = CashOnDeliveryConfig::findFirst("ID='$ID'");
        if (!$cashondeliveryconfig) {
            $this->flash->error("cash on delivery config does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }
        $cashondeliveryconfig->ID = $this->request->getPost("ID");
        $cashondeliveryconfig->SEND_CITY_ID = $this->request->getPost("SEND_CITY_ID");
        $cashondeliveryconfig->RECEIVE_PROVINCE_ID = $this->request->getPost("RECEIVE_PROVINCE_ID");
        $cashondeliveryconfig->RECEIVE_CITY_ID = $this->request->getPost("RECEIVE_CITY_ID");
        $cashondeliveryconfig->RECEIVE_LOCAL_ID = $this->request->getPost("RECEIVE_LOCAL_ID");
        $cashondeliveryconfig->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $cashondeliveryconfig->PRICE = $this->request->getPost("PRICE");
        $cashondeliveryconfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cashondeliveryconfig->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $cashondeliveryconfig->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $cashondeliveryconfig->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $cashondeliveryconfig->RECEIVE_ZONE_ID = $this->request->getPost("RECEIVE_ZONE_ID");
        if (!$cashondeliveryconfig->save()) {
            foreach ($cashondeliveryconfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "edit", "params" => array($cashondeliveryconfig->ID)));
        } else {
            $this->flash->success("cash on delivery config was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cashondeliveryconfig = CashOnDeliveryConfig::findFirst('ID="'.$ID.'"');
        if (!$cashondeliveryconfig) {
            $this->flash->error("cash on delivery config was not found");
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }

        if (!$cashondeliveryconfig->delete()) {
            foreach ($cashondeliveryconfig->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "search"));
        } else {
            $this->flash->success("cash on delivery config was deleted");
            return $this->dispatcher->forward(array("controller" => "cashondeliveryconfig", "action" => "index"));
        }
    }

}
