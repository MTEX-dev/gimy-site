<?php

return [
    '401' => [
        'title' => 'Accès Non Autorisé',
        'description' => 'Vous avez besoin d\'authentification pour accéder à cette page. Veuillez vous connecter ou vérifier votre identité.',
    ],
    '403' => [
        'title' => 'Accès Interdit',
        'description' => 'Vous n\'avez pas les permissions nécessaires pour voir ce contenu. Si vous pensez qu\'il s\'agit d\'une erreur, veuillez contacter le support.',
    ],
    '404' => [
        'title' => 'Page Non Trouvée',
        'description' => 'Nous n\'avons pas pu trouver la page que vous recherchiez. Elle a peut-être été déplacée, supprimée, ou vous avez mal tapé l\'adresse.',
    ],
    '419' => [
        'title' => 'Page Expirée',
        'description' => 'Votre session a expiré en raison d\'une inactivité. Veuillez rafraîchir la page et réessayer votre action.',
    ],
    '429' => [
        'title' => 'Trop de Requêtes',
        'description' => 'Vous avez envoyé trop de requêtes en peu de temps. Veuillez patienter un instant avant de réessayer.',
    ],
    '500' => [
        'title' => 'Erreur Interne du Serveur',
        'description' => 'Oups ! Quelque chose s\'est mal passé de notre côté. Nous travaillons à résoudre le problème. Veuillez réessayer sous peu.',
    ],
    '503' => [
        'title' => 'Service Indisponible',
        'description' => 'Nous sommes en maintenance ou subissons une surcharge temporaire. Nous serons de nouveau en ligne très bientôt !',
    ],

    'ModelNotFoundException' => [
        'title' => 'Ressource Introuvable',
        'description' => 'L\'élément ou l\'enregistrement spécifique que vous recherchiez n\'existe pas.',
    ],
    'ViewException' => [
        'title' => 'Erreur de Rendu de Vue',
        'description' => 'Il y a eu un problème lors de l\'affichage de la page. Veuillez le signaler au support si cela persiste.',
    ],
    'InvalidArgumentException' => [
        'title' => 'Argument Invalide',
        'description' => 'Le système a reçu une valeur inattendue ou incorrecte. Veuillez vous assurer que votre entrée est valide.',
    ],

    'fallback' => [
        'title' => 'Une erreur inattendue est survenue',
        'description' => 'Nous sommes vraiment désolés, mais quelque chose de totalement imprévu est arrivé. Notre équipe a été informée. Veuillez réessayer plus tard.',
    ],
];