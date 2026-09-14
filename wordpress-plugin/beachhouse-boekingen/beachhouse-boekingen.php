<?php
/**
 * Plugin Name: Beachhouse Boekingen
 * Description: Boekingskalender (shortcode [beachhouse_boeking]) plus beheerpagina "Beachhouse boekingen" in het dashboard. Vervangt de losse WPCode-snippets.
 * Version: 1.1.7
 * Requires PHP: 7.4
 * Text Domain: beachhouse-boekingen
 */

if (!defined('ABSPATH')) {
    exit;
}

/* =========================================================
   BEACHHOUSE FRONTEND + AANVRAGEN
   ========================================================= */

/*
 * Deze hele snippet staat in een function_exists() check.
 * Als dit bestand om wat voor reden dan ook een tweede keer
 * wordt uitgevoerd (bijv. door een dubbele snippet, of doordat
 * WPCode/Elementor de code twee keer laadt), doet PHP dan
 * niets in plaats van vast te lopen met een fatale
 * "Cannot redeclare function" fout. Dat was vermoedelijk de
 * reden waarom WPCode deze snippet automatisch uitschakelde.
 */

if (!function_exists('bh1_shortcode')) {

/* Shared, per-shortcode translations: the admin remains Dutch. */
function bh1_language($value) {
    return is_string($value) && in_array($value, ['nl','en','fr','es'], true) ? $value : 'nl';
}
function bh1_translations($lang) {
    static $translations = null;
    if ($translations === null) {
        $translations = json_decode(<<<'BH_TRANSLATIONS'
{
  "nl": {
    "Laagseizoen": "Laagseizoen",
    "Middenseizoen": "Middenseizoen",
    "Hoogseizoen": "Hoogseizoen",
    "per week": "per week",
    "Laag": "Laag",
    "Midden": "Midden",
    "Hoog": "Hoog",
    "Bezet": "Bezet",
    "Bereken je verblijf": "Bereken je verblijf",
    "Aankomst": "Aankomst",
    "Vertrek": "Vertrek",
    "Selecteer": "Selecteer",
    "Kies je aankomstdatum en daarna je vertrekdatum.": "Kies je aankomstdatum en daarna je vertrekdatum.",
    "Aanvraag doen": "Aanvraag doen",
    "Nieuwe data kiezen": "Nieuwe data kiezen",
    "Voornaam *": "Voornaam *",
    "Achternaam *": "Achternaam *",
    "E-mailadres *": "E-mailadres *",
    "Nationaliteit *": "Nationaliteit *",
    "Aantal personen *": "Aantal personen *",
    "Kies aantal": "Kies aantal",
    "1 persoon": "1 persoon",
    "2 personen": "2 personen",
    "3 personen": "3 personen",
    "4 personen": "4 personen",
    "5 personen": "5 personen",
    "6 personen": "6 personen",
    "7 personen": "7 personen",
    "8 personen": "8 personen",
    "Aanvraag versturen": "Aanvraag versturen",
    "Aanvraag versturen...": "Aanvraag versturen...",
    "Kies je aankomstdatum.": "Kies je aankomstdatum.",
    "Kies nu je vertrekdatum.": "Kies nu je vertrekdatum.",
    "Deze periode is niet meer beschikbaar.": "Deze periode is niet meer beschikbaar.",
    "Verblijf": "Verblijf",
    "nacht": "nacht",
    "nachten": "nachten",
    "Totaal voor deze periode": "Totaal voor deze periode",
    "De aanvraag kon niet worden verstuurd.": "De aanvraag kon niet worden verstuurd.",
    "Vul alle verplichte gegevens in.": "Vul alle verplichte gegevens in.",
    "Vul een geldig e-mailadres in.": "Vul een geldig e-mailadres in.",
    "Kies 1 t/m 8 personen.": "Kies 1 t/m 8 personen.",
    "De gekozen periode is niet geldig.": "De gekozen periode is niet geldig.",
    "Deze periode is inmiddels bezet. Kies andere data.": "Deze periode is inmiddels bezet. Kies andere data.",
    "Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.": "Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.",
    "Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.": "Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.",
    "De bevestigingsmail is aangeboden voor verzending. Controleer ook je spammap.": "Je ontvangt een bevestiging per e-mail. Controleer ook je spammap.",
    "De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.": "De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.",
    "Je aanvraag is ontvangen": "Je aanvraag is ontvangen",
    "Beste": "Beste",
    "Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.": "Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.",
    "Overzicht van je aanvraag": "Overzicht van je aanvraag",
    "Aantal nachten": "Aantal nachten",
    "Aantal personen": "Aantal personen",
    "Huurprijs verblijf": "Huurprijs verblijf",
    "Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.": "Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.",
    "Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.": "Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.",
    "Tot snel aan zee,": "Tot snel aan zee,",
    "Vorige maand": "Vorige maand",
    "Volgende maand": "Volgende maand",
    "Weekprijzen gelden voor 7 nachten, van zaterdag tot zaterdag.": "Weekprijzen gelden voor 7 nachten, van zaterdag tot zaterdag.",
    "Ma": "Ma",
    "Di": "Di",
    "Wo": "Wo",
    "Do": "Do",
    "Vr": "Vr",
    "Za": "Za",
    "Zo": "Zo",
    "Minimaal verblijf: 6 nachten.": "Minimaal verblijf: 6 nachten.",
    "Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.": "Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.",
    "Huisregels": "Huisregels",
    "Roken is niet toegestaan.": "Roken is niet toegestaan.",
    "Huisdieren zijn niet toegestaan.": "Huisdieren zijn niet toegestaan.",
    "Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.": "Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.",
    "Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.": "Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.",
    "Betalingsvoorwaarden": "Betalingsvoorwaarden",
    "Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.": "Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.",
    "Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.": "Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.",
    "Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.": "Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.",
    "De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.": "De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten."
  },
  "en": {
    "Laagseizoen": "Low season",
    "Middenseizoen": "Mid season",
    "Hoogseizoen": "High season",
    "per week": "per week",
    "Laag": "Low",
    "Midden": "Mid",
    "Hoog": "High",
    "Bezet": "Booked",
    "Bereken je verblijf": "Calculate your stay",
    "Aankomst": "Arrival",
    "Vertrek": "Departure",
    "Selecteer": "Select",
    "Kies je aankomstdatum en daarna je vertrekdatum.": "Choose your arrival date, then your departure date.",
    "Aanvraag doen": "Request a booking",
    "Nieuwe data kiezen": "Choose new dates",
    "Voornaam *": "First name *",
    "Achternaam *": "Last name *",
    "E-mailadres *": "Email address *",
    "Nationaliteit *": "Nationality *",
    "Aantal personen *": "Number of guests *",
    "Kies aantal": "Select number",
    "1 persoon": "1 guest",
    "2 personen": "2 guests",
    "3 personen": "3 guests",
    "4 personen": "4 guests",
    "5 personen": "5 guests",
    "6 personen": "6 guests",
    "7 personen": "7 guests",
    "8 personen": "8 guests",
    "Aanvraag versturen": "Send request",
    "Aanvraag versturen...": "Sending request...",
    "Kies je aankomstdatum.": "Choose your arrival date.",
    "Kies nu je vertrekdatum.": "Now choose your departure date.",
    "Deze periode is niet meer beschikbaar.": "These dates are no longer available.",
    "Verblijf": "Stay",
    "nacht": "night",
    "nachten": "nights",
    "Totaal voor deze periode": "Total for these dates",
    "De aanvraag kon niet worden verstuurd.": "Your request could not be sent. Please try again.",
    "Vul alle verplichte gegevens in.": "Please complete all required fields.",
    "Vul een geldig e-mailadres in.": "Please enter a valid email address.",
    "Kies 1 t/m 8 personen.": "Please select 1 to 8 guests.",
    "De gekozen periode is niet geldig.": "The selected dates are not valid.",
    "Deze periode is inmiddels bezet. Kies andere data.": "These dates have just become unavailable. Please choose other dates.",
    "Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.": "Your session has expired. Refresh the page and try again.",
    "Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.": "Your request has been received. We will contact you as soon as possible.",
    "De bevestigingsmail is aangeboden voor verzending. Controleer ook je spammap.": "You will receive a confirmation email. Please also check your spam folder.",
    "De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.": "The confirmation email could not be sent. Your request has been saved; you do not need to submit it again.",
    "Je aanvraag is ontvangen": "Your request has been received",
    "Beste": "Dear",
    "Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.": "Thank you for your request for Beachhouse Sueños del Mar. We have received your request and will contact you as soon as possible to discuss availability and the details of your stay.",
    "Overzicht van je aanvraag": "Your request at a glance",
    "Aantal nachten": "Number of nights",
    "Aantal personen": "Number of guests",
    "Huurprijs verblijf": "Rental price for your stay",
    "Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.": "This acknowledges receipt of your request; it is not a confirmed booking.",
    "Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.": "If you have any questions in the meantime, simply reply to this email.",
    "Tot snel aan zee,": "See you by the sea,",
    "Vorige maand": "Previous month",
    "Volgende maand": "Next month",
    "Weekprijzen gelden voor 7 nachten, van zaterdag tot zaterdag.": "Weekly rates are for 7 nights, from Saturday to Saturday.",
    "Ma": "Mon",
    "Di": "Tue",
    "Wo": "Wed",
    "Do": "Thu",
    "Vr": "Fri",
    "Za": "Sat",
    "Zo": "Sun",
    "Minimaal verblijf: 6 nachten.": "Minimum stay: 6 nights.",
    "Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.": "The minimum stay is 6 nights. Please choose a later departure date.",
    "Huisregels": "House rules",
    "Roken is niet toegestaan.": "Smoking is not allowed.",
    "Huisdieren zijn niet toegestaan.": "Pets are not allowed.",
    "Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.": "Parties, events, stag and hen parties, and noisy gatherings are not allowed.",
    "Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.": "20% deposit on booking; balance and €500 security deposit due no later than 4 weeks before arrival.",
    "Betalingsvoorwaarden": "Payment terms",
    "Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.": "When you book, you pay a deposit of 20% of the rental price. As soon as this amount has been received, your booking is confirmed.",
    "Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.": "No later than 4 weeks before arrival, you pay the remaining amount (80%), together with the €500 security deposit.",
    "Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.": "If you book within 4 weeks of arrival, you pay the full amount, including the security deposit, in one payment.",
    "De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.": "The security deposit is refunded in full within 14 days after departure, provided the apartment is left undamaged and tidy."
  },
  "fr": {
    "Laagseizoen": "Basse saison",
    "Middenseizoen": "Moyenne saison",
    "Hoogseizoen": "Haute saison",
    "per week": "par semaine",
    "Laag": "Basse",
    "Midden": "Moyenne",
    "Hoog": "Haute",
    "Bezet": "Indisponible",
    "Bereken je verblijf": "Calculez votre séjour",
    "Aankomst": "Arrivée",
    "Vertrek": "Départ",
    "Selecteer": "Sélectionner",
    "Kies je aankomstdatum en daarna je vertrekdatum.": "Choisissez votre date d’arrivée, puis votre date de départ.",
    "Aanvraag doen": "Faire une demande",
    "Nieuwe data kiezen": "Choisir d’autres dates",
    "Voornaam *": "Prénom *",
    "Achternaam *": "Nom *",
    "E-mailadres *": "Adresse e-mail *",
    "Nationaliteit *": "Nationalité *",
    "Aantal personen *": "Nombre de personnes *",
    "Kies aantal": "Choisir le nombre",
    "1 persoon": "1 personne",
    "2 personen": "2 personnes",
    "3 personen": "3 personnes",
    "4 personen": "4 personnes",
    "5 personen": "5 personnes",
    "6 personen": "6 personnes",
    "7 personen": "7 personnes",
    "8 personen": "8 personnes",
    "Aanvraag versturen": "Envoyer la demande",
    "Aanvraag versturen...": "Envoi en cours…",
    "Kies je aankomstdatum.": "Choisissez votre date d’arrivée.",
    "Kies nu je vertrekdatum.": "Choisissez maintenant votre date de départ.",
    "Deze periode is niet meer beschikbaar.": "Cette période n’est plus disponible.",
    "Verblijf": "Séjour",
    "nacht": "nuit",
    "nachten": "nuits",
    "Totaal voor deze periode": "Total pour cette période",
    "De aanvraag kon niet worden verstuurd.": "Votre demande n’a pas pu être envoyée. Veuillez réessayer.",
    "Vul alle verplichte gegevens in.": "Veuillez remplir tous les champs obligatoires.",
    "Vul een geldig e-mailadres in.": "Veuillez saisir une adresse e-mail valide.",
    "Kies 1 t/m 8 personen.": "Veuillez sélectionner de 1 à 8 personnes.",
    "De gekozen periode is niet geldig.": "La période choisie n’est pas valide.",
    "Deze periode is inmiddels bezet. Kies andere data.": "Cette période vient d’être réservée. Veuillez choisir d’autres dates.",
    "Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.": "Votre session a expiré. Actualisez la page et réessayez.",
    "Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.": "Votre demande a bien été reçue. Nous vous contacterons dans les meilleurs délais.",
    "De bevestigingsmail is aangeboden voor verzending. Controleer ook je spammap.": "Vous recevrez un e-mail de confirmation. Pensez à vérifier vos courriers indésirables.",
    "De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.": "L’e-mail de confirmation n’a pas pu être envoyé. Votre demande est enregistrée ; inutile de la renvoyer.",
    "Je aanvraag is ontvangen": "Votre demande a bien été reçue",
    "Beste": "Bonjour",
    "Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.": "Merci pour votre demande concernant Beachhouse Sueños del Mar. Nous l’avons bien reçue et vous contacterons dans les meilleurs délais pour discuter des disponibilités et des détails de votre séjour.",
    "Overzicht van je aanvraag": "Récapitulatif de votre demande",
    "Aantal nachten": "Nombre de nuits",
    "Aantal personen": "Nombre de personnes",
    "Huurprijs verblijf": "Prix de location du séjour",
    "Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.": "Cet e-mail confirme la réception de votre demande ; il ne constitue pas une réservation définitive.",
    "Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.": "Si vous avez des questions, n’hésitez pas à répondre à cet e-mail.",
    "Tot snel aan zee,": "À bientôt au bord de la mer,",
    "Vorige maand": "Mois précédent",
    "Volgende maand": "Mois suivant",
    "Weekprijzen gelden voor 7 nachten, van zaterdag tot zaterdag.": "Les tarifs à la semaine correspondent à 7 nuits, du samedi au samedi.",
    "Ma": "Lun",
    "Di": "Mar",
    "Wo": "Mer",
    "Do": "Jeu",
    "Vr": "Ven",
    "Za": "Sam",
    "Zo": "Dim",
    "Minimaal verblijf: 6 nachten.": "Séjour minimum : 6 nuits.",
    "Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.": "Le séjour minimum est de 6 nuits. Veuillez choisir une date de départ plus tardive.",
    "Huisregels": "Règles de la maison",
    "Roken is niet toegestaan.": "Il est interdit de fumer.",
    "Huisdieren zijn niet toegestaan.": "Les animaux de compagnie ne sont pas admis.",
    "Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.": "Les fêtes, événements, enterrements de vie de célibataire et rassemblements bruyants sont interdits.",
    "Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.": "Acompte de 20 % à la réservation ; solde et caution de 500 € à régler au plus tard 4 semaines avant l’arrivée.",
    "Betalingsvoorwaarden": "Conditions de paiement",
    "Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.": "Lors de la réservation, vous versez un acompte de 20 % du montant de la location. Dès réception de cet acompte, votre réservation est définitive.",
    "Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.": "Au plus tard 4 semaines avant votre arrivée, vous réglez le solde restant (80 %), ainsi que la caution de 500 €.",
    "Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.": "Si vous réservez moins de 4 semaines avant l’arrivée, vous réglez la totalité du montant, caution comprise, en une seule fois.",
    "De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.": "La caution est intégralement remboursée dans les 14 jours suivant le départ, à condition que l’appartement soit rendu propre et sans dommage."
  },
  "es": {
    "Laagseizoen": "Temporada baja",
    "Middenseizoen": "Temporada media",
    "Hoogseizoen": "Temporada alta",
    "per week": "por semana",
    "Laag": "Baja",
    "Midden": "Media",
    "Hoog": "Alta",
    "Bezet": "Ocupado",
    "Bereken je verblijf": "Calcula tu estancia",
    "Aankomst": "Llegada",
    "Vertrek": "Salida",
    "Selecteer": "Seleccionar",
    "Kies je aankomstdatum en daarna je vertrekdatum.": "Selecciona la fecha de llegada y después la de salida.",
    "Aanvraag doen": "Solicitar reserva",
    "Nieuwe data kiezen": "Elegir otras fechas",
    "Voornaam *": "Nombre *",
    "Achternaam *": "Apellidos *",
    "E-mailadres *": "Correo electrónico *",
    "Nationaliteit *": "Nacionalidad *",
    "Aantal personen *": "Número de personas *",
    "Kies aantal": "Seleccionar número",
    "1 persoon": "1 persona",
    "2 personen": "2 personas",
    "3 personen": "3 personas",
    "4 personen": "4 personas",
    "5 personen": "5 personas",
    "6 personen": "6 personas",
    "7 personen": "7 personas",
    "8 personen": "8 personas",
    "Aanvraag versturen": "Enviar solicitud",
    "Aanvraag versturen...": "Enviando solicitud…",
    "Kies je aankomstdatum.": "Selecciona tu fecha de llegada.",
    "Kies nu je vertrekdatum.": "Selecciona ahora tu fecha de salida.",
    "Deze periode is niet meer beschikbaar.": "Estas fechas ya no están disponibles.",
    "Verblijf": "Estancia",
    "nacht": "noche",
    "nachten": "noches",
    "Totaal voor deze periode": "Total para estas fechas",
    "De aanvraag kon niet worden verstuurd.": "No se ha podido enviar tu solicitud. Inténtalo de nuevo.",
    "Vul alle verplichte gegevens in.": "Completa todos los campos obligatorios.",
    "Vul een geldig e-mailadres in.": "Introduce un correo electrónico válido.",
    "Kies 1 t/m 8 personen.": "Selecciona entre 1 y 8 personas.",
    "De gekozen periode is niet geldig.": "Las fechas seleccionadas no son válidas.",
    "Deze periode is inmiddels bezet. Kies andere data.": "Estas fechas ya están ocupadas. Selecciona otras fechas.",
    "Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.": "Tu sesión ha caducado. Actualiza la página e inténtalo de nuevo.",
    "Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.": "Hemos recibido tu solicitud. Nos pondremos en contacto contigo lo antes posible.",
    "De bevestigingsmail is aangeboden voor verzending. Controleer ook je spammap.": "Recibirás un correo de confirmación. Revisa también la carpeta de spam.",
    "De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.": "No se ha podido enviar el correo de confirmación. Tu solicitud está guardada; no necesitas enviarla de nuevo.",
    "Je aanvraag is ontvangen": "Hemos recibido tu solicitud",
    "Beste": "Hola",
    "Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.": "Gracias por tu solicitud para Beachhouse Sueños del Mar. La hemos recibido correctamente y nos pondremos en contacto contigo lo antes posible para comentar la disponibilidad y los detalles de tu estancia.",
    "Overzicht van je aanvraag": "Resumen de tu solicitud",
    "Aantal nachten": "Número de noches",
    "Aantal personen": "Número de personas",
    "Huurprijs verblijf": "Precio del alquiler de la estancia",
    "Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.": "Este correo confirma la recepción de tu solicitud; todavía no es una reserva confirmada.",
    "Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.": "Si tienes alguna pregunta, puedes responder a este correo.",
    "Tot snel aan zee,": "Nos vemos junto al mar,",
    "Vorige maand": "Mes anterior",
    "Volgende maand": "Mes siguiente",
    "Weekprijzen gelden voor 7 nachten, van zaterdag tot zaterdag.": "Los precios semanales corresponden a 7 noches, de sábado a sábado.",
    "Ma": "Lun",
    "Di": "Mar",
    "Wo": "Mié",
    "Do": "Jue",
    "Vr": "Vie",
    "Za": "Sáb",
    "Zo": "Dom",
    "Minimaal verblijf: 6 nachten.": "Estancia mínima: 6 noches.",
    "Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.": "La estancia mínima es de 6 noches. Selecciona una fecha de salida posterior.",
    "Huisregels": "Normas de la casa",
    "Roken is niet toegestaan.": "No está permitido fumar.",
    "Huisdieren zijn niet toegestaan.": "No se admiten mascotas.",
    "Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.": "No se permiten fiestas, eventos, despedidas de soltero o soltera ni reuniones ruidosas.",
    "Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.": "Depósito del 20 % al reservar; resto y fianza de 500 € a pagar como máximo 4 semanas antes de la llegada.",
    "Betalingsvoorwaarden": "Condiciones de pago",
    "Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.": "Al reservar, pagas una señal del 20 % del importe del alquiler. En cuanto se reciba este importe, tu reserva será definitiva.",
    "Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.": "Como máximo 4 semanas antes de la llegada, pagas el importe restante (80 %), junto con la fianza de 500 €.",
    "Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.": "Si reservas con menos de 4 semanas de antelación a la llegada, pagas el importe total, incluida la fianza, de una sola vez.",
    "De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.": "La fianza se reembolsa íntegramente en un plazo de 14 días tras la salida, siempre que el apartamento se entregue limpio y sin daños."
  }
}
BH_TRANSLATIONS
        , true);
    }
    return $translations[bh1_language($lang)];
}
function bh1_t($text, $lang = 'nl') {
    $translations = bh1_translations($lang);
    return $translations[$text] ?? $text;
}
function bh1_locale($lang) {
    return ['nl'=>'nl-NL','en'=>'en-GB','fr'=>'fr-FR','es'=>'es-ES'][bh1_language($lang)];
}
function bh1_guest_email($lang, $name, $arrival, $departure, $persons, $calculation) {
    $t = function($text) use ($lang) { return esc_html(bh1_t($text, $lang)); };
    $date = function($value) use ($lang) {
        $d = DateTimeImmutable::createFromFormat('!Y-m-d', $value);
        return $d ? $d->format($lang === 'nl' ? 'd-m-Y' : 'd/m/Y') : $value;
    };
    $amount = $lang === 'en'
        ? '€ ' . number_format($calculation['total'], 2, '.', ',')
        : number_format($calculation['total'], 2, ',', $lang === 'fr' ? ' ' : '.') . ' €';
    $rows = '';
    foreach (['Aankomst'=>$date($arrival), 'Vertrek'=>$date($departure), 'Aantal nachten'=>$calculation['nights'], 'Aantal personen'=>$persons, 'Huurprijs verblijf'=>$amount] as $label=>$value) {
        $rows .= '<tr><td style="padding:12px;border-bottom:1px solid #dce6ee;color:#52697c;">'.$t($label).'</td><td style="padding:12px;border-bottom:1px solid #dce6ee;text-align:right;color:#315779;">'.esc_html((string)$value).'</td></tr>';
    }
    return '<!doctype html><html lang="'.esc_attr($lang).'"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head><body style="margin:0;background:#f1f6fa;font-family:Arial,sans-serif;color:#315779;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:24px 12px;"><table role="presentation" width="600" cellspacing="0" cellpadding="0" style="width:100%;max-width:600px;background:#ffffff;">'
        . '<tr><td style="padding:26px;background:#315779;color:#ffffff;font-size:17px;letter-spacing:1px;">BEACHHOUSE<br><span style="font-family:Georgia,serif;font-size:27px;">Sueños del Mar</span></td></tr>'
        . '<tr><td style="padding:28px;font-size:15px;line-height:1.7;"><h1 style="font-family:Georgia,serif;font-size:29px;font-weight:normal;line-height:1.2;">'.$t('Je aanvraag is ontvangen').'</h1><p>'.$t('Beste').' '.esc_html($name).',</p><p>'.$t('Bedankt voor je aanvraag voor Beachhouse Sueños del Mar. We hebben je aanvraag in goede orde ontvangen en nemen zo snel mogelijk contact met je op om de beschikbaarheid en de verdere details te bespreken.').'</p>'
        . '<h2 style="font-size:17px;">'.$t('Overzicht van je aanvraag').'</h2><table width="100%" cellspacing="0" cellpadding="0">'.$rows.'</table>'
        . '<h2 style="font-size:17px;">'.$t('Betalingsvoorwaarden').'</h2>'
        . '<ul style="margin:0 0 10px;padding:0 0 0 18px;color:#315779;font-size:14px;line-height:1.6;">'
            . '<li style="margin:0 0 7px;">'.$t('Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.').'</li>'
            . '<li style="margin:0 0 7px;">'.$t('Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.').'</li>'
            . '<li style="margin:0 0 7px;">'.$t('Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.').'</li>'
            . '<li style="margin:0;">'.$t('De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.').'</li>'
        . '</ul>'
        . '<p style="background:#e7f3fd;padding:16px;">'.$t('Dit is een ontvangstbevestiging van je aanvraag, nog geen definitieve boeking.').'</p><p>'.$t('Heb je in de tussentijd vragen? Antwoord gerust op deze e-mail.').'</p><p>'.$t('Tot snel aan zee,').'<br>Beachhouse Sueños del Mar</p></td></tr>'
        . '<tr><td style="padding:20px 28px;background:#e7f3fd;font-size:13px;"><a href="mailto:info@beachhousecostablanca.com" style="color:#315779;">info@beachhousecostablanca.com</a></td></tr></table></td></tr></table></body></html>';
}


/* =========================================================
   TARIEFPERIODES 2027
========================================================= */

function bh1_periods() {

    return [

        ['2027-01-02','2027-01-08','mid'],
        ['2027-01-09','2027-02-05','low'],

        ['2027-02-06','2027-03-12','mid'],

        ['2027-03-13','2027-03-19','low'],
        ['2027-03-20','2027-04-02','mid'],

        ['2027-04-03','2027-05-14','high'],

        ['2027-05-15','2027-05-28','mid'],
        ['2027-05-29','2027-06-11','high'],

        ['2027-06-12','2027-06-18','mid'],
        ['2027-06-19','2027-10-01','high'],

        ['2027-10-02','2027-10-15','low'],
        ['2027-10-16','2027-11-12','mid'],

        ['2027-11-13','2027-12-17','low'],
        ['2027-12-18','2027-12-31','mid'],

    ];
}


function bh1_season($date) {

    foreach (bh1_periods() as $period) {

        if (
            $date >= $period[0] &&
            $date <= $period[1]
        ) {

            return $period[2];

        }
    }

    return false;
}


/* =========================================================
   OPSLAG BOEKINGEN
========================================================= */

function bh1_store_key() {

    return 'bh_booking_items_v1';
}


/*
 * Probeert eventuele boekingen uit eerdere versies
 * automatisch mee te nemen.
 */

function bh1_migrate_store() {

    $key =
        bh1_store_key();


    $current =
        get_option(
            $key,
            null
        );


    if (is_array($current)) {
        return;
    }


    $merged = [];


    foreach (
        [
            'bhscb_bookings',
            'bhs_beachhouse_bookings'
        ]
        as $old_key
    ) {

        $old =
            get_option(
                $old_key,
                []
            );


        if (!is_array($old)) {
            continue;
        }


        foreach (
            $old
            as $item
        ) {

            if (!is_array($item)) {
                continue;
            }


            $id =
                $item['id']
                ??
                wp_generate_uuid4();


            $item['id'] =
                $id;


            $merged[$id] =
                $item;
        }
    }


    update_option(
        $key,
        array_values($merged),
        false
    );
}


function bh1_get_bookings() {

    bh1_migrate_store();


    $items =
        get_option(
            bh1_store_key(),
            []
        );


    return
        is_array($items)
        ? $items
        : [];
}


function bh1_save_bookings($items) {

    return update_option(
        bh1_store_key(),
        array_values($items),
        false
    );
}


/* =========================================================
   PRIJSBEREKENING SERVER-SIDE
========================================================= */

function bh1_calculate(
    $arrival,
    $departure
) {

    $timezone =
        new DateTimeZone('UTC');


    $start =
        DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $arrival,
            $timezone
        );


    $end =
        DateTimeImmutable::createFromFormat(
            '!Y-m-d',
            $departure,
            $timezone
        );


    if (
        !$start ||
        !$end
    ) {
        return false;
    }


    if (
        $start->format('Y-m-d') !== $arrival ||
        $end->format('Y-m-d') !== $departure
    ) {
        return false;
    }


    if ($end <= $start) {
        return false;
    }


    if (
        $arrival < '2027-01-02' ||
        $departure > '2028-01-01'
    ) {
        return false;
    }


    $counts = [

        'low'  => 0,
        'mid'  => 0,
        'high' => 0

    ];


    $cursor =
        $start;


    while ($cursor < $end) {

        $season =
            bh1_season(
                $cursor->format('Y-m-d')
            );


        if (!$season) {
            return false;
        }


        $counts[$season]++;


        $cursor =
            $cursor->modify('+1 day');
    }


    $nights =
        array_sum($counts);


    $total =
        round(

            (
                ($counts['low'] * 1410) +
                ($counts['mid'] * 1760) +
                ($counts['high'] * 2200)
            ) / 7,

            2

        );


    return [

        'nights' => $nights,
        'total'  => $total,
        'counts' => $counts

    ];
}


