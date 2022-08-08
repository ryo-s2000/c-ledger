<template>
    <div>
        <vue-table
            v-model="formattedRows"
            :headers="formattedheaders"
            :disable-sort-thead="headerKeys"

            :loading="false"
            :disable-cells="[]"
            :submenu-tbody="[]"
            :submenu-thead="[]"

            :custom-options="customOptions"
            :style-wrap-vue-table="styleWrapVueTable"

            :parent-scroll-element="{}"
            :select-position="{}"
        >
        </vue-table>
  </div>
</template>

<script>
import VueTable from 'vuejs-spreadsheet';

export default {
    props: {
        rows: {
            type: Array,
            required: true
        },
        headers: {
            type: Array,
            required: true
        },
        headerKeys: {
            type: Array,
            required: true
        },
    },
    components: {
        VueTable,
    },
    data: function () {
        return {
            formattedRows: [],
            formattedheaders: [],
            customOptions: {
                tbodyIndex: true,
                sortHeader: true,
                trad: {
                lang: 'fr',
                en: {
                    select: {
                    placeholder: 'Search by typing',
                    },
                },
                fr: {
                    select: {
                    placeholder: 'Taper pour chercher',
                    },
                },
                },
                newData: {
                type: 'input',
                value: '',
                active: false,
                style: {
                    color: '#000',
                },
                },
                fuseOptions: {
                shouldSort: true,
                threshold: 0.2,
                location: 0,
                distance: 30,
                maxPatternLength: 64,
                minMatchCharLength: 1,
                findAllMatches: false,
                tokenize: false,
                keys: [
                    'value',
                ],
                },
            },
            styleWrapVueTable: {
                fontSize: '12px',
                comment: {
                    borderColor: '#696969',
                    borderSize: '8px',
                    widthBox: '120px',
                    heightBox: '80px',
                },
            },
        };
    },
    watch: {
        headers() {
            for(let i=0; i<=this.headers.length; i++) {
                this.formattedheaders.push(
                    {
                        headerName: this.headers[i],
                        headerKey: this.headerKeys[i],
                        style: {
                            width: '200px',
                            minWidth: '200px',
                            color: '#000',
                        }
                    }
                )
            }
        },
        rows() {
            this.formattedRows = this.rows.map(object => {
                let formattedObject = {}

                for (const key in object) {
                    formattedObject[key] = {
                        value: object[key],
                        type: 'input',
                        active: false,
                        style: {
                            color: '#000',
                        }
                    }
                }

                return formattedObject
            });
        }
    }
};
</script>
