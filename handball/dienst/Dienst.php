<?php

require_once __DIR__."/Dienstart.php";
require_once __DIR__."/../Mannschaft.php";
require_once __DIR__."/../spielbetrieb/Spiel.php";

class Dienst {
    public int $id;
    public Spiel $spiel;
    public string $dienstart;
    public ?Mannschaft $mannschaft;
}
?>