/* =========================================================
   CONTROLEREN OF EEN PERIODE BEZET IS
========================================================= */

function bh1_overlap(
    $arrival,
    $departure
) {

    foreach (
        bh1_get_bookings()
        as $booking
    ) {

        /*
         * Alleen bevestigde boekingen blokkeren.
         */

        if (
            ($booking['status'] ?? '')
            !==
            'confirmed'
        ) {
            continue;
        }


        $existing_arrival =
            $booking['arrival']
            ?? '';


        $existing_departure =
            $booking['departure']
            ?? '';


        if (
            !$existing_arrival ||
            !$existing_departure
        ) {
            continue;
        }


        /*
         * Vertrekdag telt niet als bezette nacht.
         */

        if (
            $arrival < $existing_departure &&
            $departure > $existing_arrival
        ) {

            return true;
        }
    }


    return false;
}


/* =========================================================
   BEVESTIGDE PERIODES VOOR KALENDER
========================================================= */

function bh1_confirmed_ranges() {

    $ranges = [];


    foreach (
        bh1_get_bookings()
        as $booking
    ) {

        if (
            ($booking['status'] ?? '')
                ===
                'confirmed'

            &&
            !empty($booking['arrival'])

            &&
            !empty($booking['departure'])
        ) {

            $ranges[] = [

                $booking['arrival'],

                $booking['departure']

            ];
        }
    }


    return $ranges;
}


