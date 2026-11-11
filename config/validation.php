<?php

return [

    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'exists' => 'El :attribute seleccionado no es válido.',

    'min' => [
        'numeric' => 'El campo :attribute debe ser como mínimo :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],

    'max' => [
        'numeric' => 'El campo :attribute no puede ser mayor a :max.',
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],


    'attributes' => [
        'comic' => 'título',
        'precio' => 'precio',
        'sinopsis' => 'sinopsis',
        'autor_id' => 'autor',
        'superheroe_id' => 'superhéroe',
        'editorial_id' => 'editorial',
    ],

];