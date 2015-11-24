<?php

use \Phalcon\Tag as Tag;

class LuckDrawController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "LuckDraw", $_POST);
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

        $luckdraw = LuckDraw::find($parameters);
        if (count($luckdraw) == 0) {
            $this->flash->notice("The search did not find any luck draw");
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $luckdraw,
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

            $luckdraw = LuckDraw::findFirst('ID="'.$ID.'"');
            if (!$luckdraw) {
                $this->flash->error("luck draw was not found");
                return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
            }
            $this->view->setVar("ID", $luckdraw->ID);
        
            Tag::displayTo("ID", $luckdraw->ID);
            Tag::displayTo("USER_ID", $luckdraw->USER_ID);
            Tag::displayTo("ORDER_ID", $luckdraw->ORDER_ID);
            Tag::displayTo("PRICE", $luckdraw->PRICE);
            Tag::displayTo("STATUS", $luckdraw->STATUS);
            Tag::displayTo("DRAW_TIME", $luckdraw->DRAW_TIME);
            Tag::displayTo("GIFT_CARD_ID", $luckdraw->GIFT_CARD_ID);
            Tag::displayTo("PRIZE_DETAIL", $luckdraw->PRIZE_DETAIL);
            Tag::displayTo("DRAW_DAY", $luckdraw->DRAW_DAY);
            Tag::displayTo("CARD_PRICE", $luckdraw->CARD_PRICE);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

        $luckdraw = new LuckDraw();
        $luckdraw->ID = $this->request->getPost("ID");
        $luckdraw->USER_ID = $this->request->getPost("USER_ID");
        $luckdraw->ORDER_ID = $this->request->getPost("ORDER_ID");
        $luckdraw->PRICE = $this->request->getPost("PRICE");
        $luckdraw->STATUS = $this->request->getPost("STATUS");
        $luckdraw->DRAW_TIME = $this->request->getPost("DRAW_TIME");
        $luckdraw->GIFT_CARD_ID = $this->request->getPost("GIFT_CARD_ID");
        $luckdraw->PRIZE_DETAIL = $this->request->getPost("PRIZE_DETAIL");
        $luckdraw->DRAW_DAY = $this->request->getPost("DRAW_DAY");
        $luckdraw->CARD_PRICE = $this->request->getPost("CARD_PRICE");
        if (!$luckdraw->save()) {
            foreach ($luckdraw->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "new"));
        } else {
            $this->flash->success("luck draw was created successfully");
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $luckdraw = LuckDraw::findFirst("ID='$ID'");
        if (!$luckdraw) {
            $this->flash->error("luck draw does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }
        $luckdraw->ID = $this->request->getPost("ID");
        $luckdraw->USER_ID = $this->request->getPost("USER_ID");
        $luckdraw->ORDER_ID = $this->request->getPost("ORDER_ID");
        $luckdraw->PRICE = $this->request->getPost("PRICE");
        $luckdraw->STATUS = $this->request->getPost("STATUS");
        $luckdraw->DRAW_TIME = $this->request->getPost("DRAW_TIME");
        $luckdraw->GIFT_CARD_ID = $this->request->getPost("GIFT_CARD_ID");
        $luckdraw->PRIZE_DETAIL = $this->request->getPost("PRIZE_DETAIL");
        $luckdraw->DRAW_DAY = $this->request->getPost("DRAW_DAY");
        $luckdraw->CARD_PRICE = $this->request->getPost("CARD_PRICE");
        if (!$luckdraw->save()) {
            foreach ($luckdraw->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "edit", "params" => array($luckdraw->ID)));
        } else {
            $this->flash->success("luck draw was updated successfully");
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $luckdraw = LuckDraw::findFirst('ID="'.$ID.'"');
        if (!$luckdraw) {
            $this->flash->error("luck draw was not found");
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }

        if (!$luckdraw->delete()) {
            foreach ($luckdraw->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "search"));
        } else {
            $this->flash->success("luck draw was deleted");
            return $this->dispatcher->forward(array("controller" => "luckdraw", "action" => "index"));
        }
    }

}
