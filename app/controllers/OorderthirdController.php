<?php

use \Phalcon\Tag as Tag;

class OOrderThirdController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "OOrderThird", $_POST);
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

        $oorderthird = OOrderThird::find($parameters);
        if (count($oorderthird) == 0) {
            $this->flash->notice("The search did not find any o order third");
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $oorderthird,
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

            $oorderthird = OOrderThird::findFirst('ID="'.$ID.'"');
            if (!$oorderthird) {
                $this->flash->error("o order third was not found");
                return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
            }
            $this->view->setVar("ID", $oorderthird->ID);
        
            Tag::displayTo("ID", $oorderthird->ID);
            Tag::displayTo("ORDER_NO_CRM", $oorderthird->ORDER_NO_CRM);
            Tag::displayTo("ORDER_NO_THIRD", $oorderthird->ORDER_NO_THIRD);
            Tag::displayTo("ORDER_ITEMS", $oorderthird->ORDER_ITEMS);
            Tag::displayTo("LOCK_NO", $oorderthird->LOCK_NO);
            Tag::displayTo("TICKET_SYS_DIC_ID", $oorderthird->TICKET_SYS_DIC_ID);
            Tag::displayTo("PACKAGE_ID", $oorderthird->PACKAGE_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

        $oorderthird = new OOrderThird();
        $oorderthird->ID = $this->request->getPost("ID");
        $oorderthird->ORDER_NO_CRM = $this->request->getPost("ORDER_NO_CRM");
        $oorderthird->ORDER_NO_THIRD = $this->request->getPost("ORDER_NO_THIRD");
        $oorderthird->ORDER_ITEMS = $this->request->getPost("ORDER_ITEMS");
        $oorderthird->LOCK_NO = $this->request->getPost("LOCK_NO");
        $oorderthird->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $oorderthird->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        if (!$oorderthird->save()) {
            foreach ($oorderthird->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "new"));
        } else {
            $this->flash->success("o order third was created successfully");
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $oorderthird = OOrderThird::findFirst("ID='$ID'");
        if (!$oorderthird) {
            $this->flash->error("o order third does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }
        $oorderthird->ID = $this->request->getPost("ID");
        $oorderthird->ORDER_NO_CRM = $this->request->getPost("ORDER_NO_CRM");
        $oorderthird->ORDER_NO_THIRD = $this->request->getPost("ORDER_NO_THIRD");
        $oorderthird->ORDER_ITEMS = $this->request->getPost("ORDER_ITEMS");
        $oorderthird->LOCK_NO = $this->request->getPost("LOCK_NO");
        $oorderthird->TICKET_SYS_DIC_ID = $this->request->getPost("TICKET_SYS_DIC_ID");
        $oorderthird->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        if (!$oorderthird->save()) {
            foreach ($oorderthird->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "edit", "params" => array($oorderthird->ID)));
        } else {
            $this->flash->success("o order third was updated successfully");
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $oorderthird = OOrderThird::findFirst('ID="'.$ID.'"');
        if (!$oorderthird) {
            $this->flash->error("o order third was not found");
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }

        if (!$oorderthird->delete()) {
            foreach ($oorderthird->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "search"));
        } else {
            $this->flash->success("o order third was deleted");
            return $this->dispatcher->forward(array("controller" => "oorderthird", "action" => "index"));
        }
    }

}
