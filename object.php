<?php

abstract class Page {

    const ACTION = "action";
    const ADD_NEW = "add_new";
    const EDIT = "edit";
    const CREATE_VIEW = "create_view";
    const EDIT_VIEW = "edit_view";
    const DELETE = "delete";

    protected string $title;
    protected string $tableName;

    abstract protected function passTitle(); //abstract function don't have a body
    abstract protected function passTableName();

    public function --construct() {
        $this->title = $this->passTitle();
        $this->tableName = $this->passTableName(); 
    }
}