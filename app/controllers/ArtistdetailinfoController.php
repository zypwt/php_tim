<?php

use \Phalcon\Tag as Tag;

class ArtistDetailInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ArtistDetailInfo", $_POST);
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

        $artistdetailinfo = ArtistDetailInfo::find($parameters);
        if (count($artistdetailinfo) == 0) {
            $this->flash->notice("The search did not find any artist detail info");
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $artistdetailinfo,
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

            $artistdetailinfo = ArtistDetailInfo::findFirst('ID="'.$ID.'"');
            if (!$artistdetailinfo) {
                $this->flash->error("artist detail info was not found");
                return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
            }
            $this->view->setVar("ID", $artistdetailinfo->ID);
        
            Tag::displayTo("ID", $artistdetailinfo->ID);
            Tag::displayTo("ARTIST_ID", $artistdetailinfo->ARTIST_ID);
            Tag::displayTo("ARTIST_DESC", $artistdetailinfo->ARTIST_DESC);
            Tag::displayTo("CREATE_TIME", $artistdetailinfo->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $artistdetailinfo->UPDATE_TIME);
            Tag::displayTo("ARTIST_DETAIL_DESC", $artistdetailinfo->ARTIST_DETAIL_DESC);
            Tag::displayTo("ARTIST_OTHER_PROPERTY", $artistdetailinfo->ARTIST_OTHER_PROPERTY);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

        $artistdetailinfo = new ArtistDetailInfo();
        $artistdetailinfo->ID = $this->request->getPost("ID");
        $artistdetailinfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistdetailinfo->ARTIST_DESC = $this->request->getPost("ARTIST_DESC");
        $artistdetailinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistdetailinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $artistdetailinfo->ARTIST_DETAIL_DESC = $this->request->getPost("ARTIST_DETAIL_DESC");
        $artistdetailinfo->ARTIST_OTHER_PROPERTY = $this->request->getPost("ARTIST_OTHER_PROPERTY");
        if (!$artistdetailinfo->save()) {
            foreach ($artistdetailinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "new"));
        } else {
            $this->flash->success("artist detail info was created successfully");
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $artistdetailinfo = ArtistDetailInfo::findFirst("ID='$ID'");
        if (!$artistdetailinfo) {
            $this->flash->error("artist detail info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }
        $artistdetailinfo->ID = $this->request->getPost("ID");
        $artistdetailinfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistdetailinfo->ARTIST_DESC = $this->request->getPost("ARTIST_DESC");
        $artistdetailinfo->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistdetailinfo->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        $artistdetailinfo->ARTIST_DETAIL_DESC = $this->request->getPost("ARTIST_DETAIL_DESC");
        $artistdetailinfo->ARTIST_OTHER_PROPERTY = $this->request->getPost("ARTIST_OTHER_PROPERTY");
        if (!$artistdetailinfo->save()) {
            foreach ($artistdetailinfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "edit", "params" => array($artistdetailinfo->ID)));
        } else {
            $this->flash->success("artist detail info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $artistdetailinfo = ArtistDetailInfo::findFirst('ID="'.$ID.'"');
        if (!$artistdetailinfo) {
            $this->flash->error("artist detail info was not found");
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }

        if (!$artistdetailinfo->delete()) {
            foreach ($artistdetailinfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "search"));
        } else {
            $this->flash->success("artist detail info was deleted");
            return $this->dispatcher->forward(array("controller" => "artistdetailinfo", "action" => "index"));
        }
    }

}
