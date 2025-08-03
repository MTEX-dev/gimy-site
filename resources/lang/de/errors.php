<?php

return [
    '401' => [
        'title' => 'Nicht autorisierter Zugriff',
        'description' => 'Sie benötigen gültige Anmeldeinformationen, um auf diese Seite zuzugreifen. Bitte melden Sie sich an oder verifizieren Sie Ihre Identität.',
    ],
    '403' => [
        'title' => 'Zugriff Verboten',
        'description' => 'Sie haben nicht die erforderlichen Berechtigungen, um diesen Inhalt anzuzeigen. Sollten Sie dies für einen Fehler halten, kontaktieren Sie bitte den Support.',
    ],
    '404' => [
        'title' => 'Seite Nicht Gefunden',
        'description' => 'Die gesuchte Seite konnte nicht gefunden werden. Sie wurde möglicherweise verschoben, gelöscht, oder Sie haben die Adresse falsch eingegeben.',
    ],
    '419' => [
        'title' => 'Seite Abgelaufen',
        'description' => 'Ihre Sitzung ist aufgrund von Inaktivität abgelaufen. Bitte aktualisieren Sie die Seite und versuchen Sie Ihre Aktion erneut.',
    ],
    '429' => [
        'title' => 'Zu Viele Anfragen',
        'description' => 'Sie haben in kurzer Zeit zu viele Anfragen gesendet. Bitte warten Sie einen Moment, bevor Sie es erneut versuchen.',
    ],
    '500' => [
        'title' => 'Interner Serverfehler',
        'description' => 'Hoppla! Auf unserer Seite ist etwas schief gelaufen. Wir arbeiten daran, das Problem zu beheben. Bitte versuchen Sie es in Kürze erneut.',
    ],
    '503' => [
        'title' => 'Dienst Nicht Verfügbar',
        'description' => 'Unser Dienst wird gerade gewartet oder ist vorübergehend überlastet. Wir sind in Kürze wieder online!',
    ],

    'ModelNotFoundException' => [
        'title' => 'Ressource Nicht Gefunden',
        'description' => 'Der gesuchte Eintrag oder die Ressource konnte nicht gefunden werden.',
    ],
    'ViewException' => [
        'title' => 'Fehler beim Anzeigen der Seite',
        'description' => 'Es gab ein Problem bei der Anzeige der Seite. Bitte melden Sie dies dem Support, falls es weiterhin besteht.',
    ],
    'InvalidArgumentException' => [
        'title' => 'Ungültige Eingabe',
        'description' => 'Das System hat einen unerwarteten oder falschen Wert erhalten. Bitte stellen Sie sicher, dass Ihre Eingabe gültig ist.',
    ],

    'fallback' => [
        'title' => 'Ein unerwarteter Fehler ist aufgetreten',
        'description' => 'Es tut uns wirklich leid, aber es ist etwas völlig Unerwartetes passiert. Unser Team wurde benachrichtigt. Bitte versuchen Sie es später noch einmal.',
    ],
];