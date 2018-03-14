<?php

return [
    'custom' => [
        'message' => 'Une ou plusieurs erreurs empêchent la validation du formulaire',
        'last_name' => [
            'required' => 'Veuillez indiquer votre prénom',
            'max' => 'Veuillez indiquer un prénom de moins de 255 caractères',
        ],
        'birth_date' => [
            'required' => 'Veuillez indiquer votre date de naissance',
            'date' => 'Veuillez indiquer une date de naissance valide',
        ],
        'phone' => [
            'unique' => 'Le numéro de téléphone est déjà présent dans notre base de données',
        ],
    ],
];
