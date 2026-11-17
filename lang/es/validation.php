<?php

// mensajes de validación en castellano para las reglas que usa el proyecto.
// Laravel los toma porque en el .env está APP_LOCALE=es.
// si una regla no está acá, usa el mensaje en inglés que trae el framework
return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute tiene que ser texto.',
    'email' => 'El campo :attribute tiene que ser un email válido.',
    'numeric' => 'El campo :attribute tiene que ser un número.',
    'integer' => 'El campo :attribute tiene que ser un número entero.',
    'boolean' => 'El campo :attribute tiene que ser verdadero o falso.',
    'array' => 'El campo :attribute tiene que ser una lista.',
    'exists' => 'La opción elegida en :attribute no es válida.',
    'unique' => 'Ese :attribute ya está registrado.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'image' => 'El archivo :attribute tiene que ser una imagen.',
    'mimes' => 'El archivo :attribute tiene que ser de tipo: :values.',
    'max' => [
        'numeric' => 'El campo :attribute no puede ser mayor que :max.',
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
        'file' => 'El archivo :attribute no puede pesar más de :max KB.',
        'array' => 'El campo :attribute no puede tener más de :max elementos.',
    ],
    'min' => [
        'numeric' => 'El campo :attribute tiene que ser como mínimo :min.',
        'string' => 'El campo :attribute tiene que tener al menos :min caracteres.',
        'file' => 'El archivo :attribute tiene que pesar al menos :min KB.',
        'array' => 'El campo :attribute tiene que tener al menos :min elementos.',
    ],

    // mensajes propios para un campo y una regla puntual
    'custom' => [
        'autor_nuevo' => ['required_if' => 'Escribí el nombre del autor nuevo.'],
        'superheroes' => ['required_without' => 'Tildá al menos un superhéroe o escribí uno nuevo.'],
    ],

    // nombres lindos para los campos, así el mensaje dice "título" y no "comic"
    'attributes' => [
        'comic' => 'título',
        'precio' => 'precio',
        'autor_id' => 'autor',
        'autor_nuevo' => 'autor nuevo',
        'superheroes' => 'superhéroes',
        'superheroe_nuevo' => 'superhéroe nuevo',
        'mensaje' => 'mensaje',
        'editorial_id' => 'editorial',
        'sinopsis' => 'sinopsis',
        'portada' => 'portada',
        'nombre' => 'nombre',
        'name' => 'nombre',
        'email' => 'email',
        'password' => 'contraseña',
    ],
];
