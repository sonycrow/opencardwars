<div>
    <div x-data class="border border-gray-300 p-4 mb-5 rounded-lg flex">
        <div class="mr-4">
            <label>
                <select
                    wire:model="faction"
                    x-on:change.debounce="generateImages"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-1"
                >
                    <option>·· Wizard Kings ··</option>
                    <option value="amazons">Amazons</option>
                    <option value="barbarians">Barbarians</option>
                    <option value="dwarves">Dwarves</option>
                    <option value="elves">Elves</option>
                    <option value="feudals">Feudals</option>
                    <option value="orcs">Orcs</option>
                    <option value="undead">Undead</option>
                    <option value="werebeast">Werebeast</option>
                    <option value="chaos">Chaos</option>
                    <option value="artifacts">Artifacts</option>
                    <option value="treasures">Treasures</option>
                    <option>·· Warhammer 40k ··</option>
                    <option value="spacemarines">Space Marines</option>
                </select>
            </label>
        </div>

        <div class="mr-4"><label><input wire:model="tts" type="checkbox" class="mr-1" /><span>Formato TTS</span></label></div>
        <div class="mr-4"><label><input wire:model="images" type="checkbox" class="mr-1" /><span>Generar imágenes</span></label></div>
        <div class="mr-4"><label><input wire:model="download" type="checkbox" class="mr-1" /><span>Descargar imágenes</span></label></div>

        <button x-on:click="generateImages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 p-1">Generar imágenes</button>
    </div>

    <div class="grid grid-cols-4" style="width: {{ ($tts ? 288*4 : 256*4) }}px;">
        {{-- Livewire --}}
        @foreach (\App\Providers\CodexServiceProvider::getUnits($faction) as $unit)
             @livewire('unit', [ 'id' => $unit['id'], 'tts' => $tts, 'images' => $images, 'download' => $download ], key($unit['id']))
        @endforeach
    </div>

    <script>
        function generateImages(e) {
            // Recorremos las cartas y generamos las imágenes
            let nodes = document.getElementsByClassName('block');

            Array.from(nodes).forEach((node) => {
                // Configuración
                let unitid   = node.getAttribute("data-unitid");
                let nameid   = node.getAttribute("data-nameid");
                let toImage  = node.getAttribute("data-toimage");
                let download = node.getAttribute("data-download");

                // Si hay que generar las imagenes
                if (toImage == 1) {
                    htmltoimage.toPng(node)
                        .then(function (dataUrl) {
                            let img = new Image();
                            img.src = dataUrl;

                            // Descarga de imagenes
                            if (download == 1) {
                                img.onclick = function() {
                                    let link = document.createElement('a');
                                    link.download = nameid + '.png';
                                    link.href = dataUrl;
                                    link.click();
                                };
                            }

                            document.getElementById("unit-" + unitid).appendChild(img);
                            node.remove();
                        })
                        .catch(function (error) {
                            console.error('oops, something went wrong!', error);
                        });
                }
            });
        }
    </script>
</div>


