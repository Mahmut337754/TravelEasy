<?php
/**
 * Boeking Model
 */

require_once __DIR__ . '/BaseModel.php';

class Boeking extends BaseModel {
    
    protected $table = 'boekingen';

    public function create($data) {
        // Bereken prijzen
        $totaalPrijs = $this->berekenTotaalPrijs($data);
        $administratieKosten = ADMINISTRATIE_KOSTEN;
        $sgrKosten = ($data['aantalVolwassenen'] + $data['aantalKinderen']) * SGR_KOSTEN_PER_PERSOON;

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (klantId, bestemmingId, startDatum, eindDatum, aantalVolwassenen, aantalKinderen, aantalBabys,
             totaalPrijs, administratieKosten, sgrKosten, status, isActief, datumAangemaakt, datumGewijzigd)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'actief', 1, NOW(), NOW())
        ");
        
        $stmt->execute([
            $data['klantId'],
            $data['bestemmingId'],
            $data['startDatum'],
            $data['eindDatum'],
            $data['aantalVolwassenen'],
            $data['aantalKinderen'],
            $data['aantalBabys'],
            $totaalPrijs,
            $administratieKosten,
            $sgrKosten
        ]);
        
        return $this->db->lastInsertId();
    }

    private function berekenTotaalPrijs($data) {
        // TODO: Haal bestemmingsprijs op en bereken met kortingen
        $basisPrijs = 1000; // Placeholder
        
        $volwassenenPrijs = $data['aantalVolwassenen'] * $basisPrijs;
        $kinderenPrijs = $data['aantalKinderen'] * $basisPrijs * (1 - KINDEREN_KORTING);
        $babysPrijs = 0; // Gratis
        
        return $volwassenenPrijs + $kinderenPrijs + $babysPrijs;
    }

    public function getTotaalBoekingen() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE isActief = 1");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    public function getTotaalOmzet() {
        $stmt = $this->db->prepare("SELECT SUM(totaalPrijs) as total FROM {$this->table} WHERE isActief = 1 AND status = 'actief'");
        $stmt->execute();
        return $stmt->fetch()['total'] ?? 0;
    }

    public function getActieveKlanten() {
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT klantId) as total FROM {$this->table} WHERE isActief = 1");
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}
