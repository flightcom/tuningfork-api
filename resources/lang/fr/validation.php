<?php

return [
    'custom' => [
        'message' => 'Une ou plusieurs erreurs empêchent la validation du formulaire',
        'brand' => [
            'required_without' => 'Veuillez sélectionner une marque ou en indiquer une nouvelle'
        ],
        'brand_id' => [
            'required_without' => 'Veuillez sélectionner une marque ou en indiquer une nouvelle'
        ],
        'category' => [
            'required_without' => 'Veuillez sélectionner une catégorie ou en indiquer une nouvelle'
        ],
        'category_id' => [
            'required_without' => 'Veuillez sélectionner une catégorie ou en indiquer une nouvelle'
        ],
        'last_name' => [
            'required' => 'Veuillez indiquer votre prénom',
            'max' => 'Veuillez indiquer un prénom de moins de 255 caractères',
        ],
        'birth_date' => [
            'required' => 'Veuillez indiquer votre date de naissance',
            'date' => 'Veuillez indiquer une date de naissance valide',
        ],
        'email' => [
            'unique' => 'Ce courriel est déjà présent dans notre base de données',
        ],
        'phone' => [
            'unique' => 'Ce numéro de téléphone est déjà présent dans notre base de données',
        ],
    ],
];
