<?php

use \Phalcon\Tag as Tag;

class ArtistItemInfoController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ArtistItemInfo", $_POST);
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

        $artistiteminfo = ArtistItemInfo::find($parameters);
        if (count($artistiteminfo) == 0) {
            $this->flash->notice("The search did not find any artist item info");
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $artistiteminfo,
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

            $artistiteminfo = ArtistItemInfo::findFirst('ID="'.$ID.'"');
            if (!$artistiteminfo) {
                $this->flash->error("artist item info was not found");
                return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
            }
            $this->view->setVar("ID", $artistiteminfo->ID);
        
            Tag::displayTo("ID", $artistiteminfo->ID);
            Tag::displayTo("ITEM_ID", $artistiteminfo->ITEM_ID);
            Tag::displayTo("ARTIST_ID", $artistiteminfo->ARTIST_ID);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

        $artistiteminfo = new ArtistItemInfo();
        $artistiteminfo->ID = $this->request->getPost("ID");
        $artistiteminfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $artistiteminfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        if (!$artistiteminfo->save()) {
            foreach ($artistiteminfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "new"));
        } else {
            $this->flash->success("artist item info was created successfully");
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $artistiteminfo = ArtistItemInfo::findFirst("ID='$ID'");
        if (!$artistiteminfo) {
            $this->flash->error("artist item info does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }
        $artistiteminfo->ID = $this->request->getPost("ID");
        $artistiteminfo->ITEM_ID = $this->request->getPost("ITEM_ID");
        $artistiteminfo->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        if (!$artistiteminfo->save()) {
            foreach ($artistiteminfo->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "edit", "params" => array($artistiteminfo->ID)));
        } else {
            $this->flash->success("artist item info was updated successfully");
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $artistiteminfo = ArtistItemInfo::findFirst('ID="'.$ID.'"');
        if (!$artistiteminfo) {
            $this->flash->error("artist item info was not found");
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }

        if (!$artistiteminfo->delete()) {
            foreach ($artistiteminfo->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "search"));
        } else {
            $this->flash->success("artist item info was deleted");
            return $this->dispatcher->forward(array("controller" => "artistiteminfo", "action" => "index"));
        }
    }

}
