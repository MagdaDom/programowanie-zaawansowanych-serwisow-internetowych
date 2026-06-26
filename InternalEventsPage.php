<?php
include_once "Page.php";
include_once "InternalEvent.php";

class InternalEventsPage extends Page
{
    private InternalEvent $model;

    public function getModel() {
        return $this->model;
    }

    public function setModel() {
        $this->model = $model;
        return $this;
    }

    protected function passTitle(): string
    {
        return "Internal Events";
    }

    protected function passTableName(): string
    {
        return "InternalEvents";
    }

    protected function enterModelDataFromForm(): void
    {
        $this->model = new InternalEvent();

        $this->model->setId(intval($_POST["Id"] ?? 0));
        $this->model->setTitle($_POST["Title"] ?? "");
        $this->model->setLink($_POST["Link"] ?? "");
        $this->model->setIsPublic(isset($_POST["IsPublic"]));
        $this->model->setIsCancelled(isset($_POST["IsCancelled"]));
        $this->model->setEventDateTime($_POST["EventDateTime"] ?? "");
        $this->model->setPublishDateTime($_POST["PublishDateTime"] ?? "");
        $this->model->setShortDescription($_POST["ShortDescription"] ?? "");
        $this->model->setContentHTML($_POST["ContentHTML"] ?? "");
        $this->model->setMetaDescription($_POST["MetaDescription"] ?? "");
        $this->model->setMetaTags($_POST["MetaTags"] ?? "");
        $this->model->setNotes($_POST["Notes"] ?? "");
        $this->model->setIsActive(true);
    }

    protected function addNew(): void
    {
        $query = self::openConnection()->prepare("
            INSERT INTO InternalEvents
            (
                Title, Link, IsPublic, IsCancelled,
                EventDateTime, PublishDateTime,
                ShortDescription, ContentHTML,
                MetaDescription, MetaTags,
                CreationDateTime, EditDateTime,
                Notes, IsActive
            )
            VALUES
            (
                :Title, :Link, :IsPublic, :IsCancelled,
                :EventDateTime, :PublishDateTime,
                :ShortDescription, :ContentHTML,
                :MetaDescription, :MetaTags,
                NOW(), NOW(),
                :Notes, 1
            )
        ");

        $query->execute([
            ":Title" => $this->model->getTitle(),
            ":Link" => $this->model->getLink(),
            ":IsPublic" => $this->model->getIsPublic() ? 1 : 0,
            ":IsCancelled" => $this->model->getIsCancelled() ? 1 : 0,
            ":EventDateTime" => $this->model->getEventDateTime(),
            ":PublishDateTime" => $this->model->getPublishDateTime(),
            ":ShortDescription" => $this->model->getShortDescription(),
            ":ContentHTML" => $this->model->getContentHTML(),
            ":MetaDescription" => $this->model->getMetaDescription(),
            ":MetaTags" => $this->model->getMetaTags(),
            ":Notes" => $this->model->getNotes()
        ]);
    }

    protected function edit(): void
    {
        $query = self::openConnection()->prepare("
            UPDATE InternalEvents SET
                Title = :Title,
                Link = :Link,
                IsPublic = :IsPublic,
                IsCancelled = :IsCancelled,
                EventDateTime = :EventDateTime,
                PublishDateTime = :PublishDateTime,
                ShortDescription = :ShortDescription,
                ContentHTML = :ContentHTML,
                MetaDescription = :MetaDescription,
                MetaTags = :MetaTags,
                EditDateTime = NOW(),
                Notes = :Notes
            WHERE Id = :Id
        ");

        $query->execute([
            ":Id" => $this->model->getId(),
            ":Title" => $this->model->getTitle(),
            ":Link" => $this->model->getLink(),
            ":IsPublic" => $this->model->getIsPublic() ? 1 : 0,
            ":IsCancelled" => $this->model->getIsCancelled() ? 1 : 0,
            ":EventDateTime" => $this->model->getEventDateTime(),
            ":PublishDateTime" => $this->model->getPublishDateTime(),
            ":ShortDescription" => $this->model->getShortDescription(),
            ":ContentHTML" => $this->model->getContentHTML(),
            ":MetaDescription" => $this->model->getMetaDescription(),
            ":MetaTags" => $this->model->getMetaTags(),
            ":Notes" => $this->model->getNotes()
        ]);
    }
}