<?php

use \Phalcon\Tag as Tag;

class ForeignOrderRelationController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ForeignOrderRelation", $_POST);
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

        $foreignorderrelation = ForeignOrderRelation::find($parameters);
        if (count($foreignorderrelation) == 0) {
            $this->flash->notice("The search did not find any foreign order relation");
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $foreignorderrelation,
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

            $foreignorderrelation = ForeignOrderRelation::findFirst('ID="'.$ID.'"');
            if (!$foreignorderrelation) {
                $this->flash->error("foreign order relation was not found");
                return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
            }
            $this->view->setVar("ID", $foreignorderrelation->ID);
        
            Tag::displayTo("ID", $foreignorderrelation->ID);
            Tag::displayTo("PACKAGE_ID", $foreignorderrelation->PACKAGE_ID);
            Tag::displayTo("FOREIGN_ORDER_ID", $foreignorderrelation->FOREIGN_ORDER_ID);
            Tag::displayTo("FOREIGN_ORDER_CONTEXT", $foreignorderrelation->FOREIGN_ORDER_CONTEXT);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

        $foreignorderrelation = new ForeignOrderRelation();
        $foreignorderrelation->ID = $this->request->getPost("ID");
        $foreignorderrelation->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $foreignorderrelation->FOREIGN_ORDER_ID = $this->request->getPost("FOREIGN_ORDER_ID");
        $foreignorderrelation->FOREIGN_ORDER_CONTEXT = $this->request->getPost("FOREIGN_ORDER_CONTEXT");
        if (!$foreignorderrelation->save()) {
            foreach ($foreignorderrelation->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "new"));
        } else {
            $this->flash->success("foreign order relation was created successfully");
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $foreignorderrelation = ForeignOrderRelation::findFirst("ID='$ID'");
        if (!$foreignorderrelation) {
            $this->flash->error("foreign order relation does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }
        $foreignorderrelation->ID = $this->request->getPost("ID");
        $foreignorderrelation->PACKAGE_ID = $this->request->getPost("PACKAGE_ID");
        $foreignorderrelation->FOREIGN_ORDER_ID = $this->request->getPost("FOREIGN_ORDER_ID");
        $foreignorderrelation->FOREIGN_ORDER_CONTEXT = $this->request->getPost("FOREIGN_ORDER_CONTEXT");
        if (!$foreignorderrelation->save()) {
            foreach ($foreignorderrelation->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "edit", "params" => array($foreignorderrelation->ID)));
        } else {
            $this->flash->success("foreign order relation was updated successfully");
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $foreignorderrelation = ForeignOrderRelation::findFirst('ID="'.$ID.'"');
        if (!$foreignorderrelation) {
            $this->flash->error("foreign order relation was not found");
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }

        if (!$foreignorderrelation->delete()) {
            foreach ($foreignorderrelation->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "search"));
        } else {
            $this->flash->success("foreign order relation was deleted");
            return $this->dispatcher->forward(array("controller" => "foreignorderrelation", "action" => "index"));
        }
    }

}
