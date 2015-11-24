<?php

use \Phalcon\Tag as Tag;

class PriceInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "PriceInfo", $_POST);
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

        $priceinfo = PriceInfo::find($parameters);
        if (count($priceinfo) == 0) {
            $this->flash->notice("The search did not find any price info");
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $priceinfo,
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

            $priceinfo = PriceInfo::findFirst('ID="'.$ID.'"');
            if (!$priceinfo) {
                $this->flash->error("price info was not found");
                return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $priceinfo->ID);
        
            Tag::displayTo("ID", $priceinfo->ID);
            Tag::displayTo("SENCE_ID", $priceinfo->SENCE_ID);
            Tag::displayTo("ITEM_ID", $priceinfo->ITEM_ID);
            Tag::displayTo("ONLINE_ID", $priceinfo->ONLINE_ID);
            Tag::displayTo("NAME", $priceinfo->NAME);
            Tag::displayTo("SORT", $priceinfo->SORT);
            Tag::displayTo("PRICE", $priceinfo->PRICE);
            Tag::displayTo("COST_PRICE", $priceinfo->COST_PRICE);
            Tag::displayTo("SELL_PRICE", $priceinfo->SELL_PRICE);
            Tag::displayTo("DISCOUNT", $priceinfo->DISCOUNT);
            Tag::displayTo("SELL_NUM", $priceinfo->SELL_NUM);
            Tag::displayTo("PRICE_TYPE", $priceinfo->PRICE_TYPE);
            Tag::displayTo("PRICE_LEVEL", $priceinfo->PRICE_LEVEL);
            Tag::displayTo("PRICE_STATUS", $priceinfo->PRICE_STATUS);
            Tag::displayTo("TOTAL", $priceinfo->TOTAL);
            Tag::displayTo("REMARK", $priceinfo->REMARK);
            Tag::displayTo("CREATE_TIME", $priceinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $priceinfo->UPDATE_TIME);
            Tag::displayTo("SHOW_START_TIME", $priceinfo->SHOW_START_TIME);
            Tag::displayTo("XSZC_ID", $priceinfo->XSZC_ID);
            Tag::displayTo("PJDJ", $priceinfo->PJDJ);
            Tag::displayTo("OPT", $priceinfo->OPT);
            Tag::displayTo("GROUP_NAME", $priceinfo->GROUP_NAME);
            Tag::displayTo("THIRDPRICEID", $priceinfo->THIRDPRICEID);
            Tag::displayTo("THIRDITEMID", $priceinfo->THIRDITEMID);
            Tag::displayTo("THIRDSCENEID", $priceinfo->THIRDSCENEID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

        $priceinfo = new PriceInfo();
        $priceinfo->ID = $this->request->getPost("ID");
        $priceinfo->SENCE_ID = $this->request->getPost("SENCE_ID");
        $priceinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $priceinfo->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $priceinfo->NAME = $this->request->getPost("NAME");
        $priceinfo->SORT = $this->request->getPost("SORT");
        $priceinfo->PRICE = $this->request->getPost("PRICE");
        $priceinfo->COST_PRICE = $this->request->getPost("COST_PRICE");
        $priceinfo->SELL_PRICE = $this->request->getPost("SELL_PRICE");
        $priceinfo->DISCOUNT = $this->request->getPost("DISCOUNT");
        $priceinfo->SELL_NUM = $this->request->getPost("SELL_NUM");
        $priceinfo->PRICE_TYPE = $this->request->getPost("PRICE_TYPE");
        $priceinfo->PRICE_LEVEL = $this->request->getPost("PRICE_LEVEL");
        $priceinfo->PRICE_STATUS = $this->request->getPost("PRICE_STATUS");
        $priceinfo->TOTAL = $this->request->getPost("TOTAL");
        $priceinfo->REMARK = $this->request->getPost("REMARK");
        $priceinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $priceinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $priceinfo->SHOW_START_TIME = $this->request->getPost("SHOW_START_TIME");
        $priceinfo->XSZC_ID = $this->request->getPost("XSZC_ID");
        $priceinfo->PJDJ = $this->request->getPost("PJDJ");
        $priceinfo->OPT = $this->request->getPost("OPT");
        $priceinfo->GROUP_NAME = $this->request->getPost("GROUP_NAME");
        $priceinfo->THIRDPRICEID = $this->request->getPost("THIRDPRICEID");
        $priceinfo->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        $priceinfo->THIRDSCENEID = $this->request->getPost("THIRDSCENEID");
        if (!$priceinfo->save()) {
            foreach ($priceinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "new"));
        } else {
            $this->flash->success("price info was created successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $priceinfo = PriceInfo::findFirst("ID='$ID'");
        if (!$priceinfo) {
            $this->flash->error("price info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }
        $priceinfo->ID = $this->request->getPost("ID");
        $priceinfo->SENCE_ID = $this->request->getPost("SENCE_ID");
        $priceinfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $priceinfo->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $priceinfo->NAME = $this->request->getPost("NAME");
        $priceinfo->SORT = $this->request->getPost("SORT");
        $priceinfo->PRICE = $this->request->getPost("PRICE");
        $priceinfo->COST_PRICE = $this->request->getPost("COST_PRICE");
        $priceinfo->SELL_PRICE = $this->request->getPost("SELL_PRICE");
        $priceinfo->DISCOUNT = $this->request->getPost("DISCOUNT");
        $priceinfo->SELL_NUM = $this->request->getPost("SELL_NUM");
        $priceinfo->PRICE_TYPE = $this->request->getPost("PRICE_TYPE");
        $priceinfo->PRICE_LEVEL = $this->request->getPost("PRICE_LEVEL");
        $priceinfo->PRICE_STATUS = $this->request->getPost("PRICE_STATUS");
        $priceinfo->TOTAL = $this->request->getPost("TOTAL");
        $priceinfo->REMARK = $this->request->getPost("REMARK");
        $priceinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $priceinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $priceinfo->SHOW_START_TIME = $this->request->getPost("SHOW_START_TIME");
        $priceinfo->XSZC_ID = $this->request->getPost("XSZC_ID");
        $priceinfo->PJDJ = $this->request->getPost("PJDJ");
        $priceinfo->OPT = $this->request->getPost("OPT");
        $priceinfo->GROUP_NAME = $this->request->getPost("GROUP_NAME");
        $priceinfo->THIRDPRICEID = $this->request->getPost("THIRDPRICEID");
        $priceinfo->THIRDITEMID = $this->request->getPost("THIRDITEMID");
        $priceinfo->THIRDSCENEID = $this->request->getPost("THIRDSCENEID");
        if (!$priceinfo->save()) {
            foreach ($priceinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "edit", "params" => array($priceinfo->ID)));
        } else {
            $this->flash->success("price info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $priceinfo = PriceInfo::findFirst('ID="'.$ID.'"');
        if (!$priceinfo) {
            $this->flash->error("price info was not found");
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }

        if (!$priceinfo->delete()) {
            foreach ($priceinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "search"));
        } else {
            $this->flash->success("price info was deleted");
            return $this->dispatcher->forward(array("controller" => "priceinfo", "action" => "index"));
        }
    }

}
