<?php

use \Phalcon\Tag as Tag;

class AArtistInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "AArtistInfo", $_POST);
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

        $aartistinfo = AArtistInfo::find($parameters);
        if (count($aartistinfo) == 0) {
            $this->flash->notice("The search did not find any a artist info");
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $aartistinfo,
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

            $aartistinfo = AArtistInfo::findFirst('ID="'.$ID.'"');
            if (!$aartistinfo) {
                $this->flash->error("a artist info was not found");
                return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $aartistinfo->ID);
        
            Tag::displayTo("ID", $aartistinfo->ID);
            Tag::displayTo("ARTIST_NAME", $aartistinfo->ARTIST_NAME);
            Tag::displayTo("ARTIST_EN_NAME", $aartistinfo->ARTIST_EN_NAME);
            Tag::displayTo("ARTIST_SPELL", $aartistinfo->ARTIST_SPELL);
            Tag::displayTo("ARTIST_AREA", $aartistinfo->ARTIST_AREA);
            Tag::displayTo("ARTIST_TYPE", $aartistinfo->ARTIST_TYPE);
            Tag::displayTo("IS_VISIBLE", $aartistinfo->IS_VISIBLE);
            Tag::displayTo("ARTIST_OCCUPATION", $aartistinfo->ARTIST_OCCUPATION);
            Tag::displayTo("ARTIST_DESC", $aartistinfo->ARTIST_DESC);
            Tag::displayTo("ARTIST_IMAGE_URL", $aartistinfo->ARTIST_IMAGE_URL);
            Tag::displayTo("ARTIST_BIRTHDAY", $aartistinfo->ARTIST_BIRTHDAY);
            Tag::displayTo("CREATE_TIME", $aartistinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $aartistinfo->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

        $aartistinfo = new AArtistInfo();
        $aartistinfo->ID = $this->request->getPost("ID");
        $aartistinfo->ARTIST_NAME = $this->request->getPost("ARTIST_NAME");
        $aartistinfo->ARTIST_EN_NAME = $this->request->getPost("ARTIST_EN_NAME");
        $aartistinfo->ARTIST_SPELL = $this->request->getPost("ARTIST_SPELL");
        $aartistinfo->ARTIST_AREA = $this->request->getPost("ARTIST_AREA");
        $aartistinfo->ARTIST_TYPE = $this->request->getPost("ARTIST_TYPE");
        $aartistinfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $aartistinfo->ARTIST_OCCUPATION = $this->request->getPost("ARTIST_OCCUPATION");
        $aartistinfo->ARTIST_DESC = $this->request->getPost("ARTIST_DESC");
        $aartistinfo->ARTIST_IMAGE_URL = $this->request->getPost("ARTIST_IMAGE_URL");
        $aartistinfo->ARTIST_BIRTHDAY = $this->request->getPost("ARTIST_BIRTHDAY");
        $aartistinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $aartistinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$aartistinfo->save()) {
            foreach ($aartistinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "new"));
        } else {
            $this->flash->success("a artist info was created successfully");
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $aartistinfo = AArtistInfo::findFirst("ID='$ID'");
        if (!$aartistinfo) {
            $this->flash->error("a artist info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }
        $aartistinfo->ID = $this->request->getPost("ID");
        $aartistinfo->ARTIST_NAME = $this->request->getPost("ARTIST_NAME");
        $aartistinfo->ARTIST_EN_NAME = $this->request->getPost("ARTIST_EN_NAME");
        $aartistinfo->ARTIST_SPELL = $this->request->getPost("ARTIST_SPELL");
        $aartistinfo->ARTIST_AREA = $this->request->getPost("ARTIST_AREA");
        $aartistinfo->ARTIST_TYPE = $this->request->getPost("ARTIST_TYPE");
        $aartistinfo->IS_VISIBLE = $this->request->getPost("IS_VISIBLE");
        $aartistinfo->ARTIST_OCCUPATION = $this->request->getPost("ARTIST_OCCUPATION");
        $aartistinfo->ARTIST_DESC = $this->request->getPost("ARTIST_DESC");
        $aartistinfo->ARTIST_IMAGE_URL = $this->request->getPost("ARTIST_IMAGE_URL");
        $aartistinfo->ARTIST_BIRTHDAY = $this->request->getPost("ARTIST_BIRTHDAY");
        $aartistinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $aartistinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$aartistinfo->save()) {
            foreach ($aartistinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "edit", "params" => array($aartistinfo->ID)));
        } else {
            $this->flash->success("a artist info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $aartistinfo = AArtistInfo::findFirst('ID="'.$ID.'"');
        if (!$aartistinfo) {
            $this->flash->error("a artist info was not found");
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }

        if (!$aartistinfo->delete()) {
            foreach ($aartistinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "search"));
        } else {
            $this->flash->success("a artist info was deleted");
            return $this->dispatcher->forward(array("controller" => "aartistinfo", "action" => "index"));
        }
    }

}
