<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke() {
        return '
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Internal Events - All</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>Laravel page</h1>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row gy-3">
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <a href="/internal-events" style="text-decoration:none">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title h5 text-black clearfix">Internal events</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <script src="/js/bootstrap.min.js"></script>
    </body>
</html>';
    }

    public function index(){
        return view("home.index");
    }
}
