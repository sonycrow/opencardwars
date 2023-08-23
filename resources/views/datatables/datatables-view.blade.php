<div>
    <div x-data="{ imgModal: false, imgSrc: '' }">
        <template @lightbox.window="imgModal = true; imgSrc = $event.detail.src;" x-if="imgModal">
            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90"
                 @click="imgModal = false"
                 class="p-2 fixed w-full h-100 inset-0 z-50 overflow-hidden flex justify-center items-center bg-black bg-opacity-75">
                <div @click.away="imgModal = true" class="flex flex-col max-w-3xl max-h-full overflow-auto">
                    <div class="z-50">
                        <button @click="imgModal = false" class="float-right pt-2 pr-2 outline-none focus:outline-none">
                            <svg class="fill-current text-white " xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-2">
                        <img :alt="imgSrc" class="object-contain h-1/2-screen" :src="imgSrc"/>
                        {{--<p x-text="imgDesc" class="text-center text-white"></p>--}}
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div x-data="datatables({{ Illuminate\Support\Js::from($headers) }}, {{ Illuminate\Support\Js::from($elements) }})" x-cloak>

        @if ($props['allowSelection'])
            <div x-show="selectedElements.length" class="bg-gray-200 fixed top-4 right-4 z-40 w-1/4 shadow">
                <div class="container mx-auto px-4 py-4">
                    <div class="flex md:items-center">
                        <div class="mr-4 flex-shrink-0">
                            <svg class="h-8 w-8 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div x-html="selectedElements.length + ' rows are selected'" class="text-gray-800 text-lg"></div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1 pr-4">
                <div class="relative md:w-1/3">
                    <input type="search" x-model="search"
                           class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                           placeholder="Search...">
                    <div class="absolute top-0 left-0 inline-flex items-center p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                             stroke-linejoin="round">
                            <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                            <circle cx="10" cy="10" r="7"/>
                            <line x1="21" y1="21" x2="15" y2="15"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative mr-2">
                <select class="shadow rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4"
                        x-data
                        @change="window.location.href = '/lang/' + $event.target.value">
                    <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>ES</option>
                    <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>EN</option>
                </select>
            </div>

            <div>
                <div class="shadow rounded-lg flex">
                    <div class="relative">
                        <button @click.prevent="open = !open" class="rounded-lg inline-flex items-center bg-white hover:text-blue-500 focus:outline-none focus:shadow-outline text-gray-500 font-semibold py-2 px-2 md:px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <path d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5"/>
                            </svg>
                            <span class="hidden md:block">Display</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="z-40 absolute top-0 right-0 w-40 bg-white rounded-lg shadow-lg mt-12 -mr-1 block py-1 overflow-hidden">
                            <template x-for="heading in filteredHeadings(headings)">
                                <label class="flex justify-start items-center text-truncate hover:bg-gray-100 px-4 py-2">
                                    <div class="text-blue-600 mr-3">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" checked @click="toggleColumn(heading.key)">
                                    </div>
                                    <div class="select-none text-gray-700" x-text="heading.value"></div>
                                </label>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="border-collapse w-full table-auto whitespace-no-wrap bg-white table-striped relative">
                <thead>
                <tr class="text-left">
                    @if ($props['allowSelection'])
                        <th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-200">
                            <label class="text-gray-500 inline-flex justify-between items-center hover:bg-gray-300 px-2 py-2 rounded-lg cursor-pointer">
                                <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline" @click="selectAllCheckbox($event);"/>
                            </label>
                        </th>
                    @endif
                    <template x-for="heading in filteredHeadings(headings)">
                        <th class="sticky top-0 border-b bg-gray-200 px-6 py-2 text-gray-700 font-bold tracking-wider uppercase text-xs"
                            x-text="heading.value" x-show="columns.includes(heading.key)" @click="sort(heading.key)"></th>
                    </template>
                </tr>
                </thead>
                <tbody>
                <template x-if="!elements">
                    <tr><td colspan="9999"><i>Loading...</i></td></tr>
                </template>
                <template x-for="element in filtered(elements)" :key="element.id">
                    <tr>
                        @if ($props['allowSelection'])
                            <td class="border-dashed border-t border-gray-300 px-3 align-middle">
                                <label class="text-blue-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                    <input type="checkbox" x-model="element.selected" class="form-checkbox rowCheckbox focus:outline-none focus:shadow-outline" :name="element.id"/>
                                </label>
                            </td>
                        @endif

                        <template x-for="(col, index) in removeColID(element)">
                            <td class="border-dashed border-t border-gray-300 text-gray-700 px-6 py-2 align-middle"
                                x-show="columns.includes(index)"
                                x-html="formatContent(col, $dispatch)"></td>
                        </template>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>

    @include('datatables.datatables-scripts')
</div>
