<?php

use \Phalcon\Tag as Tag;

class LuckDrawStockController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "LuckDrawStock", $_POST);
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
        $parameters["order"] = "1";

        $luckdrawstock = LuckDrawStock::find($parameters);
        if (count($luckdrawstock) == 0) {
            $this->flash->notice("The search did not find any luck draw stock");
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $luckdrawstock,
            "limit"=> 10,
            "page" => $numberPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
    }

    public function newAction()
    {

    }

    public function editAction($1)
    {

        $request = $this->request;
        if (!$request->isPost()) {

            $1 = $this->filter->sanitize($1, array("int"));

            $luckdrawstock = LuckDrawStock::findFirst('1="'.$1.'"');
            if (!$luckdrawstock) {
                $this->flash->error("luck draw stock was not found");
                return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
            }
            $this->view->setVar("1", $luckdrawstock->1);
        
            Tag::displayTo("ID", $luckdrawstock->ID);
            Tag::displayTo("PRICE", $luckdrawstock->PRICE);
            Tag::displayTo("STATUS", $luckdrawstock->STATUS);
            Tag::displayTo("START_DRAW_TIME", $luckdrawstock->START_DRAW_TIME);
            Tag::displayTo("END_DRAW_TIME", $luckdrawstock->END_DRAW_TIME);
            Tag::displayTo("NUM", $luckdrawstock->NUM);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

        $luckdrawstock = new LuckDrawStock();
        $luckdrawstock->ID = $this->request->getPost("ID");
        $luckdrawstock->PRICE = $this->request->getPost("PRICE");
        $luckdrawstock->STATUS = $this->request->getPost("STATUS");
        $luckdrawstock->START_DRAW_TIME = $this->request->getPost("START_DRAW_TIME");
        $luckdrawstock->END_DRAW_TIME = $this->request->getPost("END_DRAW_TIME");
        $luckdrawstock->NUM = $this->request->getPost("NUM");
        if (!$luckdrawstock->save()) {
            foreach ($luckdrawstock->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "new"));
        } else {
            $this->flash->success("luck draw stock was created successfully");
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $luckdrawstock = LuckDrawStock::findFirst("1='$1'");
        if (!$luckdrawstock) {
            $this->flash->error("luck draw stock does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }
        $luckdrawstock->ID = $this->request->getPost("ID");
        $luckdrawstock->PRICE = $this->request->getPost("PRICE");
        $luckdrawstock->STATUS = $this->request->getPost("STATUS");
        $luckdrawstock->START_DRAW_TIME = $this->request->getPost("START_DRAW_TIME");
        $luckdrawstock->END_DRAW_TIME = $this->request->getPost("END_DRAW_TIME");
        $luckdrawstock->NUM = $this->request->getPost("NUM");
        if (!$luckdrawstock->save()) {
            foreach ($luckdrawstock->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "edit", "params" => array($luckdrawstock->1)));
        } else {
            $this->flash->success("luck draw stock was updated successfully");
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $luckdrawstock = LuckDrawStock::findFirst('1="'.$1.'"');
        if (!$luckdrawstock) {
            $this->flash->error("luck draw stock was not found");
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }

        if (!$luckdrawstock->delete()) {
            foreach ($luckdrawstock->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "search"));
        } else {
            $this->flash->success("luck draw stock was deleted");
            return $this->dispatcher->forward(array("controller" => "luckdrawstock", "action" => "index"));
        }
    }

}
