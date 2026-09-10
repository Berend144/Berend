# Beachhouse Room Tabs

WordPress-plugin: toon één grote foto die verandert zodra een bezoeker
over een kamernaam (tab) beweegt of erop klikt — zoals "Ingang",
"Woonkamer", "Keuken", "Dakterras".

## Installatie

1. Zip de map `beachhouse-room-tabs` (of gebruik `beachhouse-room-tabs.zip`).
2. Ga in WordPress naar **Plugins > Nieuwe plugin toevoegen > Plugin uploaden**.
3. Upload de zip en klik op **Nu installeren**, en daarna **Activeren**.

## Gebruik

1. Na activeren verschijnt in de WordPress-zijbalk een nieuw menu
   **Kamer Tabs**, met daaronder 4 losse tabs: **Ingang**, **Woonkamer**,
   **Keuken** en **Dakterras**.
2. Klik op één van die 4 tabs en kies via **Kies foto** de bijbehorende
   foto uit de mediabibliotheek. De naam op de tab kan je daar ook
   aanpassen. Klik op **Wijzigingen opslaan**.
3. Op het hoofditem **Overzicht** stel je het bijschrift en de titel boven
   de galerij in (standaard "NEEM EEN KIJKJE" / "In Beachhouse Sueños del
   Mar"), en zie je een miniatuuroverzicht van de 4 kamers.
4. Plaats op de gewenste pagina de shortcode:

   ```
   [beachhouse_room_tabs]
   ```

   Optioneel kunnen titel, bijschrift en hoogte per plaatsing worden
   overschreven:

   ```
   [beachhouse_room_tabs height="500" title="Andere titel" subtitle="ANDERE TEKST"]
   ```

Op de website tonen de 4 namen zich als tabs onder de titel, boven één
grote foto. Zodra een bezoeker met de muis over een naam gaat (of erop
tikt op mobiel) wisselt de foto met een zachte overvloeiing.
