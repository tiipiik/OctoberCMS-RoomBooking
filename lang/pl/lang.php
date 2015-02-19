<?php

return [
    'plugin_name' => 'Rezerwacje',
    'plugin_description' => 'Dodatek: Rezerwacje',
    'booking' => [
        'amount'=>'Wartość',
        'currency'=>'Waluta',
        'validated'=>'Zatwierdzone',
        'registered'=>'Zarejestrowane',
        
        'backend' => [
            'new' => 'Nowa Rezerwacja',
            'room_id_label'=>'Pokój',
            'visitor'=>[
                'tab_title'=>'Gość',
                'full_name'=>'Imię i nazwisko',
                'email'=>'E-mail',
                'phone'=>'Numer telefonu',
                'persons'=>'Ilość osób',
                'rooms'=>'Ilość pokoi',
                'comment'=>'Komentarz',
            ],
            'stay'=>[
                'tab_title'=>'Visitor stay',
                'checkin'=>'Przyjazd',
                'checkout'=>'Wyjazd',
                'nights'=>'Całkowita ilość nocy',
            ],
            'pay_plan'=>[
                'tab_title'=>'Płatność',
                'options_title'=>'Płatność',
            ],
            'columns'=>[
                'id'=>'ID',
                'room_name'=>'Nazwa pokoju lub numer pokoju',
                'customer_name'=>'Imię i nazwisko',
                'customer_email'=>'E-mail',
                'customer_phone'=>'Numer telefonu',
                'persons'=>'Ilość osób',
                'rooms'=>'Ilość pokoi',
                'checkin'=>'Przyjazd',
                'checkout'=>'Wyjazd',
                'total_days'=>'Całkowita ilość dni',
                'total_nights'=>'Całkowita ilość nocy',
                'pay_plan'=>'Płatność',
                'comment'=>'Komentarz',
            ],
            'select_one' => '-- Wybierz --',
        ],
    ],
    'room' => [
        'backend' => [
            'new'=>'Nowy pokój',
            'name'=>'Nazwa pokoju lub numer pokoju',
            'name_placeholder'=>'Nazwa pokoju lub numer pokoju',
            'slug'=>'Skrótowa nazwa "SLUG"',
            'slug_placeholder'=>'nazwa-pokoju-lub-numer-pokoju',
            'available_manual'=>'Dostępny (Akywacja i dezaktywacja ręczna)',
            'description_tab_title'=>'Pełny opis pokoju',
            'manage_tab_title'=>'Administracja pokojem',
            'excerpt'=>'Opis (wewnętrzny)',
            'max_persons'=>'Maksymalna liczba osób w pokoju ',
            'featured_images'=>'Zdjęcia',
            'columns'=> [
                'name'=>'Nazwa lub numer',
                'available'=>'Dostępny',
            ]
        ],
    ],
    'payplans' => [
        'backend' => [
            'new'=>'Nowa forma płatności',
            'name'=>'Nazwa',
            'name_ph'=>'Nadaj nazwę formy płatności',
        ],
    ],
    'components' => [
        'booking_form' => [
            'name' =>'Formularz rezerwacji',
            'description' =>'Wyświetl formularz rezerwacji',
            'params' => [
                'redirect_title' => 'Przekierowanie do',
                'redirect_desc' => 'Nazwa strony do przekierowania po założeniu rezerwacji',
                'room_page_title' => 'Skrótowa nazwa pokoju "SLUG"',
                'room_page_desc' => 'Oczekiwana nazwa używana dla strony pokoju. Powinna być taka sama jak "SLUG" dla strony szczegółowej pokoju.',
            ],
        ],
        'room' => [
            'name' => 'Szczegóły pokoju',
            'description' => 'Wyświetl szczegóły pokoju na stronie',
            'params' => [
                'slug_title' => 'Skrótowa nazwa "SLUG"',
                'slug_desc' => 'Adres URL używany do znalezienia pokoju za pomocą nazwy skrótowej "SLUG".',
            ],
        ],
        'room_list' => [
            'name' => 'Lista pokoi',
            'description' => 'Wyświetl listę pokoi',
            'params' => [
                'rooms_per_page_title' => 'Liczba pokoi na stronie',
                'room_per_page_validation' => 'Nieprawidłowy format liczby pokoi',
                'page_param_title' => 'Nazwa parametru paginacji',
                'page_param_desc' => 'Oczekiwana nazwa parametru używanego dla strony paginacji.',
                'room_page_title' => 'Strona pokoju',
                'room_page_desc' => 'Nazwa pliku strony pokoju dla linku "dowiedz się więcej ". Ta właściwość jest domyślnie używana przez elementy częściowe.',
                'room_slug_title' => 'Skrótowa nazwa pokoju "SLUG"',
                'room_slug_desc' => 'Oczekiwana nazwa parametru podczas tworzenia linków do strony pokoju.',
                'no_room_title' => 'Wiadomość - brak pokoi',
                'no_room_desc' => 'Wiadomość do wyświetlenia na liście pokoi do rezerwacji w przypadku, gdy nie ma dostępnych pokoi. Ta właściwość jest domyślnie używana przez elementy częściowe.',
                'no_room_default' => 'Nie znaleziono pokoi',
            ],
        ],
    ],
    'permissions' => [
        'tab' => 'Rezerwacje',
        'bookings' => 'Zarządzanie rezerwacjami',
        'rooms' => 'Zarządzanie pokojami',
        'payplans' => 'Zarządzanie planem płatności',
    ],
];