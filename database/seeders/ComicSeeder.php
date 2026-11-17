<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Comic;
use App\Models\Editorial;
use App\Models\Superheroe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $marvel = Editorial::create(['nombre' => 'Marvel Comics']);
        $dc = Editorial::create(['nombre' => 'DC Comics']);

        $stanLee = Autor::create(['nombre' => 'Stan Lee']);
        $miller = Autor::create(['nombre' => 'Frank Miller']);
        $moore = Autor::create(['nombre' => 'Alan Moore']);
        $morrison = Autor::create(['nombre' => 'Grant Morrison']);
        $loeb = Autor::create(['nombre' => 'Jeph Loeb']);

        $spiderman = Superheroe::create(['nombre' => 'Spider-Man']);
        $batman = Superheroe::create(['nombre' => 'Batman']);
        $superman = Superheroe::create(['nombre' => 'Superman']);

        $comic = Comic::create([
            'comic' => 'Spider-Man: Blue',
            'portada' => $this->portada('spider-man-blue.jpg'),
            'sinopsis' => 'Una emotiva mirada nostálgica donde Peter Parker recuerda su primer amor, Gwen Stacy, y los eventos formativos de sus primeros años como héroe.',
            'precio' => 32000.00,
            'autor_id' => $loeb->id,
            'editorial_id' => $marvel->id,
        ]);
        $comic->superheroes()->attach($spiderman->id);

        $comic = Comic::create([
            'comic' => 'Batman: Year One',
            'portada' => $this->portada('batman-year-one.jpg'),
            'sinopsis' => 'La génesis definitiva del Caballero Oscuro combatiendo el hampa y la corrupción en Gotham en paralelo a los inicios del teniente Gordon.',
            'precio' => 38000.00,
            'autor_id' => $miller->id,
            'editorial_id' => $dc->id,
        ]);
        $comic->superheroes()->attach($batman->id);

        $comic = Comic::create([
            'comic' => 'The Dark Knight Returns',
            'portada' => $this->portada('the-dark-knight-returns.jpg'),
            'sinopsis' => 'Un veterano Bruce Wayne de 55 años decide volver a ponerse la capa para salvar a una Gotham sumergida en el caos y el crimen mutante.',
            'precio' => 54000.00,
            'autor_id' => $miller->id,
            'editorial_id' => $dc->id,
        ]);
        $comic->superheroes()->attach($batman->id);

        $comic = Comic::create([
            'comic' => 'All-Star Superman',
            'portada' => $this->portada('all-star-superman.jpg'),
            'sinopsis' => 'Tras una sobrecarga solar celular, Superman afronta sus últimos días cumpliendo hazañas memorables en beneficio de la humanidad.',
            'precio' => 62000.00,
            'autor_id' => $morrison->id,
            'editorial_id' => $dc->id,
        ]);
        $comic->superheroes()->attach($superman->id);

        $comic = Comic::create([
            'comic' => 'The Amazing Spider-Man: Orígenes',
            'portada' => $this->portada('the-amazing-spider-man-origenes.jpg'),
            'sinopsis' => 'Las míticas historias fundacionales que presentan la picadura de la araña radiactiva, el tío Ben y la máxima de que un gran poder conlleva una gran responsabilidad.',
            'precio' => 29000.00,
            'autor_id' => $stanLee->id,
            'editorial_id' => $marvel->id,
        ]);
        $comic->superheroes()->attach($spiderman->id);

        $comic = Comic::create([
            'comic' => 'Batman: The Killing Joke',
            'portada' => $this->portada('batman-the-killing-joke.jpg'),
            'sinopsis' => 'El Joker intenta demostrar que un mal día basta para volver loco al hombre más sensato, poniendo a prueba los límites psicológicos de Batman y James Gordon.',
            'precio' => 34000.00,
            'autor_id' => $moore->id,
            'editorial_id' => $dc->id,
        ]);
        $comic->superheroes()->attach($batman->id);

        // crossover: un cómic con dos superhéroes, el ejemplo del muchos a muchos
        $comic = Comic::create([
            'comic' => 'Superman/Batman: Enemigos públicos',
            'portada' => $this->portada('superman-batman-enemigos-publicos.jpg'),
            'sinopsis' => 'Lex Luthor, presidente de Estados Unidos, pone precio a la cabeza de Superman y Batman sale a cubrirle la espalda.',
            'precio' => 36000.00,
            'autor_id' => $loeb->id,
            'editorial_id' => $dc->id,
        ]);
        // attach agrega una fila en comic_superheroe por cada id
        $comic->superheroes()->attach([$superman->id, $batman->id]);
    }

    // copia una imagen de database/seeders/portadas al disco "public" (storage/app/public/portadas)
    // y devuelve el path que se guarda en la columna portada, igual que hace store() en el alta
    private function portada(string $archivo): string
    {
        $path = 'portadas/'.$archivo;
        Storage::disk('public')->put($path, file_get_contents(database_path('seeders/portadas/'.$archivo)));

        return $path;
    }
}
