<?php

require_once __DIR__."/MannschaftsMeldung.php";
require_once __DIR__."/dienst/Dienst.php";
require_once __DIR__."/../zeit/ZeitRaum.php";
require_once __DIR__."/../zeit/ZeitlicheDistanz.php";

class Spiel{

    const VORBEREITUNG_VOR_ANWURF = "PT60M";
    const SPIELDAUER              = "PT90M";
    const NACHBEREITUNG_NACH_ENDE = "PT60M";
    const FAHRTZEIT_AUSWAERTS     = "PT60M";

    public int $id;
    
    public int $spielNr;
    public MannschaftsMeldung $heim;
    public MannschaftsMeldung $gast;

    public ?DateTime $anwurf;
    public int $halle;
    
    // TODO prüfen: kann auf diese Referenz verzichtet werden?
    public array $dienste = array();
    
    // Zuweisung von Diensten
    public function getDienst(string $dienstart): ?Dienst{
        if(array_key_exists($dienstart, $this->dienste)){
            return $this->dienste[$dienstart];
        }
        return null;
    }

    public function isHeimspiel(): bool{
        return $this->heim->mannschaft->heimVerein;
    }

    // Zeitfunktionen 
    public function getSpielEnde(): ?DateTime {
        if(empty($this->anwurf)){
            return null;
        }
        $anwurfCopy = clone $this->anwurf;
        return $anwurfCopy->add(new DateInterval(self::SPIELDAUER));
    }
    
    public function getSpielzeit(): ?ZeitRaum {
        if(empty($this->anwurf)){
            return null;
        }
        return new Zeitraum($this->anwurf, $this->getSpielEnde());
    }
    
    public function getAbfahrt(): ?DateTime {
        if(empty($this->anwurf)){
            return null;
        }
        $anwurfCopy = clone $this->anwurf;
        $abfahrt = $anwurfCopy->sub(new DateInterval(self::VORBEREITUNG_VOR_ANWURF));
        if(!$this->isHeimspiel()){
            $abfahrt->sub(new DateInterval(self::FAHRTZEIT_AUSWAERTS));
        }
        return $abfahrt;
    }

    public function getRueckkehr(): ?DateTime {
        if(empty($this->anwurf)){
            return null;
        }
        $rueckkehr = $this->getSpielEnde()->add(new DateInterval(self::NACHBEREITUNG_NACH_ENDE));
        if(!$this->isHeimspiel()){
            $rueckkehr = $rueckkehr->add(new DateInterval(self::FAHRTZEIT_AUSWAERTS));
        }
        return $rueckkehr;
    }

    public function getAbwesenheitsZeitraum(): ?ZeitRaum {
        if(empty($this->anwurf)){
            return null;
        }
        return new ZeitRaum($this->getAbfahrt(), $this->getRueckkehr());
    }

    public function calculate_distanz_to(Spiel $other): ?ZeitlicheDistanz {

        $eigenesSpiel = $this->getAbwesenheitsZeitraum();
        $anderesSpiel = $other->getAbwesenheitsZeitraum();

        if(empty($eigenesSpiel)||empty($anderesSpiel)){
            return null;
        }
        
        $gleicheHalle = ($this->halle == $other->halle);
        if($gleicheHalle){
            $eigenesSpiel = $this->getSpielzeit();
            $anderesSpiel = $other->getSpielzeit();
        }

        return ZeitlicheDistanz::from_a_to_b($eigenesSpiel, $anderesSpiel);
    }

    public function isAmGleichenTag(?Spiel $other): bool {
        if(empty($other)){
            return false;
        }
        if(empty($this->anwurf) || empty($other->anwurf)){
            return false;
        }
        return $this->anwurf->format("Y-m-d") == $other->anwurf->format("Y-m-d");
    }

    public function isInGleicherHalle(?Spiel $other): bool {
        if(empty($other)){
            return false;
        }
        return $this->halle === $other->halle;
    }

    public function createDienste(){
        if($this->isHeimspiel()){
            $this->createDienst(Dienstart::ZEITNEHMER);
            $this->createDienst(Dienstart::CATERING);
            if($this->gast->mannschaft->stelltSekretaerBeiHeimspiel){
                // wenn der Gegner beim Heimspiel den Sekretär stellt, so müssen wir das auch
                $this->createDienst(Dienstart::SEKRETAER);
            }
        } else {
            if(!$this->gast->mannschaft->stelltSekretaerBeiHeimspiel){
                $this->createDienst(Dienstart::SEKRETAER);
            }
        }
    }
    public function createDienst(string $dienstart): Dienst{
        $dienst = new Dienst();
        $dienst->spiel = $this;
        $dienst->dienstart = $dienstart;
        $this->dienste[$dienstart] = $dienst;
        return $dienst;
    }

    public function getBegegnungsbezeichnung(): string{
        $anwurf = $this->anwurf->format("d.m.Y H:i");
        $heimName = $this->heim->mannschaft->getName();
        $gastName = $this->gast->mannschaft->getName();
        $kennungHEIM = $this->isHeimspiel() ? "HEIM" : "AUSWÄRTS";
        
        return "$anwurf $kennungHEIM (".$this->halle.") $heimName vs. $gastName";
    }
}

?>