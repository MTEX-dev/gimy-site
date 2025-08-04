<?php

return [
    'hero' => [
        'title' => 'Le bac à sable du développeur pour la création Web',
        'subtitle' => 'Gimy.site est une plateforme de déploiement rapide de mtex.dev. Écrivez du HTML, du CSS et du JS pour plusieurs pages et publiez vos sites statiques instantanément.',
        'cta_btn' => 'Commencez à construire gratuitement',
    ],

    'stats' => [
        'section_title' => 'Statistiques',
        'title' => 'Quelques statistiques',
        'developers' => 'Développeurs rejoints',
        'sites' => 'Sites créés',
        'files' => 'Fichiers stockés',
    ],

    'faq' => [
        'title' => 'Questions fréquemment posées',
        'questions' => [
            [
                'q' => 'Puis-je utiliser mon propre domaine personnalisé?',
                'a' => 'La prise en charge de domaines personnalisés est une fonctionnalité prévue pour nos prochains plans Premium et Pro. Pour l\'instant, tous les sites sont hébergés sur un sous-domaine `gimy.site`.',
            ],
            [
                'q' => 'Quel type de support offrez-vous?',
                'a' => 'En tant que plate-forme axée sur les développeurs, nous offrons principalement un support communautaire. Nous travaillons activement à la création d\'un forum communautaire et d\'un serveur Discord.',
            ],
            [
                'q' => 'Y a-t-il une limite de taille de fichier pour les pages?',
                'a' => 'Oui, pour garantir les performances de la plate-forme, il existe des limites raisonnables sur la quantité de code par page. Ces limites sont généreuses et ne devraient pas affecter la grande majorité des projets de sites statiques.',
            ],
        ],
    ],

    'comparison' => [
        'section_title' => 'Comparaison',
        'title' => 'Comment nous nous comparons',
        'subtitle' => 'Gimy.site est conçu pour la vitesse et la simplicité. Voici comment il se compare à d\'autres solutions populaires pour l\'hébergement de sites statiques.',
        'feature' => 'Fonctionnalité',
        'gimy' => 'Gimy.site',
        'github_pages' => 'GitHub Pages',
        'netlify' => 'Netlify',
        'features' => [
            ['name' => 'Éditeur de fichiers basé sur le Web', 'gimy' => 'true', 'github' => 'false', 'netlify' => 'false'],
            ['name' => 'Déploiement instantané', 'gimy' => 'true', 'github' => 'Git Push', 'netlify' => 'Git Push'],
            ['name' => 'Domaines personnalisés', 'gimy' => 'Bientôt disponible', 'github' => 'true', 'netlify' => 'true'],
            ['name' => 'Niveau gratuit', 'gimy' => 'true', 'github' => 'true', 'netlify' => 'true'],
            ['name' => 'Processus de construction', 'gimy' => 'Aucun', 'github' => 'Jekyll (optionnel)', 'netlify' => 'Personnalisable'],
        ],
    ],

    'showcase' => [
        'section_title' => 'Vitrine de la communauté',
        'title' => 'Construit avec Gimy.site',
        'subtitle' => 'Découvrez quelques-uns des projets incroyables que les membres de notre communauté ont créés.',
        'view_project_btn' => 'Voir le projet',
        'projects' => [
            ['title' => 'Site de portfolio', 'description' => 'Un portfolio propre et moderne présentant le travail d\'un designer indépendant.'],
            ['title' => 'Page de destination de l\'événement', 'description' => 'Un site d\'une seule page pour une prochaine conférence technique, avec un calendrier et des biographies des conférenciers.'],
            ['title' => 'Jeu JS', 'description' => 'Un jeu d\'arcade de style rétro amusant entièrement construit avec HTML, CSS et JavaScript.'],
        ],
    ],

    'feedback' => [
        'title' => 'Avez-vous des commentaires?',
        'subtitle' => 'Nous aimerions avoir de vos nouvelles! Partagez vos réflexions, suggestions ou signalez un bogue.',
        'email_label' => 'Adresse e-mail',
        'type_label' => 'Type de message',
        'type_feedback' => 'Commentaires',
        'type_suggestion' => 'Suggestion',
        'type_bug' => 'Rapport de bogue',
        'message_label' => 'Message',
        'submit_btn' => 'Envoyer des commentaires',
        'success_message' => 'Merci pour vos commentaires!',
    ],

    'newsletter' => [
        'title' => 'Restez à jour',
        'subtitle' => 'Abonnez-vous à notre newsletter pour recevoir les dernières nouvelles, mises à jour et annonces de fonctionnalités.',
        'email_label' => 'Adresse e-mail',
        'email_placeholder' => 'Entrez votre e-mail',
        'submit_btn' => 'S\'abonner',
        'success_message' => 'Merci de vous être abonné!',
    ],
];