/* =========================================================
   AJAX - BEZETTE DATA OPHALEN
========================================================= */

function bh1_ajax_get_blocked() {

    wp_send_json_success([

        'ranges' =>
            bh1_confirmed_ranges()

    ]);
}


add_action(
    'wp_ajax_bh1_get_blocked',
    'bh1_ajax_get_blocked'
);


add_action(
    'wp_ajax_nopriv_bh1_get_blocked',
    'bh1_ajax_get_blocked'
);


/* =========================================================
   AJAX - AANVRAAG VERSTUREN
========================================================= */

function bh1_ajax_send_request() {

    $lang = bh1_language(wp_unslash($_POST['language'] ?? 'nl'));
    if (!check_ajax_referer('bh1_booking_nonce', 'nonce', false)) {
        wp_send_json_error(['message' => bh1_t('Je sessie is verlopen. Vernieuw de pagina en probeer opnieuw.', $lang)], 403);
    }


    /* spamveld */

    if (
        !empty($_POST['website'])
    ) {

        wp_send_json_error([

            'message' =>
                bh1_t('De aanvraag kon niet worden verstuurd.', $lang)

        ]);
    }


    $first_name =
        sanitize_text_field(
            wp_unslash(
                $_POST['first_name']
                ?? ''
            )
        );


    $last_name =
        sanitize_text_field(
            wp_unslash(
                $_POST['last_name']
                ?? ''
            )
        );


    $email =
        sanitize_email(
            wp_unslash(
                $_POST['email']
                ?? ''
            )
        );


    $nationality =
        sanitize_text_field(
            wp_unslash(
                $_POST['nationality']
                ?? ''
            )
        );


    $persons =
        absint(
            $_POST['persons']
            ?? 0
        );


    $arrival =
        sanitize_text_field(
            wp_unslash(
                $_POST['arrival']
                ?? ''
            )
        );


    $departure =
        sanitize_text_field(
            wp_unslash(
                $_POST['departure']
                ?? ''
            )
        );


    if (
        !$first_name ||
        !$last_name ||
        !$email ||
        !$nationality ||
        !$arrival ||
        !$departure
    ) {

        wp_send_json_error([

            'message' =>
                bh1_t('Vul alle verplichte gegevens in.', $lang)

        ]);
    }


    if (!is_email($email)) {

        wp_send_json_error([

            'message' =>
                bh1_t('Vul een geldig e-mailadres in.', $lang)

        ]);
    }


    if (
        $persons < 1 ||
        $persons > 8
    ) {

        wp_send_json_error([

            'message' =>
                bh1_t('Kies 1 t/m 8 personen.', $lang)

        ]);
    }


    $calculation =
        bh1_calculate(
            $arrival,
            $departure
        );


    if (!$calculation) {

        wp_send_json_error([

            'message' =>
                bh1_t('De gekozen periode is niet geldig.', $lang)

        ]);
    }


    // Enforce the public booking minimum even if JavaScript is bypassed.
    if ($calculation['nights'] < 6) {
        wp_send_json_error(['message' => bh1_t('Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.', $lang)], 400);
    }

    /*
     * Laatste controle vlak voor opslaan.
     */

    if (
        bh1_overlap(
            $arrival,
            $departure
        )
    ) {

        wp_send_json_error([

            'message' =>
                bh1_t('Deze periode is inmiddels bezet. Kies andere data.', $lang)

        ]);
    }


    /* aanvraag opslaan */

    $items =
        bh1_get_bookings();


    $request_id = wp_generate_uuid4();
    $items[] = [
        'language' => $lang,

        'id' =>
            $request_id,

        'created' =>
            current_time('mysql'),

        'source' =>
            'website',

        'first_name' =>
            $first_name,

        'last_name' =>
            $last_name,

        'email' =>
            $email,

        'nationality' =>
            $nationality,

        'persons' =>
            $persons,

        'arrival' =>
            $arrival,

        'departure' =>
            $departure,

        'nights' =>
            $calculation['nights'],

        'total' =>
            $calculation['total'],

        /*
         * Nieuwe aanvraag blokkeert nog niet.
         */

        'status' =>
            'request'

    ];


    if (!bh1_save_bookings($items)) {
        wp_send_json_error(['message' => bh1_t('De aanvraag kon niet worden verstuurd.', $lang)], 500);
    }


    /* =========================
       E-MAIL NAAR JOU
    ========================= */

    $to =
        'info@beachhousecostablanca.com';


    $subject =
        'Nieuwe aanvraag Beachhouse Sueños del Mar - ' .
        $first_name .
        ' ' .
        $last_name;


    $message =
        "Nieuwe boekingsaanvraag Beachhouse Sueños del Mar\n\n";


    $message .=
        "Naam: {$first_name} {$last_name}\n";


    $message .=
        "E-mail: {$email}\n";


    $message .=
        "Nationaliteit: {$nationality}\n";


    $message .=
        "Aantal personen: {$persons}\n\n";


    $message .=
        "Aankomst: {$arrival}\n";


    $message .=
        "Vertrek: {$departure}\n";


    $message .=
        "Aantal nachten: {$calculation['nights']}\n";


    $message .=
        "Totaal: € " .
        number_format(
            $calculation['total'],
            2,
            ',',
            '.'
        ) .
        "\n\n";


    $message .=
        "Status: aanvraag.\n" .
        "De periode wordt pas geblokkeerd zodra je hem in WordPress op Bevestigd zet.";


    $message .= "\nTaal gast: " . ['nl'=>'Nederlands','en'=>'Engels','fr'=>'Frans','es'=>'Spaans'][$lang];

    $headers = [

        'Content-Type: text/plain; charset=UTF-8',

        'Reply-To: ' .
        $first_name .
        ' ' .
        $last_name .
        ' <' .
        $email .
        '>'

    ];


    $owner_mail_sent = wp_mail(
        $to,
        $subject,
        $message,
        $headers
    );


    /* =========================
       BEVESTIGINGSMAIL NAAR DE KLANT
    ========================= */

    $guest_subject = bh1_t('Je aanvraag is ontvangen', $lang) . ' — Beachhouse Sueños del Mar';
    $guest_message = bh1_guest_email($lang, $first_name, $arrival, $departure, $persons, $calculation);
    $guest_mail_sent = wp_mail($email, $guest_subject, $guest_message, [
        'Content-Type: text/html; charset=UTF-8',
        'From: Beachhouse Sueños del Mar <info@beachhousecostablanca.com>',
        'Reply-To: info@beachhousecostablanca.com'
    ]);
    // Track transport acceptance, not inbox delivery, using a fresh copy of the bookings.
    $saved_items = bh1_get_bookings();
    foreach ($saved_items as &$saved_item) {
        if (($saved_item['id'] ?? '') === $request_id) {
            $saved_item['owner_mail_sent'] = (bool) $owner_mail_sent;
            $saved_item['guest_mail_sent'] = (bool) $guest_mail_sent;
            break;
        }
    }
    unset($saved_item);
    bh1_save_bookings($saved_items);
    wp_send_json_success([
        'message' => bh1_t('Je aanvraag is ontvangen. We nemen zo snel mogelijk contact met je op.', $lang) . ' ' . bh1_t($guest_mail_sent
            ? 'De bevestigingsmail is aangeboden voor verzending. Controleer ook je spammap.'
            : 'De bevestigingsmail kon niet worden verstuurd. Je aanvraag is wel opgeslagen; je hoeft hem niet opnieuw te versturen.', $lang)
    ]);
}


add_action(
    'wp_ajax_bh1_send_request',
    'bh1_ajax_send_request'
);


add_action(
    'wp_ajax_nopriv_bh1_send_request',
    'bh1_ajax_send_request'
);


/* =========================================================
   SHORTCODE
========================================================= */

function bh1_shortcode($atts = [], $content = null, $tag = 'beachhouse_boeking') {
    $languages = ['beachhouse_boeking'=>'nl','beachhouse_boekingengels'=>'en','beachhouse_boekingfrans'=>'fr','beachhouse_boekingspaans'=>'es'];
    $lang = $languages[strtolower($tag)] ?? 'nl';

    $uid =
        'bh1-' .
        wp_rand(
            10000,
            999999
        );


    $ajax_url =
        admin_url(
            'admin-ajax.php'
        );


    $nonce =
        wp_create_nonce(
            'bh1_booking_nonce'
        );


    ob_start();

    ?>

<style>

@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap');

#<?php echo esc_attr($uid); ?> {
    --bh-ink:#315779;
    --bh-sea:#315779;
    --bh-sea-dark:#16243f;
    --bh-sand:#f5f8fa;
    --bh-sand-line:#dce6ee;
    --bh-gold:#f2b313;
    --bh-terracotta:#f06441;
    --bh-sage:#21ac68;
    --bh-white:#ffffff;

    max-width:1080px;
    margin:0 auto;
    font-family:'IBM Plex Sans',sans-serif;
    color:var(--bh-ink);
    background:var(--bh-sand);
    padding:32px;
    border-radius:0;
}

