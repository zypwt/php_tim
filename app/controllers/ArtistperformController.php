<?php

use \Phalcon\Tag as Tag;

class ArtistPerformController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ArtistPerform", $_POST);
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

        $artistperform = ArtistPerform::find($parameters);
        if (count($artistperform) == 0) {
            $this->flash->notice("The search did not find any artist perform");
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $artistperform,
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

            $artistperform = ArtistPerform::findFirst('ID="'.$ID.'"');
            if (!$artistperform) {
                $this->flash->error("artist perform was not found");
                return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
            }
            $this->view->setVar("ID", $artistperform->ID);
        
            Tag::displayTo("ID", $artistperform->ID);
            Tag::displayTo("ARTIST_ID", $artistperform->ARTIST_ID);
            Tag::displayTo("ONLINE_ID", $artistperform->ONLINE_ID);
            Tag::displayTo("CREATE_TIME", $artistperform->CREATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

        $artistperform = new ArtistPerform();
        $artistperform->ID = $this->request->getPost("ID");
        $artistperform->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistperform->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $artistperform->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$artistperform->save()) {
            foreach ($artistperform->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "new"));
        } else {
            $this->flash->success("artist perform was created successfully");
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $artistperform = ArtistPerform::findFirst("ID='$ID'");
        if (!$artistperform) {
            $this->flash->error("artist perform does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }
        $artistperform->ID = $this->request->getPost("ID");
        $artistperform->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistperform->ONLINE_ID = $this->request->getPost("ONLINE_ID");
        $artistperform->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        if (!$artistperform->save()) {
            foreach ($artistperform->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "edit", "params" => array($artistperform->ID)));
        } else {
            $this->flash->success("artist perform was updated successfully");
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $artistperform = ArtistPerform::findFirst('ID="'.$ID.'"');
        if (!$artistperform) {
            $this->flash->error("artist perform was not found");
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }

        if (!$artistperform->delete()) {
            foreach ($artistperform->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "search"));
        } else {
            $this->flash->success("artist perform was deleted");
            return $this->dispatcher->forward(array("controller" => "artistperform", "action" => "index"));
        }
    }

}
