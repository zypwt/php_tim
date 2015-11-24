<?php

use \Phalcon\Tag as Tag;

class OPackageController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OPackage", $_POST);
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

        $opackage = OPackage::find($parameters);
        if (count($opackage) == 0) {
            $this->flash->notice("The search did not find any o package");
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $opackage,
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

            $opackage = OPackage::findFirst('ID="'.$ID.'"');
            if (!$opackage) {
                $this->flash->error("o package was not found");
                return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
            }
            $this->view->setVar("ID", $opackage->ID);
        
            Tag::displayTo("ID", $opackage->ID);
            Tag::displayTo("UUID", $opackage->UUID);
            Tag::displayTo("INVOICE", $opackage->INVOICE);
            Tag::displayTo("INVOICE_TITLE", $opackage->INVOICE_TITLE);
            Tag::displayTo("INVOICE_CONTENT", $opackage->INVOICE_CONTENT);
            Tag::displayTo("DELIVERY_CITY_ID", $opackage->DELIVERY_CITY_ID);
            Tag::displayTo("DELIVERY_TYPE", $opackage->DELIVERY_TYPE);
            Tag::displayTo("DELIVERY_TIME", $opackage->DELIVERY_TIME);
            Tag::displayTo("REACH_USERNAME", $opackage->REACH_USERNAME);
            Tag::displayTo("REACH_USER_EMAIL", $opackage->REACH_USER_EMAIL);
            Tag::displayTo("REACH_USER_ADDRESS", $opackage->REACH_USER_ADDRESS);
            Tag::displayTo("REACH_USER_PHONE", $opackage->REACH_USER_PHONE);
            Tag::displayTo("REACH_USER_PROVINCE", $opackage->REACH_USER_PROVINCE);
            Tag::displayTo("REACH_USER_CITY", $opackage->REACH_USER_CITY);
            Tag::displayTo("REACH_USER_LOCALITY", $opackage->REACH_USER_LOCALITY);
            Tag::displayTo("REACH_USER_ZONE", $opackage->REACH_USER_ZONE);
            Tag::displayTo("REACH_USER_ZIPCODE", $opackage->REACH_USER_ZIPCODE);
            Tag::displayTo("DELIVERY_PERSON_ID", $opackage->DELIVERY_PERSON_ID);
            Tag::displayTo("DELIVERY_PERSON_NAME", $opackage->DELIVERY_PERSON_NAME);
            Tag::displayTo("DELIVERY_STATUS", $opackage->DELIVERY_STATUS);
            Tag::displayTo("DELIVERY_NO", $opackage->DELIVERY_NO);
            Tag::displayTo("REMARKS", $opackage->REMARKS);
            Tag::displayTo("MONEY", $opackage->MONEY);
            Tag::displayTo("COURIER", $opackage->COURIER);
            Tag::displayTo("SHOULD_PAY", $opackage->SHOULD_PAY);
            Tag::displayTo("CREATE_TIME", $opackage->CREATE_TIME);
            Tag::displayTo("PACKAGE_ID", $opackage->PACKAGE_ID);
            Tag::displayTo("PAYMENT_STATUS", $opackage->PAYMENT_STATUS);
            Tag::displayTo("AGENCYID", $opackage->AGENCYID);
            Tag::displayTo("AGENCY_ID", $opackage->AGENCY_ID);
            Tag::displayTo("DELIVERY_COMPANY", $opackage->DELIVERY_COMPANY);
            Tag::displayTo("ORDER_TOTAL_MONEY", $opackage->ORDER_TOTAL_MONEY);
            Tag::displayTo("ORDER_DISCOUNT_TOTAL_MONEY", $opackage->ORDER_DISCOUNT_TOTAL_MONEY);
            Tag::displayTo("VIRTUAL_MONEY", $opackage->VIRTUAL_MONEY);
            Tag::displayTo("VIRTUAL_MONEY_TYPE", $opackage->VIRTUAL_MONEY_TYPE);
            Tag::displayTo("COD", $opackage->COD);
            Tag::displayTo("PAYMENT_CLASS", $opackage->PAYMENT_CLASS);
            Tag::displayTo("REAL_PAY", $opackage->REAL_PAY);
            Tag::displayTo("USERNAME", $opackage->USERNAME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

        $opackage = new OPackage();
        $opackage->ID = $this->request->getPost("ID");
        $opackage->UUID = $this->request->getPost("UUID");
        $opackage->INVOICE = $this->request->getPost("INVOICE");
        $opackage->INVOICE_TITLE = $this->request->getPost("INVOICE_TITLE");
        $opackage->INVOICE_CONTENT = $this->request->getPost("INVOICE_CONTENT");
        $opackage->DELIVERY_CITY_ID = $this->request->getPost("DELIVERY_CITY_ID");
        $opackage->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $opackage->DELIVERY_TIME = $this->request->getPost("DELIVERY_TIME");
        $opackage->REACH_USERNAME = $this->request->getPost("REACH_USERNAME");
        $opackage->REACH_USER_EMAIL = $this->request->getPost("REACH_USER_EMAIL");
        $opackage->REACH_USER_ADDRESS = $this->request->getPost("REACH_USER_ADDRESS");
        $opackage->REACH_USER_PHONE = $this->request->getPost("REACH_USER_PHONE");
        $opackage->REACH_USER_PROVINCE = $this->request->getPost("REACH_USER_PROVINCE");
        $opackage->REACH_USER_CITY = $this->request->getPost("REACH_USER_CITY");
        $opackage->REACH_USER_LOCALITY = $this->request->getPost("REACH_USER_LOCALITY");
        $opackage->REACH_USER_ZONE = $this->request->getPost("REACH_USER_ZONE");
        $opackage->REACH_USER_ZIPCODE = $this->request->getPost("REACH_USER_ZIPCODE");
        $opackage->DELIVERY_PERSON_ID = $this->request->getPost("DELIVERY_PERSON_ID");
        $opackage->DELIVERY_PERSON_NAME = $this->request->getPost("DELIVERY_PERSON_NAME");
        $opackage->DELIVERY_STATUS = $this->request->getPost("DELIVERY_STATUS");
        $opackage->DELIVERY_NO = $this->request->getPost("DELIVERY_NO");
        $opackage->REMARKS = $this->request->getPost("REMARKS");
        $opackage->MONEY = $this->request->getPost("MONEY");
        $opackage->COURIER = $this->request->getPost("COURIER");
        $opackage->SHOULD_PAY = $this->request->getPost("SHOULD_PAY");
        $opackage->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $opackage->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $opackage->PAYMENT_STATUS = $this->request->getPost("PAYMENT_STATUS");
        $opackage->AGENCYID = $this->request->getPost("AGENCYID");
        $opackage->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $opackage->DELIVERY_COMPANY = $this->request->getPost("DELIVERY_COMPANY");
        $opackage->ORDER_TOTAL_MONEY = $this->request->getPost("ORDER_TOTAL_MONEY");
        $opackage->ORDER_DISCOUNT_TOTAL_MONEY = $this->request->getPost("ORDER_DISCOUNT_TOTAL_MONEY");
        $opackage->VIRTUAL_MONEY = $this->request->getPost("VIRTUAL_MONEY");
        $opackage->VIRTUAL_MONEY_TYPE = $this->request->getPost("VIRTUAL_MONEY_TYPE");
        $opackage->COD = $this->request->getPost("COD");
        $opackage->PAYMENT_CLASS = $this->request->getPost("PAYMENT_CLASS");
        $opackage->REAL_PAY = $this->request->getPost("REAL_PAY");
        $opackage->USERNAME = $this->request->getPost("USERNAME");
        if (!$opackage->save()) {
            foreach ($opackage->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "new"));
        } else {
            $this->flash->success("o package was created successfully");
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $opackage = OPackage::findFirst("ID='$ID'");
        if (!$opackage) {
            $this->flash->error("o package does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }
        $opackage->ID = $this->request->getPost("ID");
        $opackage->UUID = $this->request->getPost("UUID");
        $opackage->INVOICE = $this->request->getPost("INVOICE");
        $opackage->INVOICE_TITLE = $this->request->getPost("INVOICE_TITLE");
        $opackage->INVOICE_CONTENT = $this->request->getPost("INVOICE_CONTENT");
        $opackage->DELIVERY_CITY_ID = $this->request->getPost("DELIVERY_CITY_ID");
        $opackage->DELIVERY_TYPE = $this->request->getPost("DELIVERY_TYPE");
        $opackage->DELIVERY_TIME = $this->request->getPost("DELIVERY_TIME");
        $opackage->REACH_USERNAME = $this->request->getPost("REACH_USERNAME");
        $opackage->REACH_USER_EMAIL = $this->request->getPost("REACH_USER_EMAIL");
        $opackage->REACH_USER_ADDRESS = $this->request->getPost("REACH_USER_ADDRESS");
        $opackage->REACH_USER_PHONE = $this->request->getPost("REACH_USER_PHONE");
        $opackage->REACH_USER_PROVINCE = $this->request->getPost("REACH_USER_PROVINCE");
        $opackage->REACH_USER_CITY = $this->request->getPost("REACH_USER_CITY");
        $opackage->REACH_USER_LOCALITY = $this->request->getPost("REACH_USER_LOCALITY");
        $opackage->REACH_USER_ZONE = $this->request->getPost("REACH_USER_ZONE");
        $opackage->REACH_USER_ZIPCODE = $this->request->getPost("REACH_USER_ZIPCODE");
        $opackage->DELIVERY_PERSON_ID = $this->request->getPost("DELIVERY_PERSON_ID");
        $opackage->DELIVERY_PERSON_NAME = $this->request->getPost("DELIVERY_PERSON_NAME");
        $opackage->DELIVERY_STATUS = $this->request->getPost("DELIVERY_STATUS");
        $opackage->DELIVERY_NO = $this->request->getPost("DELIVERY_NO");
        $opackage->REMARKS = $this->request->getPost("REMARKS");
        $opackage->MONEY = $this->request->getPost("MONEY");
        $opackage->COURIER = $this->request->getPost("COURIER");
        $opackage->SHOULD_PAY = $this->request->getPost("SHOULD_PAY");
        $opackage->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $opackage->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $opackage->PAYMENT_STATUS = $this->request->getPost("PAYMENT_STATUS");
        $opackage->AGENCYID = $this->request->getPost("AGENCYID");
        $opackage->AGENCY_ID = $this->request->getPost("AGENCY_ID");
        $opackage->DELIVERY_COMPANY = $this->request->getPost("DELIVERY_COMPANY");
        $opackage->ORDER_TOTAL_MONEY = $this->request->getPost("ORDER_TOTAL_MONEY");
        $opackage->ORDER_DISCOUNT_TOTAL_MONEY = $this->request->getPost("ORDER_DISCOUNT_TOTAL_MONEY");
        $opackage->VIRTUAL_MONEY = $this->request->getPost("VIRTUAL_MONEY");
        $opackage->VIRTUAL_MONEY_TYPE = $this->request->getPost("VIRTUAL_MONEY_TYPE");
        $opackage->COD = $this->request->getPost("COD");
        $opackage->PAYMENT_CLASS = $this->request->getPost("PAYMENT_CLASS");
        $opackage->REAL_PAY = $this->request->getPost("REAL_PAY");
        $opackage->USERNAME = $this->request->getPost("USERNAME");
        if (!$opackage->save()) {
            foreach ($opackage->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "edit", "params" => array($opackage->ID)));
        } else {
            $this->flash->success("o package was updated successfully");
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $opackage = OPackage::findFirst('ID="'.$ID.'"');
        if (!$opackage) {
            $this->flash->error("o package was not found");
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }

        if (!$opackage->delete()) {
            foreach ($opackage->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "search"));
        } else {
            $this->flash->success("o package was deleted");
            return $this->dispatcher->forward(array("controller" => "opackage", "action" => "index"));
        }
    }

}
