export enum UserRole {
  REISADVISEUR = 'reisadviseur',
  FINANCIEEL = 'financieel',
  MANAGER = 'manager',
  ADMINISTRATOR = 'administrator',
}

export interface User {
  id: number;
  email: string;
  naam: string;
  rol: UserRole;
  isActief: boolean;
  datumAangemaakt: Date;
  datumGewijzigd: Date;
}

export interface Klant {
  id: number;
  voornaam: string;
  achternaam: string;
  email: string;
  telefoon: string;
  geboortedatum: Date;
  isActief: boolean;
  opmerking?: string;
  datumAangemaakt: Date;
  datumGewijzigd: Date;
}

export interface Bestemming {
  id: number;
  naam: string;
  land: string;
  beschrijving: string;
  prijs: number;
  isActief: boolean;
  opmerking?: string;
  datumAangemaakt: Date;
  datumGewijzigd: Date;
}

export interface Boeking {
  id: number;
  klantId: number;
  bestemmingId: number;
  startDatum: Date;
  eindDatum: Date;
  aantalVolwassenen: number;
  aantalKinderen: number;
  aantalBabys: number;
  totaalPrijs: number;
  administratieKosten: number;
  sgrKosten: number;
  status: 'actief' | 'geannuleerd' | 'voltooid';
  isActief: boolean;
  opmerking?: string;
  datumAangemaakt: Date;
  datumGewijzigd: Date;
}
