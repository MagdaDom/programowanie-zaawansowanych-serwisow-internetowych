<?php 
require_once 'Page.php';

class InternalEventPage extends Page {
    function passTitle(): string 
    {
        return "";
    }

    function passTableName(): string {
        return "internalevents";
    }

    public function generateViewAll(): string 
    {
        $db = $this->openConnection();

        $sql = "SELECT * FROM $this->tableName WHERE IsActive=1";

        $result = $db->query($sql);

        $views = [];        

        foreach($result as $row) {
            $views[] = '<div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title h5">'. $row["Title"] .'</p>
                        <p><strong>'. $row["ShortDescription"] .'</strong></p>
                        '. $row["Notes"] .'
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Edit</button>

                        <form method="POST">
                            <input name="Id" value="'. $row["Id"] .'">
                            <button type="submit" name="'.self::ACTION.'" value="'.self::DELETE.'" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>';
        }

        $html = '<div class="container"><div class="row gy-3">'. implode('', $views) . '</div></div>';

        $db=null;

        return $html;
    }


    function generateViewAdd(): string 
    {
        return "";
    }
    function generateViewEdit(): string 
    {
        return "";
    }
    function edit(): void {}
    function addNew(): void {}
    function enterModelDataFromForm(): void {}
} 