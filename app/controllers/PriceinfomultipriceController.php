<?php

use \Phalcon\Tag as Tag;

class PriceInfoMultiPriceController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PriceInfoMultiPrice", $_POST);
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

        $priceinfomultiprice = PriceInfoMultiPrice::find($parameters);
        if (count($priceinfomultiprice) == 0) {
            $this->flash->notice("The search did not find any price info multi price");
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $priceinfomultiprice,
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

            $priceinfomultiprice = PriceInfoMultiPrice::findFirst('ID="'.$ID.'"');
            if (!$priceinfomultiprice) {
                $this->flash->error("price info multi price was not found");
                return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
            }
            $this->view->setVar("ID", $priceinfomultiprice->ID);
        
            Tag::displayTo("ID", $priceinfomultiprice->ID);
            Tag::displayTo("P_ID", $priceinfomultiprice->P_ID);
            Tag::displayTo("SENCE_ID", $priceinfomultiprice->SENCE_ID);
            Tag::displayTo("SHOW_ID", $priceinfomultiprice->SHOW_ID);
            Tag::displayTo("XSZC_ID", $priceinfomultiprice->XSZC_ID);
            Tag::displayTo("PJDJ", $priceinfomultiprice->PJDJ);
            Tag::displayTo("SHOW_DATE_CRM", $priceinfomultiprice->SHOW_DATE_CRM);
            Tag::displayTo("XSZC_MC", $priceinfomultiprice->XSZC_MC);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

        $priceinfomultiprice = new PriceInfoMultiPrice();
        $priceinfomultiprice->ID = $this->request->getPost("ID");
        $priceinfomultiprice->P_ID = $this->request->getPost("P_ID");
        $priceinfomultiprice->SENCE_ID = $this->request->getPost("SENCE_ID");
        $priceinfomultiprice->SHOW_ID = $this->request->getPost("SHOW_ID");
        $priceinfomultiprice->XSZC_ID = $this->request->getPost("XSZC_ID");
        $priceinfomultiprice->PJDJ = $this->request->getPost("PJDJ");
        $priceinfomultiprice->SHOW_DATE_CRM = $this->request->getPost("SHOW_DATE_CRM");
        $priceinfomultiprice->XSZC_MC = $this->request->getPost("XSZC_MC");
        if (!$priceinfomultiprice->save()) {
            foreach ($priceinfomultiprice->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "new"));
        } else {
            $this->flash->success("price info multi price was created successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $priceinfomultiprice = PriceInfoMultiPrice::findFirst("ID='$ID'");
        if (!$priceinfomultiprice) {
            $this->flash->error("price info multi price does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }
        $priceinfomultiprice->ID = $this->request->getPost("ID");
        $priceinfomultiprice->P_ID = $this->request->getPost("P_ID");
        $priceinfomultiprice->SENCE_ID = $this->request->getPost("SENCE_ID");
        $priceinfomultiprice->SHOW_ID = $this->request->getPost("SHOW_ID");
        $priceinfomultiprice->XSZC_ID = $this->request->getPost("XSZC_ID");
        $priceinfomultiprice->PJDJ = $this->request->getPost("PJDJ");
        $priceinfomultiprice->SHOW_DATE_CRM = $this->request->getPost("SHOW_DATE_CRM");
        $priceinfomultiprice->XSZC_MC = $this->request->getPost("XSZC_MC");
        if (!$priceinfomultiprice->save()) {
            foreach ($priceinfomultiprice->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "edit", "params" => array($priceinfomultiprice->ID)));
        } else {
            $this->flash->success("price info multi price was updated successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $priceinfomultiprice = PriceInfoMultiPrice::findFirst('ID="'.$ID.'"');
        if (!$priceinfomultiprice) {
            $this->flash->error("price info multi price was not found");
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }

        if (!$priceinfomultiprice->delete()) {
            foreach ($priceinfomultiprice->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "search"));
        } else {
            $this->flash->success("price info multi price was deleted");
            return $this->dispatcher->forward(array("controller" => "priceinfomultiprice", "action" => "index"));
        }
    }

}
