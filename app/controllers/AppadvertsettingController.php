<?php

use \Phalcon\Tag as Tag;

class AppAdvertSettingController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "AppAdvertSetting", $_POST);
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

        $appadvertsetting = AppAdvertSetting::find($parameters);
        if (count($appadvertsetting) == 0) {
            $this->flash->notice("The search did not find any app advert setting");
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $appadvertsetting,
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

            $appadvertsetting = AppAdvertSetting::findFirst('ID="'.$ID.'"');
            if (!$appadvertsetting) {
                $this->flash->error("app advert setting was not found");
                return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
            }
            $this->view->setVar("ID", $appadvertsetting->ID);
        
            Tag::displayTo("ID", $appadvertsetting->ID);
            Tag::displayTo("ITEMURL", $appadvertsetting->ITEMURL);
            Tag::displayTo("IMAGENAME", $appadvertsetting->IMAGENAME);
            Tag::displayTo("ONLINEID", $appadvertsetting->ONLINEID);
            Tag::displayTo("UPDATETIME", $appadvertsetting->UPDATETIME);
            Tag::displayTo("CRTIME", $appadvertsetting->CRTIME);
            Tag::displayTo("USEDSTATUS", $appadvertsetting->USEDSTATUS);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

        $appadvertsetting = new AppAdvertSetting();
        $appadvertsetting->ID = $this->request->getPost("ID");
        $appadvertsetting->ITEMURL = $this->request->getPost("ITEMURL");
        $appadvertsetting->IMAGENAME = $this->request->getPost("IMAGENAME");
        $appadvertsetting->ONLINEID = $this->request->getPost("ONLINEID");
        $appadvertsetting->UPDATETIME = $this->request->getPost("UPDATETIME");
        $appadvertsetting->CRTIME = $this->request->getPost("CRTIME");
        $appadvertsetting->USEDSTATUS = $this->request->getPost("USEDSTATUS");
        if (!$appadvertsetting->save()) {
            foreach ($appadvertsetting->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "new"));
        } else {
            $this->flash->success("app advert setting was created successfully");
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $appadvertsetting = AppAdvertSetting::findFirst("ID='$ID'");
        if (!$appadvertsetting) {
            $this->flash->error("app advert setting does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }
        $appadvertsetting->ID = $this->request->getPost("ID");
        $appadvertsetting->ITEMURL = $this->request->getPost("ITEMURL");
        $appadvertsetting->IMAGENAME = $this->request->getPost("IMAGENAME");
        $appadvertsetting->ONLINEID = $this->request->getPost("ONLINEID");
        $appadvertsetting->UPDATETIME = $this->request->getPost("UPDATETIME");
        $appadvertsetting->CRTIME = $this->request->getPost("CRTIME");
        $appadvertsetting->USEDSTATUS = $this->request->getPost("USEDSTATUS");
        if (!$appadvertsetting->save()) {
            foreach ($appadvertsetting->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "edit", "params" => array($appadvertsetting->ID)));
        } else {
            $this->flash->success("app advert setting was updated successfully");
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $appadvertsetting = AppAdvertSetting::findFirst('ID="'.$ID.'"');
        if (!$appadvertsetting) {
            $this->flash->error("app advert setting was not found");
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }

        if (!$appadvertsetting->delete()) {
            foreach ($appadvertsetting->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "search"));
        } else {
            $this->flash->success("app advert setting was deleted");
            return $this->dispatcher->forward(array("controller" => "appadvertsetting", "action" => "index"));
        }
    }

}
