<script>
    function datatables(headers, elements) {
        return {
            headings: headers, // Cabeceras
            elements: elements, // Elementos

            open: false,
            search: '',
            columns: [],

            sortCol: null,
            sortAsc: false,

            get selectedElements() {
                return this.elements.filter((element) => element.selected);
            },

            init() {
                this.columns = this.headings.map((h) => {
                    return h.key;
                });
            },

            toggleColumn(key) {
                this.columns.includes(key)
                    ? (this.columns = this.columns.filter((i) => i !== key))
                    : this.columns.push(key);
            },

            selectAllCheckbox() {
                let filteredElements = this.filtered(this.elements);
                if (filteredElements.length === this.selectedElements.length) {
                    return filteredElements.map((element) => (element.selected = false));
                }
                filteredElements.map((element) => (element.selected = true));
            },

            removeColID(element) {
                let copy = (JSON.parse(JSON.stringify(element)));
                delete copy.id;
                return copy;
            },

            filteredHeadings() {
                return this.headings.filter((header) => {
                    return header.key !== 'id';
                });
            },

            filtered(...items) {
                // Search filter Function for any Array of Objects !

                // You can pass only the Array of Objects,
                // it will search all props of every Object except "ID"
                // Example : filtered(elements)

                // OR you can pass additional props, it will only search passed props
                // Example : filtered(elements, 'firstName', 'lastName','emailAddress', 'phoneNumber')

                values = items.shift(); // get the list of objects
                props = items.length ? items : null; // get list of props

                return values.filter((i) => {
                    y = Object.assign({}, i);
                    delete y['id']; // Specifie the id prop to remove from object
                    if (props) {
                        okeys = Object.keys(y).filter((b) => !props.includes(b));
                        okeys.map((d) => delete y[d]);
                    }
                    itemToSearch = Object.values(y).join(); // Object to array, then join to String
                    return itemToSearch.toLowerCase().includes(this.search.toLowerCase()); // Return filtred Object
                });
            },

            sort(col) {
                if (this.sortCol === col) this.sortAsc = !this.sortAsc;
                this.sortCol = col;
                this.elements.sort((a, b) => {
                    if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
                    if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
                    return 0;
                });
            }
        };
    }

    /**
     * img:units/amazons_amazon_1.png
     * img:units/amazons_amazon_1.png,w:64
     * img:units/amazons_amazon_1.png,h:64
     * img:units/amazons_amazon_1.png,w:64,h:64
     * img:units/amazons_amazon_1.png,h:64,w:64
     *
     * @param text
     * @returns {string|null}
     */
    function formatContent(text) {
        if (text !== 0 && !text) return null;

        let str = String(text);
        return str
            .replaceAll(/img:(.*),h:(\d*),w:(\d*)/gmi, "<img src='$1' height='$2' width='$3' />")
            .replaceAll(/img:(.*),w:(\d*),h:(\d*)/gmi, "<img src='$1' width='$2'  height='$3' />")
            .replaceAll(/img:(.*),h:(\d*)/gmi,         "<img src='$1' height='$2' />")
            .replaceAll(/img:(.*),w:(\d*)/gmi,         "<img src='$1' width='$2' @click=\"$dispatch('lightbox', { src: '$1' })\" class='cursor-pointer' />")
            .replaceAll(/img:(.*)/gmi,                 "<img src='$1' />")
        ;
    }

    function formatKeywords(text) {
        if (text !== 0 && !text) return null;

        let str = String(text);
        return str
            .replaceAll(/{(.*?)\|(.*?)}/gmi,  "<span class='skill skill-$1'>$2</span>")
            .replaceAll(/\[(.*?)\|(.*?)]/gmi, "<span class='trait trait-$1'>$2</span>")
            .replaceAll(/#atk#/gmi,           "<span class='atk'>&nbsp;&nbsp;</span>")
            .replaceAll(/#def#/gmi,           "<span class='def'>&nbsp;&nbsp;</span>")
            .replaceAll(/#technologic#/gmi,   "<span class='technologic'>&nbsp;&nbsp;</span>")
            .replaceAll(/#biologic#/gmi,      "<span class='biologic'>&nbsp;&nbsp;</span>")
            .replaceAll(/#espectral#/gmi,     "<span class='espectral'>&nbsp;&nbsp;</span>")
            .replaceAll(/#dimensional#/gmi,   "<span class='dimensional'>&nbsp;&nbsp;</span>");
    }

</script>
