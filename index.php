<?php
include_once "Page.php";
include_once "Model.php";
include_once "InternalEvent.php";
include_once "InternalEventsPage.php";
include_once "Task.php";
include_once "TasksPage.php";

if (isset($_GET["page"]) && $_GET["page"] == "tasks") {
    $page = new TasksPage();
    $page->initialize();
} else if (isset($_GET["page"]) && $_GET["page"] == "internal-events") {
    $page = new InternalEventsPage();
    $page->initialize();
} else {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <title>PHP Advanced</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container">
            <h1>PHP Advanced</h1>
            <hr>
            <div class="row gy-3">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a href="?page=internal-events" style="text-decoration:none">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title h5 text-black">Internal Events</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a href="?page=tasks" style="text-decoration:none">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title h5 text-black">Tasks</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <script src="js/bootstrap.min.js"></script>
    </body>
    </html>';
}