<?php
include_once "Page.php";
include_once "Model.php";
include_once "InternalEvent.php";
include_once "InternalEventsPage.php";
include_once "Task.php";
include_once "TasksPage.php";

$page = new TasksPage();
$page->initialize();

//$page = new InternalEventsPage();
//$page->initialize();