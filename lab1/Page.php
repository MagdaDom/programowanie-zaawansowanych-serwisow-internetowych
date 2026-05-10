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

    public function __construct() //we use __constract instead of class name!!!
    {
        $this->title = $this->passTitle();
        $this->tableName = $this->passTableName(); 
    }

    abstract protected function passTitle(): string; //abstract function don't have a body
    abstract protected function passTableName(): string; //type of value returned by function is added after function definition, can be multiple like string | int;
    protected abstract function generateViewAll(): string;    
    protected abstract function generateViewAdd(): string;
    protected abstract function generateViewEdit(): string;
    protected abstract function edit(): void;
    protected abstract function addNew(): void;    
    protected abstract function enterModelDataFromForm(): void;


    protected static function openConnection(): PDO 
    {
        return new PDO("mysql:host=localhost;dbname=phpadvanced", "root");
    }

    protected function delete(): void {

        try {
            $id = (int)$_POST["Id"];

            $sql = "UPDATE $this->tableName SET IsActive=0 WHERE Id=:id";

            $db = $this->openConnection();

            $statement = $db->prepare($sql);
            $statement->bindParam(":id", $id, PDO::PARAM_INT);
            $statement->execute();

            $sql = "SELECT * FROM $this->tableName WHERE IsActive=1";

            $result = $db->query($sql);
        } catch(Exception $e) {
            echo $e;
        }
    }

    public function initialize(): void
    {
        echo $this->generateHeader();
        print_r($_POST);
        echo "";

        switch ($_POST[self::ACTION] ?? null) {
            case self::ADD_NEW:
                $this->addNew();
                echo $this->generateViewAll();
                break;
            case self::CREATE_VIEW:
                echo $this->generateViewAdd();
                break;
            case self::DELETE:
                $this->delete();
                echo $this->generateViewAll();
                break;
            case self::EDIT:
                $this->edit();
                echo $this->generateViewAll();
                break;
            case self::EDIT_VIEW:
                echo $this->generateViewEdit();
                break;
            default:
                echo $this->generateViewAll();
                break;
        }
        echo $this->generateFooter();
    }

    public function generateHeader(): string 
    {
        return '<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Internal Events - All
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Internal Events - All</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form method="POST">
                    <button type="submit" name="'.self::ACTION.'" value="'.self::CREATE_VIEW.'" class="btn btn-primary">Create new</button>
                    <button type="submit" name="ACTION" value="" class="btn btn-primary">All</button>
                </form>
            </div>
        </div>
    </div>
    <hr>';
    }

    public function generateFooter(): string {
        return '<script src="js/bootstrap.min.js"></script>
</body>

</html>';
    }
}

