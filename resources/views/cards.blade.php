<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <title>Laravel 9 TALL</title>

        {{-- Vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Normalización de CSS --}}
        @include('subviews.normalizecss')

        {{-- Estilos Livewire --}}
        @livewireStyles
    </head>

    <body>
        {{-- Layout --}}
        @include('subviews.navbar')
        <main x-data class="p-4">

            <button x-on:click="generateImages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 p-1">Generar imágenes</button>

            {{-- Livewire --}}
            @foreach (\App\Providers\CodexServiceProvider::getCards() as $card)
                @if(!$cardnumber || ($card['number'] == $cardnumber))
                    @livewire('card', [ 'id' => $card['id'] ], key($card['id']))
                @endif
            @endforeach

            <div id="cards"></div>

            <script>
                function generateImages(e) {
                    // Recorremos las cartas y generamos las imágenes
                    let nodes = document.getElementsByClassName('card');
                    Array.from(nodes).forEach((node) => {
                        // Configuración
                        let cardid   = node.getAttribute("data-cardid");
                        let toImage = 1;

                        // Si hay que generar las imagenes
                        if (toImage === 1) {
                            htmltoimage.toJpeg(node, {quality: 1})
                                .then(function (dataUrl) {
                                    let img = new Image();
                                    img.src = dataUrl;

                                    // Descarga de imagenes
                                    img.onclick = function() {
                                        let link = document.createElement('a');
                                        link.download = cardid + '.jpg';
                                        link.href = dataUrl;
                                        link.click();
                                    };

                                    document.getElementById("cards").appendChild(img);
                                    node.remove();
                                })
                                .catch(function (error) {
                                    console.error('oops, something went wrong!', error);
                                });
                        }
                    });
                }
            </script>

        </main>

        {{-- Scripts de livewire --}}
        @livewireScripts
    </body>

</html>

