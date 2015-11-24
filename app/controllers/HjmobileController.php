<?php

use \Phalcon\Tag as Tag;

class HjMobileController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "HjMobile", $_POST);
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

        $hjmobile = HjMobile::find($parameters);
        if (count($hjmobile) == 0) {
            $this->flash->notice("The search did not find any hj mobile");
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $hjmobile,
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

            $hjmobile = HjMobile::findFirst('1="'.$1.'"');
            if (!$hjmobile) {
                $this->flash->error("hj mobile was not found");
                return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
            }
            $this->view->setVar("1", $hjmobile->1);
        
            Tag::displayTo("MOBILE", $hjmobile->MOBILE);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

        $hjmobile = new HjMobile();
        $hjmobile->MOBILE = $this->request->getPost("MOBILE");
        if (!$hjmobile->save()) {
            foreach ($hjmobile->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "new"));
        } else {
            $this->flash->success("hj mobile was created successfully");
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

        $1 = $this->request->getPost("1", "int");
        $hjmobile = HjMobile::findFirst("1='$1'");
        if (!$hjmobile) {
            $this->flash->error("hj mobile does not exist ".$1);
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }
        $hjmobile->MOBILE = $this->request->getPost("MOBILE");
        if (!$hjmobile->save()) {
            foreach ($hjmobile->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "edit", "params" => array($hjmobile->1)));
        } else {
            $this->flash->success("hj mobile was updated successfully");
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

    }

    public function deleteAction($1){

        $1 = $this->filter->sanitize($1, array("int"));

        $hjmobile = HjMobile::findFirst('1="'.$1.'"');
        if (!$hjmobile) {
            $this->flash->error("hj mobile was not found");
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }

        if (!$hjmobile->delete()) {
            foreach ($hjmobile->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "search"));
        } else {
            $this->flash->success("hj mobile was deleted");
            return $this->dispatcher->forward(array("controller" => "hjmobile", "action" => "index"));
        }
    }

}
