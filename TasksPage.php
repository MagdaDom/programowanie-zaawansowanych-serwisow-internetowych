<?php
include_once "Page.php";
include_once "Task.php";

class TasksPage extends Page
{
    private Task $model;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    protected function passTitle(): string
    {
        return "Tasks";
    }

    protected function passTableName(): string
    {
        return "Tasks";
    }

    protected function enterModelDataFromForm(): void
    {
        $this->setModel(new Task(
            intval($_POST["Id"] ?? "0"),
            $_POST["Title"] ?? "null",
            boolval($_POST["IsDone"] ?? "0"),
            $_POST["StartDateTime"] ?? "null",
            $_POST["Description"] ?? "null",
            $_POST["Deadline"] ?? "null",
            intval($_POST["InternalEventId"] ?? "0"),
            $_POST["CreationDateTime"] ?? "null",
            $_POST["EditDateTime"] ?? "null",
            $_POST["Notes"] ?? "null",
            boolval($_POST["IsActive"] ?? "1")
        ));
    }

    protected function addNew(): void
    {
        $query = "INSERT INTO " . $this->getTableName() . "
            (
                Title, IsDone, StartDateTime, Description, Deadline,
                InternalEventId, CreationDateTime, EditDateTime, Notes, IsActive
            )
            VALUES
            (
                :Title, :IsDone, :StartDateTime, :Description, :Deadline,
                :InternalEventId, CURDATE(), CURDATE(), :Notes, 1
            )";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":IsDone", $this->getModel()->getIsDone(), PDO::PARAM_BOOL);
        $query->bindValue(":StartDateTime", $this->getModel()->getStartDateTime());
        $query->bindValue(":Description", $this->getModel()->getDescription());
        $query->bindValue(":Deadline", $this->getModel()->getDeadline());
        $query->bindValue(":InternalEventId", $this->getModel()->getInternalEventId(), PDO::PARAM_INT);
        $query->bindValue(":Notes", $this->getModel()->getNotes());

        $query->execute();
    }

    protected function edit(): void
    {
        $query = "UPDATE " . $this->getTableName() . "
            SET
                Title = :Title,
                IsDone = :IsDone,
                StartDateTime = :StartDateTime,
                Description = :Description,
                Deadline = :Deadline,
                InternalEventId = :InternalEventId,
                EditDateTime = CURDATE(),
                Notes = :Notes
            WHERE Id = :Id";

        $query = self::openConnection()->prepare($query);

        $query->bindValue(":Id", $this->getModel()->getId(), PDO::PARAM_INT);
        $query->bindValue(":Title", $this->getModel()->getTitle());
        $query->bindValue(":IsDone", $this->getModel()->getIsDone(), PDO::PARAM_BOOL);
        $query->bindValue(":StartDateTime", $this->getModel()->getStartDateTime());
        $query->bindValue(":Description", $this->getModel()->getDescription());
        $query->bindValue(":Deadline", $this->getModel()->getDeadline());
        $query->bindValue(":InternalEventId", $this->getModel()->getInternalEventId(), PDO::PARAM_INT);
        $query->bindValue(":Notes", $this->getModel()->getNotes());

        $query->execute();
    }

    protected function generateViewAdd(): string
    {
        $events = self::openConnection()
            ->query("SELECT Id, Title FROM InternalEvents WHERE IsActive = 1")
            ->fetchAll(PDO::FETCH_ASSOC);

        $options = "";
        foreach ($events as $event) {
            $options .= '<option value="' . $event["Id"] . '">' . htmlspecialchars($event["Title"]) . '</option>';
        }

        return '<div class="container">
            <form method="POST">
                <div class="row gy-3">

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Title</label>
                        <input name="Title" class="form-control">
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Internal event</label>
                        <select name="InternalEventId" class="form-control">
                            ' . $options . '
                        </select>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Start date</label>
                        <input name="StartDateTime" type="date" class="form-control">
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Deadline</label>
                        <input name="Deadline" type="date" class="form-control">
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea name="Description" class="form-control"></textarea>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">Notes</label>
                        <textarea name="Notes" class="form-control"></textarea>
                    </div>

                    <div class="col-sm-12">
                        <input name="IsDone" type="checkbox" class="form-check-input">
                        <label class="form-check-label">Done</label>
                    </div>

                    <div class="col-sm-12">
                        <button name="' . self::ACTION . '" value="' . self::ADD_NEW . '" class="btn btn-primary">
                            Create
                        </button>
                    </div>

                </div>
            </form>
        </div>';
    }