#<?php echo esc_attr($uid); ?> * {
    box-sizing:border-box;
}

#<?php echo esc_attr($uid); ?> h1,
#<?php echo esc_attr($uid); ?> h2,
#<?php echo esc_attr($uid); ?> h3,
#<?php echo esc_attr($uid); ?> .month,
#<?php echo esc_attr($uid); ?> .title {
    font-family:'Cormorant Garamond',serif;
}


/* PRIJZEN */

#<?php echo esc_attr($uid); ?> .prices {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;
    margin-bottom:28px;
}

#<?php echo esc_attr($uid); ?> .pricebox {
    background:var(--bh-white);
    border:1px solid var(--bh-sand-line);
    border-radius:0;
    text-align:center;
    padding:22px 12px 18px;
    position:relative;
    overflow:hidden;
    box-shadow:none;
}

#<?php echo esc_attr($uid); ?> .pricebox:before {
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:100%;
    height:4px;
}

#<?php echo esc_attr($uid); ?> .pricebox.low:before {
    background:var(--bh-sage);
}

#<?php echo esc_attr($uid); ?> .pricebox.mid:before {
    background:var(--bh-gold);
}

#<?php echo esc_attr($uid); ?> .pricebox.high:before {
    background:var(--bh-terracotta);
}

#<?php echo esc_attr($uid); ?> .ptitle {
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:1.5px;
    font-weight:500;
    color:#607588;
}

#<?php echo esc_attr($uid); ?> .pvalue {
    font-family:'Cormorant Garamond',serif;
    font-size:27px;
    font-weight:600;
    margin-top:5px;
    color:var(--bh-sea-dark);
}

#<?php echo esc_attr($uid); ?> .psub {
    font-size:11px;
    color:#657889;
    margin-top:2px;
}


/* HOOFDINDELING */

#<?php echo esc_attr($uid); ?> .main {
    display:grid;
    grid-template-columns:
        minmax(0,1.25fr)
        minmax(280px,.75fr);
    gap:20px;
}

#<?php echo esc_attr($uid); ?> .card {
    background:var(--bh-white);
    border:1px solid var(--bh-sand-line);
    border-radius:0;
    padding:22px;
    box-shadow:none;
}


/* KALENDER */

#<?php echo esc_attr($uid); ?> .calhead {
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:16px;
}

#<?php echo esc_attr($uid); ?> .month {
    font-size:19px;
    font-weight:600;
    text-transform:capitalize;
    letter-spacing:.3px;
    color:var(--bh-sea-dark);
}

#<?php echo esc_attr($uid); ?> .nav {
    border:1px solid var(--bh-sand-line);
    background:var(--bh-white);
    width:38px;
    height:38px;
    border-radius:50%;
    font-size:18px;
    cursor:pointer;
    color:var(--bh-sea-dark);
    transition:background .15s ease;
}

#<?php echo esc_attr($uid); ?> .nav:hover:not(:disabled) {
    background:var(--bh-sand);
}

#<?php echo esc_attr($uid); ?> .nav:disabled {
    opacity:.3;
    cursor:default;
}

#<?php echo esc_attr($uid); ?> .weekdays,
#<?php echo esc_attr($uid); ?> .days {
    display:grid;
    grid-template-columns:repeat(7,1fr);
}

#<?php echo esc_attr($uid); ?> .weekdays div {
    text-align:center;
    font-size:10px;
    text-transform:uppercase;
    letter-spacing:1px;
    color:#657889;
    padding:5px 0 10px;
}

#<?php echo esc_attr($uid); ?> .day {
    position:relative;
    border:0;
    background:transparent;
    min-height:48px;
    cursor:pointer;
    font-size:13px;
    font-family:'IBM Plex Sans',sans-serif;
    border-radius:8px;
    color:var(--bh-ink);
    transition:background .15s ease;
}

#<?php echo esc_attr($uid); ?> .day:hover:not(:disabled) {
    background:var(--bh-sand);
}

#<?php echo esc_attr($uid); ?> .day:after {
    content:"";
    position:absolute;
    width:8px;
    height:8px;
    border-radius:50%;
    bottom:6px;
    left:50%;
    transform:translateX(-50%);
}

#<?php echo esc_attr($uid); ?> .day.low:after {
    background:var(--bh-sage);
}

#<?php echo esc_attr($uid); ?> .day.mid:after {
    background:var(--bh-gold);
}

#<?php echo esc_attr($uid); ?> .day.high:after {
    background:var(--bh-terracotta);
}


/* BEZET */

#<?php echo esc_attr($uid); ?> .day.booked {
    background:#f1efe9;
    color:#b7bcbb;
    text-decoration:line-through;
    cursor:not-allowed;
}

#<?php echo esc_attr($uid); ?> .day.booked:after {
    background:#c8c8c8;
}


/* SELECTIE */

#<?php echo esc_attr($uid); ?> .day.inrange {
    background:#e7f3fd;
    border-radius:0;
}

#<?php echo esc_attr($uid); ?> .day.selected {
    background:var(--bh-sea);
    color:#fff;
    border-radius:8px;
    font-weight:600;
    text-decoration:none;
}

#<?php echo esc_attr($uid); ?> .day.selected:after {
    background:#fff;
}


/* LEGENDA */

#<?php echo esc_attr($uid); ?> .legend {
    display:flex;
    justify-content:center;
    flex-wrap:wrap;
    gap:20px;
    margin-top:16px;
    font-size:11px;
    color:#607588;
}

#<?php echo esc_attr($uid); ?> .dot {
    display:inline-block;
    width:8px;
    height:8px;
    border-radius:50%;
    margin-right:5px;
}

#<?php echo esc_attr($uid); ?> .dot.low {
    background:var(--bh-sage);
}

#<?php echo esc_attr($uid); ?> .dot.mid {
    background:var(--bh-gold);
}

#<?php echo esc_attr($uid); ?> .dot.high {
    background:var(--bh-terracotta);
}

#<?php echo esc_attr($uid); ?> .dot.booked {
    background:#c8c8c8;
}


/* RESULTAAT */

#<?php echo esc_attr($uid); ?> .title {
    font-size:19px;
    font-weight:600;
    margin-bottom:18px;
    color:var(--bh-sea-dark);
}

#<?php echo esc_attr($uid); ?> .selection {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-bottom:20px;
}

#<?php echo esc_attr($uid); ?> .datebox {
    background:var(--bh-sand);
    border-radius:0;
    padding:12px;
}

#<?php echo esc_attr($uid); ?> .dlabel {
    font-size:10px;
    text-transform:uppercase;
    color:#657889;
    letter-spacing:1px;
}

#<?php echo esc_attr($uid); ?> .dvalue {
    font-size:13px;
    font-weight:600;
    color:var(--bh-sea-dark);
    margin-top:2px;
}

#<?php echo esc_attr($uid); ?> .msg {
    font-size:12px;
    color:#607588;
    line-height:1.6;
}

#<?php echo esc_attr($uid); ?> .resultrow {
    display:flex;
    justify-content:space-between;
    padding:9px 0;
    border-bottom:1px solid var(--bh-sand-line);
    font-size:13px;
}

#<?php echo esc_attr($uid); ?> .total {
    margin-top:20px;
}

#<?php echo esc_attr($uid); ?> .tlabel {
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:1px;
    color:#657889;
    margin-bottom:5px;
}

#<?php echo esc_attr($uid); ?> .tprice {
    font-family:'Cormorant Garamond',serif;
    font-size:33px;
    font-weight:600;
    color:var(--bh-sea-dark);
}


/* KNOPPEN */

#<?php echo esc_attr($uid); ?> .primary,
#<?php echo esc_attr($uid); ?> .send {
    width:100%;
    border:0;
    background:var(--bh-sea);
    color:#fff;
    padding:14px 15px;
    border-radius:0;
    cursor:pointer;
    font-family:'IBM Plex Sans',sans-serif;
    font-size:12px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:1.5px;
    transition:background .15s ease,transform .1s ease;
}

#<?php echo esc_attr($uid); ?> .primary:hover:not(:disabled),
#<?php echo esc_attr($uid); ?> .send:hover:not(:disabled) {
    background:var(--bh-sea-dark);
}

#<?php echo esc_attr($uid); ?> .primary {
    margin-top:20px;
}

#<?php echo esc_attr($uid); ?> .primary:disabled {
    background:#e4e0d6;
    color:#a8a094;
    cursor:default;
}

#<?php echo esc_attr($uid); ?> .reset {
    width:100%;
    margin-top:10px;
    border:1px solid var(--bh-sand-line);
    background:transparent;
    color:var(--bh-sea-dark);
    padding:11px;
    border-radius:0;
    cursor:pointer;
    font-family:'IBM Plex Sans',sans-serif;
    font-size:12px;
    letter-spacing:.5px;
    transition:background .15s ease;
}

#<?php echo esc_attr($uid); ?> .reset:hover {
    background:var(--bh-sand);
}


/* FORMULIER */

#<?php echo esc_attr($uid); ?> .form {
    display:none;
    margin-top:20px;
    padding-top:20px;
    border-top:1px solid var(--bh-sand-line);
}

#<?php echo esc_attr($uid); ?> .form.open {
    display:block;
}

#<?php echo esc_attr($uid); ?> .grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}

#<?php echo esc_attr($uid); ?> .field.full {
    grid-column:1/-1;
}

#<?php echo esc_attr($uid); ?> .field label {
    display:block;
    font-size:10px;
    text-transform:uppercase;
    letter-spacing:.8px;
    color:#607588;
    margin-bottom:6px;
}

#<?php echo esc_attr($uid); ?> .field input,
#<?php echo esc_attr($uid); ?> .field select {
    width:100%;
    border:1px solid var(--bh-sand-line);
    border-radius:8px;
    background:var(--bh-sand);
    padding:11px;
    font-family:'IBM Plex Sans',sans-serif;
    font-size:13px;
    color:var(--bh-ink);
}

#<?php echo esc_attr($uid); ?> .field input:focus,
#<?php echo esc_attr($uid); ?> .field select:focus {
    outline:2px solid var(--bh-sea);
    outline-offset:1px;
    background:#fff;
}

#<?php echo esc_attr($uid); ?> .send {
    margin-top:16px;
    background:var(--bh-terracotta);
}

#<?php echo esc_attr($uid); ?> .send:hover:not(:disabled) {
    background:#a35f43;
}

#<?php echo esc_attr($uid); ?> .status {
    display:none;
    margin-top:14px;
    padding:12px 14px;
    border-radius:0;
    font-size:12px;
    line-height:1.5;
}

#<?php echo esc_attr($uid); ?> .status.success {
    display:block;
    background:#eef2ec;
    color:#4b5d47;
}

#<?php echo esc_attr($uid); ?> .status.error {
    display:block;
    background:#f8eeee;
    color:#8a3434;
}

#<?php echo esc_attr($uid); ?> .hp {
    position:absolute !important;
    left:-9999px !important;
    width:1px !important;
    height:1px !important;
    overflow:hidden !important;
}


/* MOBIEL */

@media(max-width:767px) {

    #<?php echo esc_attr($uid); ?> {
        padding:20px;
    }

    #<?php echo esc_attr($uid); ?> .prices,
    #<?php echo esc_attr($uid); ?> .main,
    #<?php echo esc_attr($uid); ?> .grid {
        grid-template-columns:1fr;
    }

    #<?php echo esc_attr($uid); ?> .field.full {
        grid-column:auto;
    }
}


#<?php echo esc_attr($uid); ?> .primary,
#<?php echo esc_attr($uid); ?> .send,
#<?php echo esc_attr($uid); ?> .nav {
    background:#315779;color:#fff;border:0;border-radius:0;
    transition:background-color .25s ease,color .25s ease;
}
#<?php echo esc_attr($uid); ?> .primary:hover:not(:disabled),
#<?php echo esc_attr($uid); ?> .primary:focus-visible,
#<?php echo esc_attr($uid); ?> .send:hover:not(:disabled),
#<?php echo esc_attr($uid); ?> .send:focus-visible,
#<?php echo esc_attr($uid); ?> .nav:hover:not(:disabled),
#<?php echo esc_attr($uid); ?> .reset:hover {
    background:#a7d6ff;color:#315779;
}
#<?php echo esc_attr($uid); ?> .primary:disabled,
#<?php echo esc_attr($uid); ?> .send:disabled {background:#dce5ec;color:#657889;cursor:default;}
#<?php echo esc_attr($uid); ?> .day:hover:not(:disabled) {background:#e7f3fd;}
#<?php echo esc_attr($uid); ?> .day.selected {background:#315779;color:#fff;}
#<?php echo esc_attr($uid); ?> .day.selected.low:after {background:var(--bh-sage);}
#<?php echo esc_attr($uid); ?> .day.selected.mid:after {background:var(--bh-gold);}
#<?php echo esc_attr($uid); ?> .day.selected.high:after {background:var(--bh-terracotta);}
#<?php echo esc_attr($uid); ?> button:focus-visible {outline:2px solid #315779;outline-offset:3px;}
#<?php echo esc_attr($uid); ?> .main > * {min-width:0;}
#<?php echo esc_attr($uid); ?> .field input,
#<?php echo esc_attr($uid); ?> .field select {font-size:16px;}


