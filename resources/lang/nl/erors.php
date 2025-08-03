<?php

return [
    '401' => [
        'title' => 'Ongeautoriseerde Toegang',
        'description' => 'U heeft geldige authenticatiegegevens nodig om toegang te krijgen tot deze pagina. Log in of verifieer uw identiteit.',
    ],
    '403' => [
        'title' => 'Toegang Verboden',
        'description' => 'U heeft niet de benodigde rechten om deze inhoud te bekijken. Als u denkt dat dit een fout is, neem dan contact op met de support.',
    ],
    '404' => [
        'title' => 'Pagina Niet Gevonden',
        'description' => 'De pagina die u zoekt kon niet worden gevonden. Deze is mogelijk verplaatst, verwijderd, of u heeft het adres verkeerd getypt.',
    ],
    '419' => [
        'title' => 'Sessie Verlopen',
        'description' => 'Uw sessie is verlopen door inactiviteit. Ververs de pagina en probeer uw actie opnieuw.',
    ],
    '429' => [
        'title' => 'Te Veel Verzoeken',
        'description' => 'U heeft in korte tijd te veel verzoeken verzonden. Wacht even voordat u het opnieuw probeert.',
    ],
    '500' => [
        'title' => 'Interne Serverfout',
        'description' => 'Oeps! Er is iets misgegaan aan onze kant. We werken eraan om het te verhelpen. Probeer het over een korte tijd opnieuw.',
    ],
    '503' => [
        'title' => 'Dienst Tijdelijk Niet Beschikbaar',
        'description' => 'We zijn bezig met onderhoud of ervaren een tijdelijke overbelasting. We zijn zeer binnenkort weer online!',
    ],

    'ModelNotFoundException' => [
        'title' => 'Bron Niet Gevonden',
        'description' => 'Het specifieke item of record dat u zocht, bestaat niet.',
    ],
    'ViewException' => [
        'title' => 'Fout bij het Renderen van de Weergave',
        'description' => 'Er was een probleem bij het weergeven van de pagina. Meld dit aan de support als het aanhoudt.',
    ],
    'InvalidArgumentException' => [
        'title' => 'Ongeldige Invoer',
        'description' => 'Het systeem heeft een onverwachte of onjuiste waarde ontvangen. Zorg ervoor dat uw invoer geldig is.',
    ],

    'fallback' => [
        'title' => 'Er is een onverwachte fout opgetreden',
        'description' => 'Het spijt ons oprecht, maar er is iets geheel onvoorziens gebeurd. Ons team is op de hoogte gebracht. Probeer het later opnieuw.',
    ],
];