    protected function generateViewEdit(): string
    {
        if (!isset($_POST["Id"])) {
            return "";
        }

        $query = self::openConnection()->prepare(
            "SELECT * FROM " . $this->getTableName() . " WHERE Id = :Id"
        );
        $query->bindValue(":Id", $_POST["Id"], PDO::PARAM_INT);
        $query->execute();
        $model = $query->fetch(PDO::FETCH_ASSOC);

        $events = self::openConnection()
            ->query("SELECT Id, Title FROM InternalEvents WHERE IsActive = 1")
            ->fetchAll(PDO::FETCH_ASSOC);

        $options = "";
        foreach ($events as $event) {
            $selected = $model["InternalEventId"] == $event["Id"] ? "selected" : "";
            $options .= '<option value="' . $event["Id"] . '" ' . $selected . '>' . htmlspecialchars($event["Title"]) . '</option>';
        }

        return '<div class="container">
            <form method="POST">
                <input type="hidden" name="Id" value="' . $model["Id"] . '">

                <div class="row gy-3">

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Title</label>
                        <input name="Title" value="' . htmlspecialchars($model["Title"]) . '" class="form-control">
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Internal event</label>
                        <select name="InternalEventId" class="form-control">
                            ' . $options . '
                        </select>
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Start date</label>
                        <input name="StartDateTime" type="date" value="' . date("Y-m-d", strtotime($model["StartDateTime"])) . '" class="form-control">
                    </div>

                    <div class="col-md-12 col-lg-6">
                        <label class="form-label">Deadline</label>
                        <input name="Deadline" type="date" value="' . date("Y-m-d", strtotime($model["Deadline"])) . '" class="form-control">
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">Description</label>
                        <textarea name="Description" class="form-control">' . htmlspecialchars($model["Description"]) . '</textarea>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label">Notes</label>
                        <textarea name="Notes" class="form-control">' . htmlspecialchars($model["Notes"] ?? "") . '</textarea>
                    </div>

                    <div class="col-sm-12">
                        <input name="IsDone" type="checkbox" class="form-check-input" ' . ($model["IsDone"] ? "checked" : "") . '>
                        <label class="form-check-label">Done</label>
                    </div>

                    <div class="col-sm-12">
                        <button name="' . self::ACTION . '" value="' . self::EDIT . '" class="btn btn-primary">
                            Edit
                        </button>
                    </div>

                </div>
            </form>
        </div>';
    }

    protected function generateViewAll(): string
    {
        $query = self::openConnection()->prepare(
            "SELECT 
                Tasks.*,
                InternalEvents.Title AS InternalEventTitle
            FROM Tasks
            INNER JOIN InternalEvents ON Tasks.InternalEventId = InternalEvents.Id
            WHERE Tasks.IsActive = 1
            ORDER BY Tasks.Deadline ASC"
        );

        $query->execute();

        $result = '<div class="container">
            <div class="row g-3">';

        while ($model = $query->fetch(PDO::FETCH_ASSOC)) {
            $result .= '
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">

                        <p class="card-title h5">' . htmlspecialchars($model["Title"]) . '</p>

                        <p>
                            <strong>Internal event:</strong>
                            ' . htmlspecialchars($model["InternalEventTitle"]) . '
                        </p>

                        <p><strong>Done:</strong> ' . ($model["IsDone"] ? "Yes" : "No") . '</p>
                        <p><strong>Start:</strong> ' . htmlspecialchars($model["StartDateTime"]) . '</p>
                        <p><strong>Deadline:</strong> ' . htmlspecialchars($model["Deadline"]) . '</p>
                        <p><strong>Description:</strong> ' . htmlspecialchars($model["Description"]) . '</p>
                        <p><strong>Notes:</strong> ' . htmlspecialchars($model["Notes"] ?? "") . '</p>

                    </div>

                    <div class="card-footer">

                        <form method="POST" style="display:inline">
                            <input type="hidden" name="Id" value="' . $model["Id"] . '">

                            <button
                                class="btn btn-primary"
                                name="' . self::ACTION . '"
                                value="' . self::EDIT_VIEW . '">
                                Edit
                            </button>
                        </form>

                        <form method="POST" style="display:inline">
                            <input type="hidden" name="Id" value="' . $model["Id"] . '">

                            <button
                                class="btn btn-danger"
                                name="' . self::ACTION . '"
                                value="' . self::DELETE . '">
                                Delete
                            </button>
                        </form>

                    </div>
                </div>
            </div>';
        }

        $result .= '
            </div>
        </div>';

        return $result;
    }
}