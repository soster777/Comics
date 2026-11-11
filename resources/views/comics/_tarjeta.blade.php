<div class="tarjeta">

    <a href="{{ route('comics.show', $comic->id) }}" class="portada portada-{{ $comic->editorial_id }}">
        {{-- si tiene portada muestro la imagen; si no, queda el cuadro de color con el título --}}
        @if($comic->portada_url)
            <img src="{{ $comic->portada_url }}" alt="Portada de {{ $comic->comic }}">
        @else
            <span>{{ $comic->comic }}</span>
        @endif
    </a>

    <div class="tarjeta-cuerpo">
        <h3 class="tarjeta-titulo">{{ $comic->comic }}</h3>
        <p class="tarjeta-datos">{{ $comic->autor->nombre }} &middot; {{ $comic->editorial->nombre }}</p>
        <p class="precio">$ {{ number_format($comic->precio, 2, ',', '.') }}</p>

        <a href="{{ route('comics.show', $comic->id) }}" class="btn btn-primary btn-sm w-100 mt-auto">Ver detalle</a>

        {{-- editar y eliminar solo los ve el admin; las rutas igual están protegidas con el middleware --}}
        @admin
            <div class="d-flex gap-2 mt-2">
                <a href="{{ route('comics.edit', $comic->id) }}" class="btn btn-outline-secondary btn-sm flex-fill">Editar</a>

                <form action="{{ route('comics.destroy', $comic->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('¿Seguro que querés eliminar este cómic?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">Eliminar</button>
                </form>
            </div>
        @endadmin
    </div>

</div>
