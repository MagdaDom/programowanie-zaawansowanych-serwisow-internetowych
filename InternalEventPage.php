<?php 
require_once 'Page.php';

class InternalEventPage extends Page {
    function passTitle(): string 
    {
        return "";
    }

    function generateViewAll(): string 
    {
        return "";
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