/* Keep Elementor's general button padding out of the calendar grid. */
#<?php echo esc_attr($uid); ?> {width:100%;min-width:0;container-type:inline-size;}
#<?php echo esc_attr($uid); ?> .weekdays,
#<?php echo esc_attr($uid); ?> .days {grid-template-columns:repeat(7,minmax(0,1fr));width:100%;min-width:0;gap:0;}
#<?php echo esc_attr($uid); ?> .day {
    display:block;width:100%;min-width:0;max-width:100%;margin:0;
    padding:8px 0 18px;line-height:1.25;letter-spacing:0;
    min-height:48px;font-size:15px;
}
#<?php echo esc_attr($uid); ?> .nav {
    display:flex;align-items:center;justify-content:center;
    width:38px;min-width:38px;max-width:38px;height:38px;min-height:38px;
    flex:0 0 38px;padding:0;margin:0;line-height:1;letter-spacing:0;
}
#<?php echo esc_attr($uid); ?> .calhead {gap:8px;}
#<?php echo esc_attr($uid); ?> .month {min-width:0;text-align:center;line-height:1.2;}
#<?php echo esc_attr($uid); ?> .weekdays div {min-width:0;font-size:11px;letter-spacing:0;}
#<?php echo esc_attr($uid); ?> .pricebox,
#<?php echo esc_attr($uid); ?> .card,
#<?php echo esc_attr($uid); ?> .datebox {min-width:0;}
#<?php echo esc_attr($uid); ?> .primary,
#<?php echo esc_attr($uid); ?> .send,
#<?php echo esc_attr($uid); ?> .reset {white-space:normal;line-height:1.4;}
@media(max-width:767px) {
    #<?php echo esc_attr($uid); ?> {padding:12px;}
    #<?php echo esc_attr($uid); ?> .main,
    #<?php echo esc_attr($uid); ?> .grid {grid-template-columns:minmax(0,1fr);gap:16px;}
    #<?php echo esc_attr($uid); ?> .card {padding:12px;}
    #<?php echo esc_attr($uid); ?> .pricebox {padding:12px 10px;}
    #<?php echo esc_attr($uid); ?> .prices {gap:8px;margin-bottom:16px;}
    #<?php echo esc_attr($uid); ?> .ptitle {font-size:12px;letter-spacing:.5px;}
    #<?php echo esc_attr($uid); ?> .psub,
    #<?php echo esc_attr($uid); ?> .legend {font-size:12px;}
    #<?php echo esc_attr($uid); ?> .legend {gap:10px;margin-top:12px;}
    #<?php echo esc_attr($uid); ?> .month {font-size:22px;}
    #<?php echo esc_attr($uid); ?> .title {font-size:24px;}
    #<?php echo esc_attr($uid); ?> .msg,
    #<?php echo esc_attr($uid); ?> .dvalue,
    #<?php echo esc_attr($uid); ?> .resultrow {font-size:14px;}
    #<?php echo esc_attr($uid); ?> .dlabel,
    #<?php echo esc_attr($uid); ?> .field label {font-size:12px;letter-spacing:.3px;}
    #<?php echo esc_attr($uid); ?> .datebox {padding:10px 8px;}
}
/* Also stack correctly in narrow Elementor columns and editor previews. */
@container(max-width:600px) {
    #<?php echo esc_attr($uid); ?> .main,
    #<?php echo esc_attr($uid); ?> .grid {grid-template-columns:minmax(0,1fr);gap:16px;}
    #<?php echo esc_attr($uid); ?> .field.full {grid-column:auto;}
    #<?php echo esc_attr($uid); ?> .card {padding:12px;}
    #<?php echo esc_attr($uid); ?> .prices {grid-template-columns:minmax(0,1fr);gap:8px;margin-bottom:16px;}
    #<?php echo esc_attr($uid); ?> .pricebox {padding:12px 10px;}
}


#<?php echo esc_attr($uid); ?> .house-rules {
    border-top:1px solid var(--bh-sand-line);margin-top:22px;padding-top:18px;
}
#<?php echo esc_attr($uid); ?> .house-rules h3 {
    margin:0 0 10px;color:var(--bh-sea-dark);font-size:23px;font-weight:500;line-height:1.25;
}
#<?php echo esc_attr($uid); ?> .house-rules ul {
    margin:0;padding:0 0 0 18px;list-style:disc;color:var(--bh-ink);font-size:14px;line-height:1.6;
}
#<?php echo esc_attr($uid); ?> .house-rules li {margin:0 0 7px;padding:0;overflow-wrap:break-word;}

#<?php echo esc_attr($uid); ?> .payment-terms {
    margin-top:22px;padding-top:18px;
}
#<?php echo esc_attr($uid); ?> .payment-terms h3 {
    margin:0 0 10px;color:var(--bh-sea-dark);font-size:23px;font-weight:500;line-height:1.25;
}
#<?php echo esc_attr($uid); ?> .payment-terms ul {
    margin:0;padding:0 0 0 18px;list-style:disc;color:var(--bh-ink);font-size:14px;line-height:1.6;
}
#<?php echo esc_attr($uid); ?> .payment-terms li {margin:0 0 7px;padding:0;overflow-wrap:break-word;}

#<?php echo esc_attr($uid); ?> .deposit-note {font-family:'IBM Plex Sans',sans-serif;font-size:14px;line-height:1.5;color:var(--bh-ink);margin:6px 0 0;}
</style>


