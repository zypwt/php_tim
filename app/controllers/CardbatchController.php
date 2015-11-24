<?php

use \Phalcon\Tag as Tag;

class CardBatchController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "CardBatch", $_POST);
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

        $cardbatch = CardBatch::find($parameters);
        if (count($cardbatch) == 0) {
            $this->flash->notice("The search did not find any card batch");
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $cardbatch,
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

            $cardbatch = CardBatch::findFirst('ID="'.$ID.'"');
            if (!$cardbatch) {
                $this->flash->error("card batch was not found");
                return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
            }
            $this->view->setVar("ID", $cardbatch->ID);
        
            Tag::displayTo("ID", $cardbatch->ID);
            Tag::displayTo("BATCH_ID", $cardbatch->BATCH_ID);
            Tag::displayTo("CARD_NUM", $cardbatch->CARD_NUM);
            Tag::displayTo("CREATE_UUID", $cardbatch->CREATE_UUID);
            Tag::displayTo("CREATE_NAME", $cardbatch->CREATE_NAME);
            Tag::displayTo("CREATE_TIME", $cardbatch->CREATE_TIME);
            Tag::displayTo("FILE_URL", $cardbatch->FILE_URL);
            Tag::displayTo("AUDIT_STATUS", $cardbatch->AUDIT_STATUS);
            Tag::displayTo("AUDIT_UUID", $cardbatch->AUDIT_UUID);
            Tag::displayTo("AUDIT_NAME", $cardbatch->AUDIT_NAME);
            Tag::displayTo("AUDIT_TIME", $cardbatch->AUDIT_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

        $cardbatch = new CardBatch();
        $cardbatch->ID = $this->request->getPost("ID");
        $cardbatch->BATCH_ID = $this->request->getPost("BATCH_ID");
        $cardbatch->CARD_NUM = $this->request->getPost("CARD_NUM");
        $cardbatch->CREATE_UUID = $this->request->getPost("CREATE_UUID");
        $cardbatch->CREATE_NAME = $this->request->getPost("CREATE_NAME");
        $cardbatch->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cardbatch->FILE_URL = $this->request->getPost("FILE_URL");
        $cardbatch->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $cardbatch->AUDIT_UUID = $this->request->getPost("AUDIT_UUID");
        $cardbatch->AUDIT_NAME = $this->request->getPost("AUDIT_NAME");
        $cardbatch->AUDIT_TIME = $this->request->getPost("AUDIT_TIME");
        if (!$cardbatch->save()) {
            foreach ($cardbatch->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "new"));
        } else {
            $this->flash->success("card batch was created successfully");
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $cardbatch = CardBatch::findFirst("ID='$ID'");
        if (!$cardbatch) {
            $this->flash->error("card batch does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }
        $cardbatch->ID = $this->request->getPost("ID");
        $cardbatch->BATCH_ID = $this->request->getPost("BATCH_ID");
        $cardbatch->CARD_NUM = $this->request->getPost("CARD_NUM");
        $cardbatch->CREATE_UUID = $this->request->getPost("CREATE_UUID");
        $cardbatch->CREATE_NAME = $this->request->getPost("CREATE_NAME");
        $cardbatch->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $cardbatch->FILE_URL = $this->request->getPost("FILE_URL");
        $cardbatch->AUDIT_STATUS = $this->request->getPost("AUDIT_STATUS");
        $cardbatch->AUDIT_UUID = $this->request->getPost("AUDIT_UUID");
        $cardbatch->AUDIT_NAME = $this->request->getPost("AUDIT_NAME");
        $cardbatch->AUDIT_TIME = $this->request->getPost("AUDIT_TIME");
        if (!$cardbatch->save()) {
            foreach ($cardbatch->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "edit", "params" => array($cardbatch->ID)));
        } else {
            $this->flash->success("card batch was updated successfully");
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $cardbatch = CardBatch::findFirst('ID="'.$ID.'"');
        if (!$cardbatch) {
            $this->flash->error("card batch was not found");
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }

        if (!$cardbatch->delete()) {
            foreach ($cardbatch->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "search"));
        } else {
            $this->flash->success("card batch was deleted");
            return $this->dispatcher->forward(array("controller" => "cardbatch", "action" => "index"));
        }
    }

}
