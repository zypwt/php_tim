<?php

use \Phalcon\Tag as Tag;

class ItemPaymentConfigController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ItemPaymentConfig", $_POST);
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

        $itempaymentconfig = ItemPaymentConfig::find($parameters);
        if (count($itempaymentconfig) == 0) {
            $this->flash->notice("The search did not find any item payment config");
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $itempaymentconfig,
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

            $itempaymentconfig = ItemPaymentConfig::findFirst('ID="'.$ID.'"');
            if (!$itempaymentconfig) {
                $this->flash->error("item payment config was not found");
                return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
            }
            $this->view->setVar("ID", $itempaymentconfig->ID);
        
            Tag::displayTo("ID", $itempaymentconfig->ID);
            Tag::displayTo("ONLINE_ID", $itempaymentconfig->ONLINE_ID);
            Tag::displayTo("CREATE_TIME", $itempaymentconfig->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $itempaymentconfig->UPDATE_TIME);
            Tag::displayTo("PAYMENT_CONFIG", $itempaymentconfig->PAYMENT_CONFIG);
            Tag::displayTo("IS_AGENCY_DEFAULT", $itempaymentconfig->IS_AGENCY_DEFAULT);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

        $itempaymentconfig = new ItemPaymentConfig();
        $itempaymentconfig->ID = $this->request->getPost("ID");
        $itempaymentconfig->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $itempaymentconfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itempaymentconfig->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itempaymentconfig->PAYMENT_CONFIG = $this->request->getPost("PAYMENT_CONFIG");
        $itempaymentconfig->IS_AGENCY_DEFAULT = $this->request->getPost("IS_AGENCY_DEFAULT");
        if (!$itempaymentconfig->save()) {
            foreach ($itempaymentconfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "new"));
        } else {
            $this->flash->success("item payment config was created successfully");
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $itempaymentconfig = ItemPaymentConfig::findFirst("ID='$ID'");
        if (!$itempaymentconfig) {
            $this->flash->error("item payment config does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }
        $itempaymentconfig->ID = $this->request->getPost("ID");
        $itempaymentconfig->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $itempaymentconfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $itempaymentconfig->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $itempaymentconfig->PAYMENT_CONFIG = $this->request->getPost("PAYMENT_CONFIG");
        $itempaymentconfig->IS_AGENCY_DEFAULT = $this->request->getPost("IS_AGENCY_DEFAULT");
        if (!$itempaymentconfig->save()) {
            foreach ($itempaymentconfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "edit", "params" => array($itempaymentconfig->ID)));
        } else {
            $this->flash->success("item payment config was updated successfully");
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $itempaymentconfig = ItemPaymentConfig::findFirst('ID="'.$ID.'"');
        if (!$itempaymentconfig) {
            $this->flash->error("item payment config was not found");
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }

        if (!$itempaymentconfig->delete()) {
            foreach ($itempaymentconfig->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "search"));
        } else {
            $this->flash->success("item payment config was deleted");
            return $this->dispatcher->forward(array("controller" => "itempaymentconfig", "action" => "index"));
        }
    }

}
