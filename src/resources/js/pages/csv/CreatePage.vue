<template>
    <div>
        <div class="table-responsive">
            <div class="m-4">
                <p class="h5">エクセル作成</p>

                <div class="m-2">
                    <span>年度</span>

                    <select class="form-select" v-model='year'>
                        <option value="">未選択</option>
                        <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
                    </select>
                </div>

                <button type="button" class="btn btn-info m-2" @click='createCsv()'>作成</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            years: [],
            columns: [],
            year: ''
        }
    },
    methods: {
        async createCsv() {
            const rows = await this.createCsvRows();
            rows.unshift(this.columns);
            this.downloadCsv(rows);
        },
        async createCsvRows() {
            await this.getRows();

            let rows = [];
            for (let i=0; i < this.rows.length; i++) {
                const row = this.rows[i];

                let orderer = '';
                if (row.orderer) {
                    orderer = row.orderer.replace(/\r?\n/g, '');
                }

                let name = '';
                if (row.name) {
                    name = row.name.replace(/\r?\n/g, '');
                }

                let place = '';
                if (row.place) {
                    place = row.place.replace(/\r?\n/g, '');
                }

                let billing_date = '';
                if (row.billing_date)  { billing_date += `${row.billing_date} / ` }
                if (row.billing_date1) { billing_date += `${row.billing_date1} / ` }
                if (row.billing_date2) { billing_date += `${row.billing_date2} / ` }
                if (row.billing_date3) { billing_date += `${row.billing_date3} / ` }
                billing_date = billing_date.slice(0, -3);

                let payment_date = '';
                if (row.payment_date)  { payment_date += `${row.payment_date} / ` }
                if (row.payment_date1) { payment_date += `${row.payment_date1} / ` }
                if (row.payment_date2) { payment_date += `${row.payment_date2} / ` }
                if (row.payment_date3) { payment_date += `${row.payment_date3} / ` }
                payment_date = payment_date.slice(0, -3);

                rows.push([
                    row.year,
                    row.number,
                    row.scale,
                    row.progress_value,
                    orderer,
                    row.contract_date,
                    billing_date,
                    payment_date,
                    row.score,
                    name,
                    place,
                    row.price,
                    row.tax,
                    row.price_tax,
                    row.price_spare1,
                    row.price_spare2,
                    row.price_spare3,
                    row.price_spare4,
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
                ])
            }

            return rows;
        },
        async getRows() {
            await axios.get('/api/constructions?' + 'year=' + this.year)
                .then((res) => {
                    this.rows = res.data;
                });
        },
        downloadCsv(rows) {
            const link = document.createElement("a");

            const bom = new Uint8Array([0xEF, 0xBB, 0xBF]);
            const blob = new Blob([bom, rows.map(e => e.join(",")).join("\n")], {type: 'text/csv'});
            link.setAttribute('href', window.URL.createObjectURL(blob));
            link.setAttribute("download", this.csvFileName());

            document.body.appendChild(link);
            link.click();
        },
        csvFileName() {
            return this.year + '工事番号台帳';
        }
    },
    mounted() {
        this.years = this.getYears();
        this.columns = this.getColumns(true);
    }
}
</script>
