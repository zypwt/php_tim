<?php

use \Phalcon\Tag as Tag;

class ArtistImagesController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ArtistImages", $_POST);
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

        $artistimages = ArtistImages::find($parameters);
        if (count($artistimages) == 0) {
            $this->flash->notice("The search did not find any artist images");
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $artistimages,
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

            $artistimages = ArtistImages::findFirst('ID="'.$ID.'"');
            if (!$artistimages) {
                $this->flash->error("artist images was not found");
                return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
            }
            $this->view->setVar("ID", $artistimages->ID);
        
            Tag::displayTo("ID", $artistimages->ID);
            Tag::displayTo("ARTIST_ID", $artistimages->ARTIST_ID);
            Tag::displayTo("TOTAL", $artistimages->TOTAL);
            Tag::displayTo("IMAGE_LIST", $artistimages->IMAGE_LIST);
            Tag::displayTo("CREATE_TIME", $artistimages->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $artistimages->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

        $artistimages = new ArtistImages();
        $artistimages->ID = $this->request->getPost("ID");
        $artistimages->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistimages->TOTAL = $this->request->getPost("TOTAL");
        $artistimages->IMAGE_LIST = $this->request->getPost("IMAGE_LIST");
        $artistimages->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistimages->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$artistimages->save()) {
            foreach ($artistimages->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "new"));
        } else {
            $this->flash->success("artist images was created successfully");
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $artistimages = ArtistImages::findFirst("ID='$ID'");
        if (!$artistimages) {
            $this->flash->error("artist images does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }
        $artistimages->ID = $this->request->getPost("ID");
        $artistimages->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistimages->TOTAL = $this->request->getPost("TOTAL");
        $artistimages->IMAGE_LIST = $this->request->getPost("IMAGE_LIST");
        $artistimages->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistimages->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$artistimages->save()) {
            foreach ($artistimages->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "edit", "params" => array($artistimages->ID)));
        } else {
            $this->flash->success("artist images was updated successfully");
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $artistimages = ArtistImages::findFirst('ID="'.$ID.'"');
        if (!$artistimages) {
            $this->flash->error("artist images was not found");
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }

        if (!$artistimages->delete()) {
            foreach ($artistimages->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "search"));
        } else {
            $this->flash->success("artist images was deleted");
            return $this->dispatcher->forward(array("controller" => "artistimages", "action" => "index"));
        }
    }

}
