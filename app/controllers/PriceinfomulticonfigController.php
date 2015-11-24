<?php

use \Phalcon\Tag as Tag;

class PriceInfoMultiConfigController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PriceInfoMultiConfig", $_POST);
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

        $priceinfomulticonfig = PriceInfoMultiConfig::find($parameters);
        if (count($priceinfomulticonfig) == 0) {
            $this->flash->notice("The search did not find any price info multi config");
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $priceinfomulticonfig,
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

            $priceinfomulticonfig = PriceInfoMultiConfig::findFirst('ID="'.$ID.'"');
            if (!$priceinfomulticonfig) {
                $this->flash->error("price info multi config was not found");
                return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
            }
            $this->view->setVar("ID", $priceinfomulticonfig->ID);
        
            Tag::displayTo("ID", $priceinfomulticonfig->ID);
            Tag::displayTo("ITEM_ID", $priceinfomulticonfig->ITEM_ID);
            Tag::displayTo("COST_PRICE", $priceinfomulticonfig->COST_PRICE);
            Tag::displayTo("PRICE", $priceinfomulticonfig->PRICE);
            Tag::displayTo("PRICE_TYPE", $priceinfomulticonfig->PRICE_TYPE);
            Tag::displayTo("SELL_NUMBER", $priceinfomulticonfig->SELL_NUMBER);
            Tag::displayTo("LIMIT_MIN_NUM", $priceinfomulticonfig->LIMIT_MIN_NUM);
            Tag::displayTo("LIMIT_MAX_NUM", $priceinfomulticonfig->LIMIT_MAX_NUM);
            Tag::displayTo("IS_VISIBLE", $priceinfomulticonfig->IS_VISIBLE);
            Tag::displayTo("CREATE_TIME", $priceinfomulticonfig->CREATE_TIME);
            Tag::displayTo("SEAT_TYPE", $priceinfomulticonfig->SEAT_TYPE);
            Tag::displayTo("NAME", $priceinfomulticonfig->NAME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

        $priceinfomulticonfig = new PriceInfoMultiConfig();
        $priceinfomulticonfig->ID = $this->request->getPost("ID");
        $priceinfomulticonfig->ITEM_ID = $this->request->getPost("ITEM_ID");
        $priceinfomulticonfig->COST_PRICE = $this->request->getPost("COST_PRICE");
        $priceinfomulticonfig->PRICE = $this->request->getPost("PRICE");
        $priceinfomulticonfig->PRICE_TYPE = $this->request->getPost("PRICE_TYPE");
        $priceinfomulticonfig->SELL_NUMBER = $this->request->getPost("SELL_NUMBER");
        $priceinfomulticonfig->LIMIT_MIN_NUM = $this->request->getPost("LIMIT_MIN_NUM");
        $priceinfomulticonfig->LIMIT_MAX_NUM = $this->request->getPost("LIMIT_MAX_NUM");
        $priceinfomulticonfig->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $priceinfomulticonfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $priceinfomulticonfig->SEAT_TYPE = $this->request->getPost("SEAT_TYPE");
        $priceinfomulticonfig->NAME = $this->request->getPost("NAME");
        if (!$priceinfomulticonfig->save()) {
            foreach ($priceinfomulticonfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "new"));
        } else {
            $this->flash->success("price info multi config was created successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $priceinfomulticonfig = PriceInfoMultiConfig::findFirst("ID='$ID'");
        if (!$priceinfomulticonfig) {
            $this->flash->error("price info multi config does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }
        $priceinfomulticonfig->ID = $this->request->getPost("ID");
        $priceinfomulticonfig->ITEM_ID = $this->request->getPost("ITEM_ID");
        $priceinfomulticonfig->COST_PRICE = $this->request->getPost("COST_PRICE");
        $priceinfomulticonfig->PRICE = $this->request->getPost("PRICE");
        $priceinfomulticonfig->PRICE_TYPE = $this->request->getPost("PRICE_TYPE");
        $priceinfomulticonfig->SELL_NUMBER = $this->request->getPost("SELL_NUMBER");
        $priceinfomulticonfig->LIMIT_MIN_NUM = $this->request->getPost("LIMIT_MIN_NUM");
        $priceinfomulticonfig->LIMIT_MAX_NUM = $this->request->getPost("LIMIT_MAX_NUM");
        $priceinfomulticonfig->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $priceinfomulticonfig->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $priceinfomulticonfig->SEAT_TYPE = $this->request->getPost("SEAT_TYPE");
        $priceinfomulticonfig->NAME = $this->request->getPost("NAME");
        if (!$priceinfomulticonfig->save()) {
            foreach ($priceinfomulticonfig->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "edit", "params" => array($priceinfomulticonfig->ID)));
        } else {
            $this->flash->success("price info multi config was updated successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $priceinfomulticonfig = PriceInfoMultiConfig::findFirst('ID="'.$ID.'"');
        if (!$priceinfomulticonfig) {
            $this->flash->error("price info multi config was not found");
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }

        if (!$priceinfomulticonfig->delete()) {
            foreach ($priceinfomulticonfig->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "search"));
        } else {
            $this->flash->success("price info multi config was deleted");
            return $this->dispatcher->forward(array("controller" => "priceinfomulticonfig", "action" => "index"));
        }
    }

}
