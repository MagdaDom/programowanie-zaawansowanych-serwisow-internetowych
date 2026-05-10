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
           return '
           <form method="POST">
 <div class="container">
        <div class="row gy-3">
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">label</i>
                        Title
                    </label>
                    <input name="Title" class="form-control validate">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">link</i>
                        Link
                    </label>
                    <input name="Link" class="form-control validate">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            Public
                            <i class="material-icons-round align-middle">public</i>
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsPublic" class="form-check-input validate" type="checkbox">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">block</i>
                            Private
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            Cancelled
                            <i class="material-icons-round align-middle">cancel</i>
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsCancelled" class="form-check-input validate" type="checkbox">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">public</i>
                            Active
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round palette-accent-text-color align-middle">event</i>
                        Event date
                    </label>
                    <input name="EventDate" class="form-control validate" type="date">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round palette-accent-text-color align-middle">today</i>
                        Publish date
                    </label>
                    <input name="PublishDate" class="form-control validate" type="date">
                </div>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">description</i>
                    Short description
                </label>
                <textarea name="ShortDescription" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">newspaper</i>
                    Content
                </label>
                <textarea name="Content" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">feed</i>
                    Meta description
                </label>
                <textarea name="MetaDescription" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">subtitles</i>
                    Meta tags
                </label>
                <textarea name="MetaTags" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">notes</i>
                    Notes
                </label>
                <textarea name="Notes" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <button type="submit" name="'.self::ACTION.'" value="'.self::ADD_NEW.'" class="btn btn-primary">Create </button>
            </div>
        </div>
    </div>
    </form>
    ';
    }
    function generateViewEdit(): string 
    {
        return "";
    }
    function edit(): void {}
    function addNew(): void {
            $db = $this->openConnection();
            $now = date('Y-m-d H:i:s');

            $title = $_POST["Title"] ?? null;
            $link = $_POST["Link"] ?? null;
            $isPublic = isset($_POST['IsPublic']) ? 1 : 0;
            $isCancelled = isset($_POST['IsCancelled']) ? 1 : 0;
            $eventDate = $_POST['EventDate'];
            $publishDate = $_POST['PublishDate'];
            $shortDescription = $_POST['ShortDescription'];
            $content = $_POST['Content'];
            $metaDescription = $_POST['MetaDescription'];
            $metaTags = $_POST['MetaTags'];
            $notes = $_POST['Notes'];

            $statement = $db->prepare("
            INSERT INTO InternalEvents (Title, Link, IsPublic, IsCancelled, EventDateTime, CreationDateTime, EditDateTime, PublishDateTime, ShortDescription, ContentHTML, MetaDescription, MetaTags, Notes, IsActive)
            VALUES(:Title, :Link, :IsPublic, :IsCancelled, :EventDateTime, NOW(), NOW(), :PublishDateTime, :ShortDescription, :ContentHTML, :MetaDescription, :MetaTags, :Notes, 1)
            ");
            $statement->execute([
                'Title'=> $title,
                'Link'=> $link,
                'IsPublic'=> $isPublic,
                'IsCancelled' => $isCancelled,
                'EventDateTime' => $eventDate,
                'PublishDateTime' => $publishDate,
                'ShortDescription' => $shortDescription,
                'ContentHTML' => $content,
                'MetaDescription' => $metaDescription,
                'MetaTags' => $metaTags,
                'Notes' => $notes
            ]);

            $sql = "SELECT * FROM $this->tableName WHERE IsActive=1";

            $result = $db->query($sql);
        
    }
    function enterModelDataFromForm(): void {}
} 