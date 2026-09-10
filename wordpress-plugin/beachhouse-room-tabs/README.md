# Beachhouse Room Tabs

WordPress-plugin: toon één grote foto die verandert zodra een bezoeker
over een kamernaam (tab) beweegt of erop klikt — zoals "Ingang",
"Woonkamer", "Keuken", "Dakterras".

## Installatie

1. Zip de map `beachhouse-room-tabs` (of gebruik `beachhouse-room-tabs.zip`).
2. Ga in WordPress naar **Plugins > Nieuwe plugin toevoegen > Plugin uploaden**.
3. Upload de zip en klik op **Nu installeren**, en daarna **Activeren**.

## Gebruik

1. Na activeren verschijnt in de WordPress-zijbalk een nieuw menu-item
   **Kamer Tabs**.
2. Klik op elk van de 4 tabs (Ingang, Woonkamer, Keuken, Dakterras) en
   kies via **Kies foto** de bijbehorende foto uit de mediabibliotheek.
   De naam op de tab kan je ook aanpassen.
3. Klik op **Wijzigingen opslaan**.
4. Plaats op de gewenste pagina de shortcode:

   ```
   [beachhouse_room_tabs]
   ```

   Optioneel kan de hoogte van de foto worden aangepast (standaard 600px):

   ```
   [beachhouse_room_tabs height="500"]
   ```

Op de website tonen de 4 namen zich als tabs boven één grote foto. Zodra
een bezoeker met de muis over een naam gaat (of erop tikt op mobiel)
wisselt de foto met een zachte overvloeiing.
