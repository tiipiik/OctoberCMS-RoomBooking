<?php

return [
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
];