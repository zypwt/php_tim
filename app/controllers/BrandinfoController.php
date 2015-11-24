<?php

use \Phalcon\Tag as Tag;

class BrandInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "BrandInfo", $_POST);
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

        $brandinfo = BrandInfo::find($parameters);
        if (count($brandinfo) == 0) {
            $this->flash->notice("The search did not find any brand info");
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $brandinfo,
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

            $brandinfo = BrandInfo::findFirst('ID="'.$ID.'"');
            if (!$brandinfo) {
                $this->flash->error("brand info was not found");
                return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $brandinfo->ID);
        
            Tag::displayTo("ID", $brandinfo->ID);
            Tag::displayTo("NAME", $brandinfo->NAME);
            Tag::displayTo("IS_VISIBEL", $brandinfo->IS_VISIBEL);
            Tag::displayTo("CREATE_TIME", $brandinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $brandinfo->UPDATE_TIME);
            Tag::displayTo("ONLINE_IDS", $brandinfo->ONLINE_IDS);
            Tag::displayTo("CITY_ID", $brandinfo->CITY_ID);
            Tag::displayTo("SORT", $brandinfo->SORT);
            Tag::displayTo("IMAGE", $brandinfo->IMAGE);
            Tag::displayTo("BRANDURL", $brandinfo->BRANDURL);
            Tag::displayTo("TEMPLET", $brandinfo->TEMPLET);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

        $brandinfo = new BrandInfo();
        $brandinfo->ID = $this->request->getPost("ID");
        $brandinfo->NAME = $this->request->getPost("NAME");
        $brandinfo->IS_VISIBEL = $this->request->getPost("IS_VISIBEL");
        $brandinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $brandinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $brandinfo->ONLINE_IDS = $this->request->getPost("ONLINE_IDS");
        $brandinfo->CITY_ID = $this->request->getPost("CITY_ID");
        $brandinfo->SORT = $this->request->getPost("SORT");
        $brandinfo->IMAGE = $this->request->getPost("IMAGE");
        $brandinfo->BRANDURL = $this->request->getPost("BRANDURL");
        $brandinfo->TEMPLET = $this->request->getPost("TEMPLET");
        if (!$brandinfo->save()) {
            foreach ($brandinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "new"));
        } else {
            $this->flash->success("brand info was created successfully");
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $brandinfo = BrandInfo::findFirst("ID='$ID'");
        if (!$brandinfo) {
            $this->flash->error("brand info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }
        $brandinfo->ID = $this->request->getPost("ID");
        $brandinfo->NAME = $this->request->getPost("NAME");
        $brandinfo->IS_VISIBEL = $this->request->getPost("IS_VISIBEL");
        $brandinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $brandinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $brandinfo->ONLINE_IDS = $this->request->getPost("ONLINE_IDS");
        $brandinfo->CITY_ID = $this->request->getPost("CITY_ID");
        $brandinfo->SORT = $this->request->getPost("SORT");
        $brandinfo->IMAGE = $this->request->getPost("IMAGE");
        $brandinfo->BRANDURL = $this->request->getPost("BRANDURL");
        $brandinfo->TEMPLET = $this->request->getPost("TEMPLET");
        if (!$brandinfo->save()) {
            foreach ($brandinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "edit", "params" => array($brandinfo->ID)));
        } else {
            $this->flash->success("brand info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $brandinfo = BrandInfo::findFirst('ID="'.$ID.'"');
        if (!$brandinfo) {
            $this->flash->error("brand info was not found");
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }

        if (!$brandinfo->delete()) {
            foreach ($brandinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "search"));
        } else {
            $this->flash->success("brand info was deleted");
            return $this->dispatcher->forward(array("controller" => "brandinfo", "action" => "index"));
        }
    }

}