<div id="<?php echo esc_attr($uid); ?>" lang="<?php echo esc_attr($lang); ?>">


    <p class="msg" style="margin:0 0 16px;"><?php echo esc_html(bh1_t('Minimaal verblijf: 6 nachten.', $lang)); ?></p>

    <!-- PRIJZEN -->

    <div class="prices">

        <div class="pricebox low">

            <div class="ptitle">
                <?php echo esc_html(bh1_t('Laagseizoen', $lang)); ?>
            </div>

            <div class="pvalue">
                € 1.410
            </div>

            <div class="psub">
                <?php echo esc_html(bh1_t('per week', $lang)); ?>
            </div>

        </div>


        <div class="pricebox mid">

            <div class="ptitle">
                <?php echo esc_html(bh1_t('Middenseizoen', $lang)); ?>
            </div>

            <div class="pvalue">
                € 1.760
            </div>

            <div class="psub">
                <?php echo esc_html(bh1_t('per week', $lang)); ?>
            </div>

        </div>


        <div class="pricebox high">

            <div class="ptitle">
                <?php echo esc_html(bh1_t('Hoogseizoen', $lang)); ?>
            </div>

            <div class="pvalue">
                € 2.200
            </div>

            <div class="psub">
                <?php echo esc_html(bh1_t('per week', $lang)); ?>
            </div>

        </div>

    </div>



    <p class="deposit-note" style="margin:0 0 18px;"><?php echo esc_html(bh1_t('Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.', $lang)); ?></p>

    <div class="main">


        <!-- KALENDER -->

        <div>

            <div class="card">

                <div class="calhead">

                    <button
                        type="button"
                        class="nav prev" aria-label="<?php echo esc_attr(bh1_t('Vorige maand', $lang)); ?>"
                    >
                        ‹
                    </button>


                    <div class="month"></div>


                    <button
                        type="button"
                        class="nav next" aria-label="<?php echo esc_attr(bh1_t('Volgende maand', $lang)); ?>"
                    >
                        ›
                    </button>

                </div>


                <div class="weekdays">

                    <div><?php echo esc_html(bh1_t('Ma', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Di', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Wo', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Do', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Vr', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Za', $lang)); ?></div>
                    <div><?php echo esc_html(bh1_t('Zo', $lang)); ?></div>

                </div>


                <div class="days"></div>

            </div>


            <div class="legend">

                <span>
                    <i class="dot low"></i>
                    <?php echo esc_html(bh1_t('Laag', $lang)); ?>
                </span>

                <span>
                    <i class="dot mid"></i>
                    <?php echo esc_html(bh1_t('Midden', $lang)); ?>
                </span>

                <span>
                    <i class="dot high"></i>
                    <?php echo esc_html(bh1_t('Hoog', $lang)); ?>
                </span>

                <span>
                    <i class="dot booked"></i>
                    <?php echo esc_html(bh1_t('Bezet', $lang)); ?>
                </span>

            </div>

        </div>



        <!-- RESULTAAT -->

        <div class="card">

            <div class="title">
                <?php echo esc_html(bh1_t('Bereken je verblijf', $lang)); ?>
            </div>


            <div class="selection">

                <div class="datebox">

                    <div class="dlabel">
                        <?php echo esc_html(bh1_t('Aankomst', $lang)); ?>
                    </div>

                    <div class="dvalue arrival">
                        <?php echo esc_html(bh1_t('Selecteer', $lang)); ?>
                    </div>

                </div>


                <div class="datebox">

                    <div class="dlabel">
                        <?php echo esc_html(bh1_t('Vertrek', $lang)); ?>
                    </div>

                    <div class="dvalue departure">
                        <?php echo esc_html(bh1_t('Selecteer', $lang)); ?>
                    </div>

                </div>

            </div>


            <div class="calculation">

                <div class="msg">
                    <?php echo esc_html(bh1_t('Kies je aankomstdatum en daarna je vertrekdatum.', $lang)); ?>
                </div>

            </div>


            <button
                type="button"
                class="primary"
                disabled
            >
                <?php echo esc_html(bh1_t('Aanvraag doen', $lang)); ?>
            </button>


            <button
                type="button"
                class="reset"
            >
                <?php echo esc_html(bh1_t('Nieuwe data kiezen', $lang)); ?>
            </button>



            <!-- FORMULIER -->

            <form class="form">


                <div class="grid">


                    <div class="field">

                        <label for="<?php echo esc_attr($uid); ?>-first_name">
<?php echo esc_html(bh1_t('Voornaam *', $lang)); ?>
                        </label>

                        <input
                            type="text"
                            name="first_name" id="<?php echo esc_attr($uid); ?>-first_name"
                            required
                        >

                    </div>


                    <div class="field">

                        <label for="<?php echo esc_attr($uid); ?>-last_name">
<?php echo esc_html(bh1_t('Achternaam *', $lang)); ?>
                        </label>

                        <input
                            type="text"
                            name="last_name" id="<?php echo esc_attr($uid); ?>-last_name"
                            required
                        >

                    </div>


                    <div class="field full">

                        <label for="<?php echo esc_attr($uid); ?>-email">
<?php echo esc_html(bh1_t('E-mailadres *', $lang)); ?>
                        </label>

                        <input
                            type="email"
                            name="email" id="<?php echo esc_attr($uid); ?>-email"
                            required
                        >

                    </div>


                    <div class="field">

                        <label for="<?php echo esc_attr($uid); ?>-nationality">
<?php echo esc_html(bh1_t('Nationaliteit *', $lang)); ?>
                        </label>

                        <input
                            type="text"
                            name="nationality" id="<?php echo esc_attr($uid); ?>-nationality"
                            required
                        >

                    </div>


                    <div class="field">

                        <label for="<?php echo esc_attr($uid); ?>-persons">
<?php echo esc_html(bh1_t('Aantal personen *', $lang)); ?>
                        </label>

                        <select
                            name="persons" id="<?php echo esc_attr($uid); ?>-persons"
                            required
                        >

                            <option value="">
                                <?php echo esc_html(bh1_t('Kies aantal', $lang)); ?>
                            </option>

                            <option value="1">
                                <?php echo esc_html(bh1_t('1 persoon', $lang)); ?>
                            </option>

                            <option value="2">
                                <?php echo esc_html(bh1_t('2 personen', $lang)); ?>
                            </option>

                            <option value="3">
                                <?php echo esc_html(bh1_t('3 personen', $lang)); ?>
                            </option>

                            <option value="4">
                                <?php echo esc_html(bh1_t('4 personen', $lang)); ?>
                            </option>

                            <option value="5">
                                <?php echo esc_html(bh1_t('5 personen', $lang)); ?>
                            </option>

                            <option value="6">
                                <?php echo esc_html(bh1_t('6 personen', $lang)); ?>
                            </option>

                            <option value="7">
                                <?php echo esc_html(bh1_t('7 personen', $lang)); ?>
                            </option>

                            <option value="8">
                                <?php echo esc_html(bh1_t('8 personen', $lang)); ?>
                            </option>

                        </select>

                    </div>


                </div>


                <!-- SPAMVELD -->

                <div class="hp">

                    <input
                        type="text"
                        name="website"
                        tabindex="-1"
                        autocomplete="off"
                    >

                </div>


                <button
                    type="submit"
                    class="send"
                >
                    <?php echo esc_html(bh1_t('Aanvraag versturen', $lang)); ?>
                </button>


                <div
                    class="status"
                    aria-live="polite"
                ></div>


            </form>

            <section class="house-rules" aria-labelledby="<?php echo esc_attr($uid); ?>-house-rules-title">
                <h3 id="<?php echo esc_attr($uid); ?>-house-rules-title"><?php echo esc_html(bh1_t('Huisregels', $lang)); ?></h3>
                <ul>
                    <li><?php echo esc_html(bh1_t('Roken is niet toegestaan.', $lang)); ?></li>
                    <li><?php echo esc_html(bh1_t('Huisdieren zijn niet toegestaan.', $lang)); ?></li>
                    <li><?php echo esc_html(bh1_t('Feesten, evenementen, vrijgezellenfeesten en luidruchtige bijeenkomsten zijn niet toegestaan.', $lang)); ?></li>
                </ul>
            </section>

            <section class="payment-terms" aria-labelledby="<?php echo esc_attr($uid); ?>-payment-terms-title">
                <h3 id="<?php echo esc_attr($uid); ?>-payment-terms-title"><?php echo esc_html(bh1_t('Betalingsvoorwaarden', $lang)); ?></h3>
                <ul>
                    <li><?php echo esc_html(bh1_t('Bij reservering betaalt u een aanbetaling van 20% van de huursom. Zodra dit bedrag is ontvangen, is uw boeking definitief.', $lang)); ?></li>
                    <li><?php echo esc_html(bh1_t('Uiterlijk 4 weken voor aankomst betaalt u het resterende bedrag (80%), samen met de borg van € 500.', $lang)); ?></li>
                    <li><?php echo esc_html(bh1_t('Boekt u binnen 4 weken voor aankomst, dan betaalt u het volledige bedrag inclusief borg in één keer.', $lang)); ?></li>
                    <li><?php echo esc_html(bh1_t('De borg wordt binnen 14 dagen na vertrek volledig teruggestort, mits het appartement zonder schade en netjes wordt achtergelaten.', $lang)); ?></li>
                </ul>
            </section>



        </div>


    </div>


</div>



<script>

(function() {
    const language = <?php echo wp_json_encode($lang); ?>;
    const locale = <?php echo wp_json_encode(bh1_locale($lang)); ?>;
    const translations = <?php echo wp_json_encode(bh1_translations($lang), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    const t = (text) => translations[text] || text;


    const root =
        document.getElementById(
            <?php echo wp_json_encode($uid); ?>
        );


    if (
        !root ||
        root.dataset.ready === '1'
    ) {
        return;
    }


    root.dataset.ready =
        '1';


    const ajaxUrl =
        <?php echo wp_json_encode($ajax_url); ?>;


    const nonce =
        <?php echo wp_json_encode($nonce); ?>;


    const rates = {

        low:1410,
        mid:1760,
        high:2200

    };


    const periods = [

        ['2027-01-02','2027-01-08','mid'],
        ['2027-01-09','2027-02-05','low'],

        ['2027-02-06','2027-03-12','mid'],

        ['2027-03-13','2027-03-19','low'],
        ['2027-03-20','2027-04-02','mid'],

        ['2027-04-03','2027-05-14','high'],

        ['2027-05-15','2027-05-28','mid'],
        ['2027-05-29','2027-06-11','high'],

        ['2027-06-12','2027-06-18','mid'],
        ['2027-06-19','2027-10-01','high'],

        ['2027-10-02','2027-10-15','low'],
        ['2027-10-16','2027-11-12','mid'],

        ['2027-11-13','2027-12-17','low'],
        ['2027-12-18','2027-12-31','mid']

    ];


    const months = Array.from({length:12}, (_, i) => new Date(Date.UTC(2027,i,1)).toLocaleDateString(locale, {month:'long',timeZone:'UTC'}));


    let year =
        2027;


    let month =
        0;


    let start =
        null;


    let end =
        null;


    let blocked =
        [];


    const days =
        root.querySelector(
            '.days'
        );


    const monthEl =
        root.querySelector(
            '.month'
        );


    const arrival =
        root.querySelector(
            '.arrival'
        );


    const departure =
        root.querySelector(
            '.departure'
        );


    const calculation =
        root.querySelector(
            '.calculation'
        );


    const primary =
        root.querySelector(
            '.primary'
        );


    const form =
        root.querySelector(
            '.form'
        );


    const status =
        root.querySelector(
            '.status'
        );


    const send =
        root.querySelector(
            '.send'
        );


    function makeDate(
        y,
        m,
        d
    ) {

        return new Date(
            Date.UTC(
                y,
                m,
                d
            )
        );
    }


    function dateKey(date) {

        return [

            date.getUTCFullYear(),

            String(
                date.getUTCMonth() + 1
            ).padStart(
                2,
                '0'
            ),

            String(
                date.getUTCDate()
            ).padStart(
                2,
                '0'
            )

        ].join('-');
    }


    function addDay(date) {

        const d =
            new Date(
                date.getTime()
            );


        d.setUTCDate(
            d.getUTCDate() + 1
        );


        return d;
    }


    function getSeason(date) {

        const key =
            dateKey(date);


        for (
            const period
            of periods
        ) {

            if (
                key >= period[0] &&
                key <= period[1]
            ) {

                return period[2];
            }
        }


        return null;
    }


    /*
     * Een boeking 10 t/m 17 juli blokkeert
     * de nachten 10 t/m 16 juli.
     *
     * 17 juli blijft beschikbaar als aankomstdag.
     */

    function isBookedNight(date) {

        const key =
            dateKey(date);


        return blocked.some(

            range =>

                key >= range[0] &&
                key < range[1]

        );
    }


    function rangeIsFree(
        first,
        last
    ) {

        let cursor =
            new Date(
                first.getTime()
            );


        while (
            cursor < last
        ) {

            if (
                isBookedNight(cursor)
            ) {

                return false;
            }


            cursor =
                addDay(cursor);
        }


        return true;
    }


    function formatDate(date) {

        return date.toLocaleDateString(

            locale,

            {

                day:'numeric',
                month:'short',
                year:'numeric',
                timeZone:'UTC'

            }

        );
    }


    function money(value) {

        return new Intl.NumberFormat(

            locale,

            {

                style:'currency',
                currency:'EUR',
                minimumFractionDigits:2

            }

        ).format(value);
    }


    /* =========================
       BEZETTE DATA OPHALEN
    ========================= */

    async function loadBlocked() {

        try {

            const response =
                await fetch(

                    ajaxUrl +
                    '?action=bh1_get_blocked&_=' +
                    Date.now(),

                    {

                        credentials:
                            'same-origin',

                        cache:
                            'no-store'

                    }

                );


            const result =
                await response.json();


            if (
                result.success &&
                result.data &&
                Array.isArray(
                    result.data.ranges
                )
            ) {

                blocked =
                    result.data.ranges;
            }

        }

        catch(error) {

            /*
             * Kalender blijft gewoon werken als
             * ophalen tijdelijk mislukt.
             */

        }


        render();
    }


    /* =========================
       KALENDER
    ========================= */

    function render() {

        days.innerHTML =
            '';


        monthEl.textContent =
            months[month] +
            ' ' +
            year;


        const first =
            makeDate(
                year,
                month,
                1
            );


        const totalDays =
            new Date(

                Date.UTC(
                    year,
                    month + 1,
                    0
                )

            ).getUTCDate();


        let firstWeekday =
            first.getUTCDay() - 1;


        if (
            firstWeekday < 0
        ) {

            firstWeekday =
                6;
        }


        for (
            let i = 0;
            i < firstWeekday;
            i++
        ) {

            days.appendChild(
                document.createElement(
                    'div'
                )
            );
        }


        for (
            let day = 1;
            day <= totalDays;
            day++
        ) {

            const date =
                makeDate(
                    year,
                    month,
                    day
                );


            const season =
                getSeason(date);


            const booked =
                isBookedNight(date);


            const checkoutOnly =
                dateKey(date)
                ===
                '2028-01-01';


            const button =
                document.createElement(
                    'button'
                );


            button.type =
                'button';


            button.className =
                'day';


            button.textContent =
                day;


            if (season) {

                button.classList.add(
                    season
                );
            }


            if (booked) {

                button.classList.add(
                    'booked'
                );


                button.title =
                    t('Bezet');
            }


            let clickable =
                false;


            /*
             * Nieuwe aankomst.
             */

            if (
                !start ||
                end
            ) {

                clickable =
                    !!season &&
                    !booked;
            }


            /*
             * Datum vóór huidige aankomst:
             * wordt eventueel nieuwe aankomst.
             */

            else if (
                date <= start
            ) {

                clickable =
                    !!season &&
                    !booked;
            }


            /*
             * Vertrekdatum.
             */

            else {

                clickable =

                    rangeIsFree(
                        start,
                        date
                    )

                    &&

                    (
                        !!season ||
                        checkoutOnly
                    );
            }


            if (!clickable) {

                button.disabled =
                    true;
            }

            else {

                button.addEventListener(

                    'click',

                    function() {

                        selectDate(
                            date
                        );
                    }

                );
            }


            if (
                start &&
                date.getTime()
                ===
                start.getTime()
            ) {

                button.classList.add(
                    'selected'
                );
            }


            if (
                end &&
                date.getTime()
                ===
                end.getTime()
            ) {

                button.classList.add(
                    'selected'
                );
            }


            if (
                start &&
                end &&
                date > start &&
                date < end
            ) {

                button.classList.add(
                    'inrange'
                );
            }


            days.appendChild(
                button
            );
        }


        root.querySelector(
            '.prev'
        ).disabled =

            year === 2027 &&
            month === 0;


        root.querySelector(
            '.next'
        ).disabled =

            year === 2028 &&
            month === 0;
    }


    /* =========================
       DATUM SELECTEREN
    ========================= */

    function selectDate(date) {
        if (start && end && (end - start) / 86400000 < 6) {
            end = null;
        }

        if (
            !start ||
            end
        ) {

            if (
                !getSeason(date) ||
                isBookedNight(date)
            ) {
                return;
            }


            start =
                date;


            end =
                null;
        }


        else if (
            date <= start
        ) {

            if (
                !getSeason(date) ||
                isBookedNight(date)
            ) {
                return;
            }


            start =
                date;


            end =
                null;
        }


        else {

            if (
                !rangeIsFree(
                    start,
                    date
                )
            ) {
                return;
            }


            end =
                date;
        }


        render();

        updateResult();
    }


    /* =========================
       PRIJS
    ========================= */

    function updateResult() {

        primary.disabled =
            true;


        form.classList.remove(
            'open'
        );


        arrival.textContent =

            start
                ? formatDate(start)
                : t('Selecteer');


        departure.textContent =

            end
                ? formatDate(end)
                : t('Selecteer');


        if (!start) {

            calculation.innerHTML =
                '<div class="msg">' + t('Kies je aankomstdatum.') + '</div>';

            return;
        }


        if (!end) {

            calculation.innerHTML =
                '<div class="msg">' + t('Kies nu je vertrekdatum.') + '</div>';

            return;
        }


        if (
            !rangeIsFree(
                start,
                end
            )
        ) {

            calculation.innerHTML =
                '<div class="msg">' + t('Deze periode is niet meer beschikbaar.') + '</div>';

            return;
        }


        const counts = {

            low:0,
            mid:0,
            high:0

        };


        let cursor =
            new Date(
                start.getTime()
            );


        while (
            cursor < end
        ) {

            const season =
                getSeason(cursor);


            if (!season) {
                return;
            }


            counts[season]++;


            cursor =
                addDay(cursor);
        }


        const nights =

            counts.low +
            counts.mid +
            counts.high;


        if (nights < 6) {
            calculation.innerHTML = '<div class="msg" role="status">' + t('Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.') + '</div>';
            return;
        }

        const total =

            (
                counts.low * rates.low +

                counts.mid * rates.mid +

                counts.high * rates.high

            ) / 7;


        calculation.innerHTML =

            '<div class="resultrow">' +

                '<span>' + t('Verblijf') + '</span>' +

                '<strong>' +

                    nights +
                    ' ' +
                    (
                        nights === 1
                        ? t('nacht')
                        : t('nachten')
                    ) +

                '</strong>' +

            '</div>' +

            '<div class="total">' +

                '<div class="tlabel">' +
                    t('Totaal voor deze periode') +
                '</div>' +

                '<div class="tprice">' +
                    money(total) +
                '</div>' +
                '<p class="deposit-note">' + t('Aanbetaling 20%, restant + borg € 500 uiterlijk 4 weken voor aankomst.') + '</p>' +

            '</div>';


        primary.disabled =
            false;
    }


    /* =========================
       NAVIGATIE
    ========================= */

    root.querySelector(
        '.prev'
    ).addEventListener(

        'click',

        function() {

            month--;


            if (
                month < 0
            ) {

                month =
                    11;


                year--;
            }


            render();
        }

    );


    root.querySelector(
        '.next'
    ).addEventListener(

        'click',

        function() {

            month++;


            if (
                month > 11
            ) {

                month =
                    0;


                year++;
            }


            render();
        }

    );


    /* formulier openen */

    primary.addEventListener(

        'click',

        function() {

            if (
                start &&
                end
            ) {

                form.classList.add(
                    'open'
                );
            }
        }

    );


    /* reset */

    root.querySelector(
        '.reset'
    ).addEventListener(

        'click',

        function() {

            start =
                null;


            end =
                null;


            year =
                2027;


            month =
                0;


            form.reset();


            form.classList.remove(
                'open'
            );


            status.className =
                'status';


            status.textContent =
                '';


            send.style.display =
                '';


            render();

            updateResult();
        }

    );


    /* =========================
       AANVRAAG VERSTUREN
    ========================= */

    form.addEventListener(

        'submit',

        async function(event) {

            event.preventDefault();


            if (
                !start ||
                !end
            ) {
                return;
            }


            if ((end - start) / 86400000 < 6) {
                status.className = 'status error';
                status.textContent = t('Het minimumverblijf is 6 nachten. Kies een latere vertrekdatum.');
                return;
            }

            if (
                !form.reportValidity()
            ) {
                return;
            }


            send.disabled =
                true;


            send.textContent =
                t('Aanvraag versturen...');


            status.className =
                'status';


            status.textContent =
                '';


            const data =
                new FormData(form);
            data.append('language', language);


            data.append(
                'action',
                'bh1_send_request'
            );


            data.append(
                'nonce',
                nonce
            );


            data.append(
                'arrival',
                dateKey(start)
            );


            data.append(
                'departure',
                dateKey(end)
            );


            try {

                const response =
                    await fetch(

                        ajaxUrl,

                        {

                            method:'POST',

                            body:data,

                            credentials:
                                'same-origin'

                        }

                    );


                const result = await response.json().catch(() => { throw new Error(t('De aanvraag kon niet worden verstuurd.')); });


                if (
                    !result.success
                ) {

                    throw new Error(

                        result.data &&
                        result.data.message

                            ? result.data.message

                            : t('De aanvraag kon niet worden verstuurd.')

                    );
                }


                status.className =
                    'status success';


                status.textContent =
                    result.data.message;


                send.style.display =
                    'none';

            }


            catch(error) {

                status.className =
                    'status error';


                status.textContent =
                    error instanceof TypeError ? t('De aanvraag kon niet worden verstuurd.') : error.message;
            }


            finally {

                send.disabled =
                    false;


                if (
                    send.style.display
                    !==
                    'none'
                ) {

                    send.textContent =
                        t('Aanvraag versturen');
                }
            }
        }

    );


    render();

    updateResult();

    loadBlocked();


})();

</script>

<?php

    return ob_get_clean();
}


foreach (['beachhouse_boeking','beachhouse_boekingENGELS','beachhouse_boekingFRANS','beachhouse_boekingSPAANS','beachhouse_boekingengels','beachhouse_boekingfrans','beachhouse_boekingspaans'] as $booking_shortcode) {
    add_shortcode($booking_shortcode, 'bh1_shortcode');
}

} // einde function_exists('bh1_shortcode') guard


/* =========================================================
   BEACHHOUSE BEHEER
   ALLEEN WORDPRESS DASHBOARD
   ========================================================= */

/*
 * Deze hele snippet staat in een function_exists() check.
 * Als dit bestand om wat voor reden dan ook een tweede keer
 * wordt uitgevoerd (bijv. door een dubbele snippet, of doordat
 * WPCode/Elementor de code twee keer laadt), doet PHP dan
 * niets in plaats van vast te lopen met een fatale
 * "Cannot redeclare function" fout. Dat was vermoedelijk de
 * reden waarom WPCode een snippet automatisch uitschakelde.
 */

if (!function_exists('bh2_admin_page')) {

/* =========================================================
   OPSLAG
========================================================= */

function bh2_store_key() {

    return 'bh_booking_items_v1';
}


function bh2_migrate_store() {

    $key =
        bh2_store_key();


    $current =
        get_option(
            $key,
            null
        );


    if (is_array($current)) {
        return;
    }


    $merged = [];


    foreach (
        [
            'bhscb_bookings',
            'bhs_beachhouse_bookings'
        ]
        as $old_key
    ) {

        $old =
            get_option(
                $old_key,
                []
            );


        if (!is_array($old)) {
            continue;
        }


        foreach (
            $old
            as $item
        ) {

            if (!is_array($item)) {
                continue;
            }


            $id =
                $item['id']
                ??
                wp_generate_uuid4();


            $item['id'] =
                $id;


            $merged[$id] =
                $item;
        }
    }


    update_option(
        $key,
        array_values($merged),
        false
    );
}


function bh2_get_bookings() {

    bh2_migrate_store();


    $items =
        get_option(
            bh2_store_key(),
            []
        );


    return
        is_array($items)
        ? $items
        : [];
}


function bh2_save_bookings($items) {

    return update_option(
        bh2_store_key(),
        array_values($items),
        false
    );
}


/* =========================================================
   DATUMCONTROLE
========================================================= */

function bh2_valid_date($date) {

    if (
        !is_string($date)

        ||

        !preg_match(
            '/^\d{4}-\d{2}-\d{2}$/',
            $date
        )
    ) {

        return false;
    }


    $date_object =
        DateTimeImmutable::createFromFormat(

            '!Y-m-d',

            $date,

            new DateTimeZone('UTC')

        );


    return

        $date_object

        &&

        $date_object->format('Y-m-d')
            ===
            $date;
}


/* =========================================================
   AANTAL NACHTEN
========================================================= */

function bh2_nights(
    $arrival,
    $departure
) {

    if (
        !bh2_valid_date($arrival)

        ||

        !bh2_valid_date($departure)
    ) {

        return 0;
    }


    $start =
        new DateTimeImmutable(

            $arrival,

            new DateTimeZone('UTC')

        );


    $end =
        new DateTimeImmutable(

            $departure,

            new DateTimeZone('UTC')

        );


    if (
        $end <= $start
    ) {

        return 0;
    }


    return
        (int)
        $start
            ->diff($end)
            ->days;
}


/* =========================================================
   OVERLAP CONTROLEREN
========================================================= */

function bh2_overlap(
    $arrival,
    $departure,
    $exclude_id = ''
) {

    foreach (
        bh2_get_bookings()
        as $booking
    ) {

        /*
         * Alleen bevestigde boekingen blokkeren.
         */

        if (
            ($booking['status'] ?? '')
                !==
                'confirmed'
        ) {

            continue;
        }


        /*
         * Eigen boeking overslaan.
         */

        if (
            $exclude_id

            &&

            ($booking['id'] ?? '')
                ===
                $exclude_id
        ) {

            continue;
        }


        $existing_arrival =
            $booking['arrival']
            ?? '';


        $existing_departure =
            $booking['departure']
            ?? '';


        if (
            !$existing_arrival ||
            !$existing_departure
        ) {

            continue;
        }


        /*
         * Vertrekdag is weer beschikbaar.
         */

        if (
            $arrival < $existing_departure

            &&

            $departure > $existing_arrival
        ) {

            return true;
        }
    }


    return false;
}


/* =========================================================
   MENU LINKS IN WORDPRESS
========================================================= */

function bh2_menu() {

    add_menu_page(

        'Beachhouse boekingen',

        'Beachhouse boekingen',

        'manage_options',

        'beachhouse-bookingen',

        'bh2_admin_page',

        'dashicons-calendar-alt',

        26

    );
}


add_action(
    'admin_menu',
    'bh2_menu'
);


/* =========================================================
   ACTIES
========================================================= */

/* Authenticated endpoint for private notes and a personal checkmark. */
function bh2_ajax_save_internal() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Geen toegang.'], 403);
    }
    if (!check_ajax_referer('bh2_admin_action', '_wpnonce', false)) {
        wp_send_json_error(['message' => 'Sessie verlopen. Kopieer je opmerking en vernieuw de pagina.'], 403);
    }
    $_POST['bh2_action'] = 'internal';
    $message = bh2_process_action();
    if (in_array($message, ['De interne gegevens zijn al opgeslagen.', 'Interne opmerking en vinkje opgeslagen.'], true)) {
        wp_send_json_success(['message' => 'Bewaard']);
    }
    wp_send_json_error(['message' => $message ?: 'Bewaren is niet gelukt.']);
}
add_action('wp_ajax_bh2_save_internal', 'bh2_ajax_save_internal');

