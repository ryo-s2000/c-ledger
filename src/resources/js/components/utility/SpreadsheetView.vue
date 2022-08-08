<template>
  <hot-table v-if='columnsLoaded && rowsLoaded' :settings="hotSettings" :data="[columns].concat(formattedRows)"></hot-table>
</template>

<script>
import { HotTable } from '@handsontable/vue';
import { registerAllModules } from 'handsontable/registry';
registerAllModules();

export default {
    props: {
        columns: {
            type: Array,
            required: true
        },
        rows: {
            type: Array,
            required: true
        }
    },
    components: {
      HotTable
    },
    data: function() {
        return {
            columnsLoaded: false,
            rowsLoaded: false,
            data: [],
            hotSettings: {
                colHeaders: false,
                height: 'auto',
                licenseKey: 'non-commercial-and-evaluation'
            }
        }
    },
    watch: {
        columns() {
            this.columnsLoaded = true
        },
        rows() {
            this.formattedRows = this.rows.map(row => {
                return [
                    row.year,
                    row.number,
                    row.scale,
                    row.progress_value,
                    row.orderer,
                    row.contract_date,
                    row.billing_date,
                    row.payment_date,
                    row.score,
                    row.name,
                    row.place,
                    '',
                    '',
                    '',
                    row.tax,
                    '',
                    '',
                    '',
                    '',
                    '',
                    row.start,
                    row.end,
                    row.period_spare1,
                    row.period_spare2,
                    row.period_spare3,
                    row.period_spare4,
                    row.sales,
                    row.supervisor,
                    row.agent,
                    row.developer,
                    row.total_price,
                    row.remarks,
                    '',
                    '',
                    '',
                ]
            })
            console.log(this.formattedRows)
            this.rowsLoaded = true
        }
    }
  }
</script>

<style src="../../../../node_modules/handsontable/dist/handsontable.full.css"></style>
