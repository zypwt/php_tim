<?php

use \Phalcon\Tag as Tag;

class CashOnDeliveryController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CashOnDelivery", $_POST);
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

        $cashondelivery = CashOnDelivery::find($parameters);
        if (count($cashondelivery) == 0) {
            $this->flash->notice("The search did not find any cash on delivery");
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cashondelivery,
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

            $cashondelivery = CashOnDelivery::findFirst('ID="'.$ID.'"');
            if (!$cashondelivery) {
                $this->flash->error("cash on delivery was not found");
                return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
            }
            $this->view->setVar("ID", $cashondelivery->ID);
        
            Tag::displayTo("ID", $cashondelivery->ID);
            Tag::displayTo("AGENCY_ID", $cashondelivery->AGENCY_ID);
            Tag::displayTo("SEND_CITY_ID", $cashondelivery->SEND_CITY_ID);
            Tag::displayTo("DELIVERY_TYPE", $cashondelivery->DELIVERY_TYPE);
            Tag::displayTo("DELIVERY_SCOPE", $cashondelivery->DELIVERY_SCOPE);
            Tag::displayTo("ADD_CONDITION", $cashondelivery->ADD_CONDITION);
            Tag::displayTo("REMARK", $cashondelivery->REMARK);
            Tag::displayTo("IS_VISIBEL", $cashondelivery->IS_VISIBEL);
            Tag::displayTo("CREATE_TIME", $cashondelivery->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $cashondelivery->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

        $cashondelivery = new CashOnDelivery();
        $cashondelivery->ID = $this->request->getPost("ID");
        $cashondelivery->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $cashondelivery->SEND_CITY_ID = $this->request->getPost("SEND_CITY_ID");
        $cashondelivery->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $cashondelivery->DELIVERY_SCOPE = $this->request->getPost("DELIVERY_SCOPE");
        $cashondelivery->ADD_CONDITION = $this->request->getPost("ADD_CONDITION");
        $cashondelivery->REMARK = $this->request->getPost("REMARK");
        $cashondelivery->IS_VISIBEL = $this->request->getPost("IS_VISIBEL");
        $cashondelivery->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cashondelivery->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$cashondelivery->save()) {
            foreach ($cashondelivery->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "new"));
        } else {
            $this->flash->success("cash on delivery was created successfully");
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cashondelivery = CashOnDelivery::findFirst("ID='$ID'");
        if (!$cashondelivery) {
            $this->flash->error("cash on delivery does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }
        $cashondelivery->ID = $this->request->getPost("ID");
        $cashondelivery->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $cashondelivery->SEND_CITY_ID = $this->request->getPost("SEND_CITY_ID");
        $cashondelivery->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $cashondelivery->DELIVERY_SCOPE = $this->request->getPost("DELIVERY_SCOPE");
        $cashondelivery->ADD_CONDITION = $this->request->getPost("ADD_CONDITION");
        $cashondelivery->REMARK = $this->request->getPost("REMARK");
        $cashondelivery->IS_VISIBEL = $this->request->getPost("IS_VISIBEL");
        $cashondelivery->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cashondelivery->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$cashondelivery->save()) {
            foreach ($cashondelivery->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "edit", "params" => array($cashondelivery->ID)));
        } else {
            $this->flash->success("cash on delivery was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cashondelivery = CashOnDelivery::findFirst('ID="'.$ID.'"');
        if (!$cashondelivery) {
            $this->flash->error("cash on delivery was not found");
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }

        if (!$cashondelivery->delete()) {
            foreach ($cashondelivery->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "search"));
        } else {
            $this->flash->success("cash on delivery was deleted");
            return $this->dispatcher->forward(array("controller" => "cashondelivery", "action" => "index"));
        }
    }

}