function bh2_process_action() {

    if (
        !current_user_can(
            'manage_options'
        )
    ) {

        return '';
    }


    if (
        empty(
            $_POST['bh2_action']
        )
    ) {

        return '';
    }


    check_admin_referer(
        'bh2_admin_action'
    );


    $action =
        sanitize_text_field(
            wp_unslash(
                $_POST['bh2_action']
            )
        );


    $items =
        bh2_get_bookings();


    /* Private follow-up fields; do not change booking status or send mail. */
    if ($action === 'internal') {
        if (!isset($_POST['booking_id']) || !is_string($_POST['booking_id']) ||
            (isset($_POST['internal_note']) && !is_string($_POST['internal_note']))) {
            return 'Ongeldige gegevens.';
        }
        $id = sanitize_text_field(wp_unslash($_POST['booking_id']));
        $note = sanitize_textarea_field(wp_unslash($_POST['internal_note'] ?? ''));
        $handled = isset($_POST['internal_handled']) && $_POST['internal_handled'] === '1';
        foreach ($items as $index => $booking) {
            if (($booking['id'] ?? '') !== $id) {
                continue;
            }
            if (($booking['internal_note'] ?? '') === $note &&
                (bool) ($booking['internal_handled'] ?? false) === $handled) {
                return 'De interne gegevens zijn al opgeslagen.';
            }
            $items[$index]['internal_note'] = $note;
            $items[$index]['internal_handled'] = $handled;
            return bh2_save_bookings($items)
                ? 'Interne opmerking en vinkje opgeslagen.'
                : 'Opslaan is niet gelukt. Probeer het opnieuw.';
        }
        return 'Boeking niet gevonden.';
    }

    /* =========================
       STATUS WIJZIGEN
    ========================= */

    if (
        $action === 'status'
    ) {

        $id =
            sanitize_text_field(
                wp_unslash(
                    $_POST['booking_id']
                    ?? ''
                )
            );


        $status =
            sanitize_text_field(
                wp_unslash(
                    $_POST['status']
                    ?? ''
                )
            );


        if (
            !in_array(

                $status,

                [
                    'request',
                    'confirmed',
                    'cancelled'
                ],

                true

            )
        ) {

            return
                'Ongeldige status.';
        }


        foreach (
            $items
            as $index => $booking
        ) {

            if (
                ($booking['id'] ?? '')
                    !==
                    $id
            ) {

                continue;
            }


            /*
             * Bij bevestigen controleren of
             * er geen andere bevestigde boeking
             * over deze periode heen ligt.
             */

            if (
                $status === 'confirmed'

                &&

                bh2_overlap(

                    $booking['arrival']
                    ?? '',

                    $booking['departure']
                    ?? '',

                    $id

                )
            ) {

                return
                    'Deze boeking overlapt met een andere bevestigde boeking.';
            }


            $items[$index]['status'] =
                $status;


            bh2_save_bookings(
                $items
            );


            if (
                $status === 'confirmed'
            ) {

                return
                    'Boeking bevestigd. De periode is nu geblokkeerd in de kalender.';
            }


            if (
                $status === 'cancelled'
            ) {

                return
                    'Boeking geannuleerd. De periode is weer beschikbaar.';
            }


            return
                'Status gewijzigd naar aanvraag.';
        }


        return
            'Boeking niet gevonden.';
    }


    /* =========================
       VERWIJDEREN
    ========================= */

    if (
        $action === 'delete'
    ) {

        $id =
            sanitize_text_field(
                wp_unslash(
                    $_POST['booking_id']
                    ?? ''
                )
            );


        $items =
            array_values(

                array_filter(

                    $items,

                    function($booking)
                    use ($id) {

                        return
                            ($booking['id'] ?? '')
                            !==
                            $id;
                    }

                )

            );


        bh2_save_bookings(
            $items
        );


        return
            'Boeking verwijderd.';
    }


    /* =========================
       HANDMATIG TOEVOEGEN
    ========================= */

    if (
        $action === 'add'
    ) {

        $name =
            sanitize_text_field(
                wp_unslash(
                    $_POST['guest_name']
                    ?? ''
                )
            );


        $email =
            sanitize_email(
                wp_unslash(
                    $_POST['guest_email']
                    ?? ''
                )
            );


        $arrival =
            sanitize_text_field(
                wp_unslash(
                    $_POST['arrival']
                    ?? ''
                )
            );


        $departure =
            sanitize_text_field(
                wp_unslash(
                    $_POST['departure']
                    ?? ''
                )
            );


        $persons =
            absint(
                $_POST['persons']
                ?? 1
            );


        if (!$name) {

            return
                'Vul de naam van de gast in.';
        }


        if (
            !bh2_valid_date($arrival)

            ||

            !bh2_valid_date($departure)

            ||

            $departure <= $arrival
        ) {

            return
                'Vul geldige aankomst- en vertrekdata in.';
        }


        if (
            $persons < 1 ||
            $persons > 8
        ) {

            return
                'Aantal personen moet tussen 1 en 8 liggen.';
        }


        if (
            bh2_overlap(
                $arrival,
                $departure
            )
        ) {

            return
                'Deze periode overlapt met een bestaande bevestigde boeking.';
        }


        $items[] = [

            'id' =>
                wp_generate_uuid4(),

            'created' =>
                current_time('mysql'),

            'source' =>
                'manual',

            'first_name' =>
                $name,

            'last_name' =>
                '',

            'email' =>
                $email,

            'nationality' =>
                '',

            'persons' =>
                $persons,

            'arrival' =>
                $arrival,

            'departure' =>
                $departure,

            'nights' =>
                bh2_nights(
                    $arrival,
                    $departure
                ),

            /*
             * Voor handmatige boekingen hoeft
             * geen prijs bekend te zijn.
             */

            'total' =>
                '',

            /*
             * Handmatig toegevoegd =
             * direct bevestigd.
             */

            'status' =>
                'confirmed'

        ];


        bh2_save_bookings(
            $items
        );


        return
            'Boeking toegevoegd. De periode is nu geblokkeerd in de kalender.';
    }


    return '';
}


