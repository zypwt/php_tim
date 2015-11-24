<?php

use \Phalcon\Tag as Tag;

class ArtistPropertyController extends ControllerBase
    {

    function indexAction()
    {
        $this->session->conditions = null;
    }

    public function searchAction()
{

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = \Phalcon\Mvc\Model\Criteria::fromInput($this->di, "ArtistProperty", $_POST);
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

        $artistproperty = ArtistProperty::find($parameters);
        if (count($artistproperty) == 0) {
            $this->flash->notice("The search did not find any artist property");
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

        $paginator = new \Phalcon\Paginator\Adapter\Model(array(
            "data" => $artistproperty,
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

            $artistproperty = ArtistProperty::findFirst('ID="'.$ID.'"');
            if (!$artistproperty) {
                $this->flash->error("artist property was not found");
                return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
            }
            $this->view->setVar("ID", $artistproperty->ID);
        
            Tag::displayTo("ID", $artistproperty->ID);
            Tag::displayTo("ARTIST_ID", $artistproperty->ARTIST_ID);
            Tag::displayTo("PROPERTY_NAME", $artistproperty->PROPERTY_NAME);
            Tag::displayTo("CREATE_TIME", $artistproperty->CREATE_TIME);
            Tag::displayTo("UPDATE_TIME", $artistproperty->UPDATE_TIME);
        }
    }

    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

        $artistproperty = new ArtistProperty();
        $artistproperty->ID = $this->request->getPost("ID");
        $artistproperty->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistproperty->PROPERTY_NAME = $this->request->getPost("PROPERTY_NAME");
        $artistproperty->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistproperty->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$artistproperty->save()) {
            foreach ($artistproperty->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "new"));
        } else {
            $this->flash->success("artist property was created successfully");
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

    }

    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

        $ID = $this->request->getPost("ID", "int");
        $artistproperty = ArtistProperty::findFirst("ID='$ID'");
        if (!$artistproperty) {
            $this->flash->error("artist property does not exist ".$ID);
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }
        $artistproperty->ID = $this->request->getPost("ID");
        $artistproperty->ARTIST_ID = $this->request->getPost("ARTIST_ID");
        $artistproperty->PROPERTY_NAME = $this->request->getPost("PROPERTY_NAME");
        $artistproperty->CREATE_TIME = $this->request->getPost("CREATE_TIME");
        $artistproperty->UPDATE_TIME = $this->request->getPost("UPDATE_TIME");
        if (!$artistproperty->save()) {
            foreach ($artistproperty->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "edit", "params" => array($artistproperty->ID)));
        } else {
            $this->flash->success("artist property was updated successfully");
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

    }

    public function deleteAction($ID){

        $ID = $this->filter->sanitize($ID, array("int"));

        $artistproperty = ArtistProperty::findFirst('ID="'.$ID.'"');
        if (!$artistproperty) {
            $this->flash->error("artist property was not found");
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }

        if (!$artistproperty->delete()) {
            foreach ($artistproperty->getMessages() as $message){
                $this->flash->error((string) $message);
            }
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "search"));
        } else {
            $this->flash->success("artist property was deleted");
            return $this->dispatcher->forward(array("controller" => "artistproperty", "action" => "index"));
        }
    }

}
