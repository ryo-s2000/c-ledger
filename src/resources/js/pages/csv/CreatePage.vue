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

                rows.push([
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
            const csvContent = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n");
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
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