/* =========================================================
   BEHEERPAGINA
========================================================= */

function bh2_admin_page() {

    if (
        !current_user_can(
            'manage_options'
        )
    ) {

        wp_die(
            'Geen toegang.'
        );
    }


    $notice =
        bh2_process_action();


    $items =
        bh2_get_bookings();


    usort(

        $items,

        function($a, $b) {

            return strcmp(

                $a['arrival']
                ?? '',

                $b['arrival']
                ?? ''

            );
        }

    );


    ?>


<div class="wrap">


    <h1>
        Beachhouse boekingen
    </h1>


    <p>

        Een <strong>aanvraag</strong> blokkeert nog niets.

        Alleen <strong>Bevestigd</strong> blokkeert de kalender.

    </p>


    <?php if ($notice): ?>

        <div
            class="notice notice-info is-dismissible"
        >

            <p>
                <?php
                echo esc_html($notice);
                ?>
            </p>

        </div>

    <?php endif; ?>



    <!-- HANDMATIG TOEVOEGEN -->

    <div
        style="
            max-width:900px;
            background:#fff;
            border:1px solid #dcdcde;
            border-radius:5px;
            padding:20px;
            margin:25px 0;
        "
    >


        <h2 style="margin-top:0;">
            Handmatig boeking toevoegen
        </h2>


        <p>

            Bijvoorbeeld voor een boeking via WhatsApp,
            telefoon, Airbnb of een andere website.

            Deze wordt direct als bevestigd opgeslagen.

        </p>


        <form method="post">


            <?php
            wp_nonce_field(
                'bh2_admin_action'
            );
            ?>


            <input
                type="hidden"
                name="bh2_action"
                value="add"
            >


            <table class="form-table">


                <tr>

                    <th>
                        Naam gast
                    </th>

                    <td>

                        <input
                            type="text"
                            name="guest_name"
                            class="regular-text"
                            required
                        >

                    </td>

                </tr>


                <tr>

                    <th>
                        E-mailadres
                    </th>

                    <td>

                        <input
                            type="email"
                            name="guest_email"
                            class="regular-text"
                        >

                    </td>

                </tr>


                <tr>

                    <th>
                        Aankomst
                    </th>

                    <td>

                        <input
                            type="date"
                            name="arrival"
                            min="2027-01-02"
                            max="2027-12-31"
                            required
                        >

                    </td>

                </tr>


                <tr>

                    <th>
                        Vertrek
                    </th>

                    <td>

                        <input
                            type="date"
                            name="departure"
                            min="2027-01-03"
                            max="2028-01-01"
                            required
                        >

                    </td>

                </tr>


                <tr>

                    <th>
                        Aantal personen
                    </th>

                    <td>

                        <select
                            name="persons"
                        >

                            <?php
                            for (
                                $i = 1;
                                $i <= 8;
                                $i++
                            ):
                            ?>

                                <option
                                    value="<?php
                                        echo esc_attr($i);
                                    ?>"
                                >

                                    <?php
                                    echo esc_html($i);
                                    ?>

                                </option>

                            <?php endfor; ?>

                        </select>

                    </td>

                </tr>


            </table>


            <?php
            submit_button(
                'Boeking toevoegen'
            );
            ?>


        </form>


    </div>



    <!-- AANVRAGEN -->

    <h2>
        Aanvragen en boekingen
    </h2>


    <?php if (!$items): ?>


        <div
            style="
                background:#fff;
                border:1px solid #dcdcde;
                padding:20px;
                max-width:900px;
            "
        >

            Nog geen aanvragen of boekingen.

        </div>


    <?php else: ?>


        <table class="widefat striped">


            <thead>

                <tr>

                    <th>Gast</th>

                    <th>Contact</th>

                    <th>Aankomst</th>

                    <th>Vertrek</th>

                    <th>Personen</th>

                    <th>Nachten</th>

                    <th>Prijs</th>

                    <th>Status</th>

                    <th>Intern — alleen voor jou</th>

                    <th>Actie</th>

                </tr>

            </thead>


            <tbody>


            <?php
            foreach (
                $items
                as $booking
            ):
            ?>


                <?php

                $name =
                    trim(

                        ($booking['first_name'] ?? '') .
                        ' ' .
                        ($booking['last_name'] ?? '')

                    );


                $email =
                    $booking['email']
                    ?? '';


                $status =
                    $booking['status']
                    ?? 'request';


                $price =
                    $booking['total']
                    ?? '';

                ?>


                <tr>


                    <td>

                        <strong>

                            <?php
                            echo esc_html(
                                $name ?: '-'
                            );
                            ?>

                        </strong>


                        <?php
                        if (
                            !empty(
                                $booking['nationality']
                            )
                        ):
                        ?>

                            <br>

                            <small>

                                <?php
                                echo esc_html(
                                    $booking['nationality']
                                );
                                ?>

                            </small>

                        <?php endif; ?>

                    </td>


                    <td>

                        <?php if ($email): ?>

                            <a
                                href="mailto:<?php
                                echo esc_attr($email);
                                ?>"
                            >

                                <?php
                                echo esc_html($email);
                                ?>

                            </a>

                        <?php else: ?>

                            —

                        <?php endif; ?>
                        <?php if (isset($booking['language'])): ?>
                            <br><small>Taal gast: <?php echo esc_html(['nl'=>'Nederlands','en'=>'Engels','fr'=>'Frans','es'=>'Spaans'][$booking['language']] ?? 'Nederlands'); ?></small>
                        <?php endif; ?>
                        <?php if (isset($booking['guest_mail_sent']) && !$booking['guest_mail_sent']): ?>
                            <br><small style="color:#b32d2e;">Bevestigingsmail aan gast niet verstuurd. Neem zelf contact op.</small>
                        <?php endif; ?>
                        <?php if (isset($booking['owner_mail_sent']) && !$booking['owner_mail_sent']): ?>
                            <br><small style="color:#b32d2e;">Meldingsmail aan beheerder niet verstuurd.</small>
                        <?php endif; ?>


                    </td>


                    <td>

                        <?php
                        echo esc_html(
                            $booking['arrival']
                            ?? '-'
                        );
                        ?>

                    </td>


                    <td>

                        <?php
                        echo esc_html(
                            $booking['departure']
                            ?? '-'
                        );
                        ?>

                    </td>


                    <td>

                        <?php
                        echo esc_html(
                            $booking['persons']
                            ?? '-'
                        );
                        ?>

                    </td>


                    <td>

                        <?php
                        echo esc_html(
                            $booking['nights']
                            ?? '-'
                        );
                        ?>

                    </td>


                    <td>

                        <?php
                        if (
                            $price !== '' &&
                            is_numeric($price)
                        ):
                        ?>

                            <strong>

                                € <?php
                                echo esc_html(

                                    number_format(
                                        (float) $price,
                                        2,
                                        ',',
                                        '.'
                                    )

                                );
                                ?>

                            </strong>

                        <?php else: ?>

                            —

                        <?php endif; ?>

                    </td>


                    <!-- STATUS -->

                    <td>


                        <form
                            method="post"
                            style="margin:0;"
                        >


                            <?php
                            wp_nonce_field(
                                'bh2_admin_action'
                            );
                            ?>


                            <input
                                type="hidden"
                                name="bh2_action"
                                value="status"
                            >


                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?php
                                    echo esc_attr(
                                        $booking['id']
                                        ?? ''
                                    );
                                ?>"
                            >


                            <select
                                name="status"
                                onchange="
                                    this.form.submit()
                                "
                            >


                                <option
                                    value="request"
                                    <?php
                                    selected(
                                        $status,
                                        'request'
                                    );
                                    ?>
                                >
                                    Aanvraag
                                </option>


                                <option
                                    value="confirmed"
                                    <?php
                                    selected(
                                        $status,
                                        'confirmed'
                                    );
                                    ?>
                                >
                                    Bevestigd
                                </option>


                                <option
                                    value="cancelled"
                                    <?php
                                    selected(
                                        $status,
                                        'cancelled'
                                    );
                                    ?>
                                >
                                    Geannuleerd
                                </option>


                            </select>


                        </form>


                    </td>


                    <!-- INTERNE OPMERKING EN OPVOLGING -->
                    <td style="min-width:230px;">
                        <form method="post" class="bh2-personal-fields" style="margin:0;">
                            <?php wp_nonce_field('bh2_admin_action'); ?>
                            <input type="hidden" name="bh2_action" value="internal">
                            <input type="hidden" name="booking_id" value="<?php echo esc_attr($booking['id'] ?? ''); ?>">
                            <label style="display:block;">
                                <strong>Opmerking</strong>
                                <textarea name="internal_note" rows="3" style="display:block;width:100%;margin:6px 0 10px;" placeholder="Bijvoorbeeld: gebeld, wacht op reactie…"><?php echo esc_textarea($booking['internal_note'] ?? ''); ?></textarea>
                            </label>
                            <label style="display:block;margin-bottom:10px;">
                                <input type="checkbox" name="internal_handled" value="1" <?php checked(!empty($booking['internal_handled'])); ?>>
                                Eigen vinkje
                            </label>
                            <small class="bh2-save-state" role="status" aria-live="polite" style="display:block;color:#646970;"></small>
                        </form>
                    </td>

                    <!-- VERWIJDEREN -->

                    <td>


                        <form
                            method="post"
                            style="margin:0;"
                            onsubmit="
                                return confirm(
                                    'Weet je zeker dat je deze boeking wilt verwijderen?'
                                );
                            "
                        >


                            <?php
                            wp_nonce_field(
                                'bh2_admin_action'
                            );
                            ?>


                            <input
                                type="hidden"
                                name="bh2_action"
                                value="delete"
                            >


                            <input
                                type="hidden"
                                name="booking_id"
                                value="<?php
                                    echo esc_attr(
                                        $booking['id']
                                        ?? ''
                                    );
                                ?>"
                            >


                            <button
                                type="submit"
                                class="button"
                            >
                                Verwijderen
                            </button>


                        </form>


                    </td>


                </tr>


            <?php endforeach; ?>


            </tbody>


        </table>


    <?php endif; ?>


</div>

<script>
(function() {
    const forms = document.querySelectorAll('.bh2-personal-fields');
    let queue = Promise.resolve();
    forms.forEach(function(form) {
        const note = form.querySelector('[name="internal_note"]');
        const mark = form.querySelector('[name="internal_handled"]');
        const state = form.querySelector('.bh2-save-state');
        const snapshot = () => JSON.stringify([note.value, mark.checked]);
        let saved = snapshot();
        let timer;
        let revision = 0;
        let queued = null;
        function save() {
            clearTimeout(timer);
            const value = snapshot();
            if (value === saved && queued === null) { state.textContent = ''; return; }
            if (value === queued) { return; }
            const currentRevision = ++revision;
            queued = value;
            const data = new FormData(form);
            data.set('action', 'bh2_save_internal');
            state.textContent = 'Bewaren…';
            // Serialize saves across rows because bookings share one WordPress option.
            queue = queue.then(async function() {
                try {
                    const response = await fetch(<?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>, {
                        method:'POST', body:data, credentials:'same-origin'
                    });
                    const result = await response.json();
                    if (!result.success) {
                        throw new Error(result.data && result.data.message ? result.data.message : 'Bewaren is niet gelukt.');
                    }
                    saved = value;
                    if (currentRevision === revision && snapshot() === value) {
                        state.textContent = 'Bewaard';
                        state.style.color = '#646970';
                    }
                } catch (error) {
                    if (currentRevision === revision) {
                        state.textContent = 'Niet bewaard. ' + (error instanceof TypeError || error instanceof SyntaxError ? 'Controleer je verbinding en probeer opnieuw door het veld te wijzigen.' : error.message);
                        state.style.color = '#b32d2e';
                    }
                } finally {
                    if (currentRevision === revision) { queued = null; }
                }
            });
        }
        note.addEventListener('input', function() {
            clearTimeout(timer);
            state.textContent = 'Nog niet bewaard';
            timer = setTimeout(save, 600);
        });
        note.addEventListener('blur', save);
        mark.addEventListener('change', save);
        form.addEventListener('submit', function(event) { event.preventDefault(); save(); });
    });
})();
</script>

<?php
}

} // einde function_exists('bh2_admin_page') guard
