<?php

return [
    'plugin_name' => 'Réservations',
    'plugin_description' => 'Créez et gérer vos réservations de chambres, pour hôtels, gîtes...',
    'settings_description' => 'Configurer le plugin de réservation de chambre',
    'booking' => [
        'amount'=>'Montant',
        'currency'=>'Devise',
        'validated'=>'Validé',
        'registered'=>'Enregistré le',
        
        'backend' => [
            'new' => 'Nouvelle réservation',
            'room_id_label'=>'Chambre',
            'visitor'=>[
                'tab_title'=>'Invité',
                'full_name'=>'Nom complet',
                'email'=>'E-mail',
                'phone'=>'Téléphone',
                'persons'=>'Personnes',
                'rooms'=>'Chambres',
                'comment'=>'Commentaire',
            ],
            'stay'=>[
                'tab_title'=>'Séjour',
                'checkin'=>'Arrivée',
                'checkout'=>'Départ',
                'nights'=>'Nuitées',
            ],
            'pay_plan'=>[
                'tab_title'=>'Paiement',
                'options_title'=>'Moyen de paiement',
            ],
            'columns'=>[
                'id'=>'ID',
                'room_name'=>'Nom ou numéro de chambre',
                'customer_name'=>'Nom complet',
                'customer_email'=>'E-mail',
                'customer_phone'=>'Téléphone',
                'persons'=>'Personnes',
                'rooms'=>'Chambres',
                'checkin'=>'Arrivée',
                'checkout'=>'Départ',
                'total_days'=>'Jours',
                'total_nights'=>'Nuitées',
                'pay_plan'=>'Paiement',
                'comment'=>'Commentaire',
            ],
            'select_one' => '-- Sélectionner --',
        ],
    ],
    'room' => [
        'backend' => [
            'new'=>'Nouvelle chambre',
            'name'=>'Nom ou numéro de chambre',
            'name_placeholder'=>'Nouveau nom ou numéro de chambre',
            'slug'=>'Url',
            'slug_placeholder'=>'nouveau-nom-ou-numero-de-chambre',
            'available_manual'=>'Disponible (Activer ou désactiver manuellement)',
            'description_tab_title'=>'Description complète',
            'manage_tab_title'=>'Détails',
            'excerpt'=>'Description courte',
            'max_persons'=>'Nombre maximal de personnes',
            'featured_images'=>'Images',
            'columns'=> [
                'name'=>'Nom ou numéro',
                'available'=>'Disponible',
            ]
        ],
    ],
    'payplans' => [
        'backend' => [
            'new'=>'Nouveau moyen de paiement',
            'name'=>'Nom',
            'name_ph'=>'Donnez un nom à ce moyen de paiement',
        ],
    ],
    'components' => [
        'booking_form' => [
            'name' =>'Formulaire de réservation',
            'description' =>'Affiche un formulaire ainsi qu\'un calendrier de dates déjà réservées',
            'params' => [
                'redirect_title' => 'Redirection',
                'redirect_desc' => 'Indiquez la page vers laquelle vous souhaitez rediriger le visiteur après sa réservation',
                'room_page_title' => 'URI de la chambre',
                'room_page_desc' => 'Ce paramètre permet de lier le formulaire à la chambre. Il doit être le même que dans le composant "Détails d\'une chambre".',
            ],
        ],
        'room' => [
            'name' => 'Détails d\'une chambre',
            'description' => 'Affiche les informations de la chambre',
            'params' => [
                'slug_title' => 'URI de la chambre',
                'slug_desc' => 'Ce paramètre permet d\'afficher les détails de la chambre.',
            ],
        ],
        'room_list' => [
            'name' => 'Liste des chambres',
            'description' => 'Affiche la liste des chambres',
            'params' => [
                'rooms_per_page_title' => 'Chambres par page',
                'room_per_page_validation' => 'Le format n\'est pas valide',
                'page_param_title' => 'Pagination',
                'page_param_desc' => 'Le paramètre à utiliser dans l\'URI pour la pagination.',
                'room_page_title' => 'Page de la chambre',
                'room_page_desc' => 'Nom de la page qui va gérer l\'affichage du détail et du formulaire de la chambre',
                'room_slug_title' => 'URI de la chambre',
                'room_slug_desc' => 'Ce paramètre est utilisé pour générer les liens vers les chambres.',
                'no_room_title' => 'Message "Pas de chambre"',
                'no_room_desc' => 'Message affiché s\'il n\'y a aucune chambre enregistrée dans le backoffice',
                'no_room_default' => 'Pas de chambre trouvée',
            ],
        ],
    ],
    'permissions' => [
        'tab' => 'Réservations',
        'bookings' => 'Gérer les réservations',
        'rooms' => 'Gérer les chambres',
        'payplans' => 'Gérer les moyens de paiement',
    ],
];