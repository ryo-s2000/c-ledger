<template>
    <div>
        <div class="table-responsive">
            <div class="m-4">
                <p class="h5">受注高集計</p>

                <div class="m-2">
                    <span>年度</span>

                    <select class="form-select" v-model='filterParams.year'>
                        <option value="">未選択</option>
                        <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
                    </select>
                </div>

                <div class="m-2">
                    <span>名前</span>

                    <select class="form-select" v-model='filterParams.sales'>
                        <option value="">未選択</option>
                        <option v-for='s in saleses' :key='s' :value='s'>{{ s }}</option>
                    </select>
                </div>

                <button type="button" class="btn btn-info m-2" @click='getRows()'>更新</button>
                <DownloadHtml :fileName='`${filterParams.year}_${filterParams.sales}`'></DownloadHtml>
            </div>
        </div>

        <div class="m-4">
            <div v-if="rows.length == 0">
                表示できるデータが存在しません
            </div>
            <div class="flex" v-else>
                <div class="m-2">
                    <table>
                        <thead>
                            <tr>
                                <td>工事番号</td>
                                <td>工事名</td>
                                <td>契約日時</td>
                                <td>金額(税抜)</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="row in rows" :key="row.id">
                                <td>{{ row.number }}</td>
                                <td>{{ row.name }}</td>
                                <td><span v-if='row.contract_date'>{{ row.contract_date }}</span><span v-else>未入力</span></td>
                                <td class="align-right"><PriceComponent :price='row.price'></PriceComponent></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="m-2">
                    <table>
                        <thead>
                            <tr>
                                <td></td>
                                <td>MC</td>
                                <td>MT</td>
                                <td>MI</td>
                                <td>KC</td>
                                <td>その他</td>
                                <td>合計</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="month in [4,5,6,7,8,9,10,11,12,1,2,3]" :key="month">
                                <td>{{ month }}月</td>
                                <td class="align-right"><PriceComponent :price='total[month]["MC"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='total[month]["MT"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='total[month]["MI"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='total[month]["KC"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='total[month]["other"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='total[month]["all"]'></PriceComponent></td>
                            </tr>

                            <tr>
                                <td>合計</td>
                                <td class="align-right"><PriceComponent :price='totalSum["MC"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='totalSum["MT"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='totalSum["MI"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='totalSum["KC"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='totalSum["other"]'></PriceComponent></td>
                                <td class="align-right"><PriceComponent :price='totalSum["all"]'></PriceComponent></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import PriceComponent from "@/components/utility/PriceComponent";
import DownloadHtml from "@/components/utility/DownloadHtml";

export default {
    components: {
        PriceComponent,
        DownloadHtml
    },
    data:() => {
        return {
            years: [],
            saleses: [],
            filterParams: {
                year: '',
                sales: '',
            },
            rows: [],
            total: {},
            totalSum: {
                'MC': 0,
                'MT': 0,
                'MI': 0,
                'KC': 0,
                'other': 0,
                'all': 0,
            }
        }
    },
    methods: {
        getRows() {
            if (!this.validation()) { return };

            let fulter_params = '';
            for (const [key, value] of Object.entries(this.filterParams)) {
                fulter_params += `${key}=${value}&`
            }

            axios.get('/api/summary/order?' + fulter_params)
                .then((res) => {
                    this.rows = res.data;

                    this.calTotal();
                });
        },
        validation() {
            let errorMessages = [];

            if(!this.filterParams.year) errorMessages.push('年度を選択してください');
            if(!this.filterParams.sales) errorMessages.push('名前を選択してください');

            if(errorMessages.length) {
                window.alert(errorMessages.join('\n'));
                return false;
            } else {
                return true;
            }
        },
        calTotal() {
            this.totalSum.MC = 0;
            this.totalSum.MT = 0;
            this.totalSum.MI = 0;
            this.totalSum.KC = 0;
            this.totalSum.other = 0;
            this.totalSum.all = 0;

            for (let i=1; i<=12; ++i) {
                const thisMonthRows = this.rows.filter(row => row.contract_date && row.contract_date.split('-')[1] == ('0'+i).slice(-2));

                let MCSum = 0;
                let MTSum = 0;
                let MISum = 0;
                let KCSum = 0;
                let OtherSum = 0;
                let AllSum = 0;
                for (let j=0; j<thisMonthRows.length; ++j) {
                    const category = thisMonthRows[j].number.slice(0,2);
                    const thisMonthPrice = thisMonthRows[j].price;

                    switch (category) {
                        case 'MC':
                            MCSum += thisMonthPrice;
                            break;
                        case 'MT':
                            MTSum += thisMonthPrice;
                            break;
                        case 'MI':
                            MISum += thisMonthPrice;
                            break;
                        case 'KC':
                            KCSum += thisMonthPrice;
                            break;
                        default:
                            OtherSum += thisMonthPrice;
                    }
                    AllSum += thisMonthPrice;
                }

                // 合計の行(一番下の行)
                this.total[i] = {
                    'MC': MCSum,
                    'MT': MTSum,
                    'MI': MISum,
                    'KC': KCSum,
                    'other': OtherSum,
                    'all': AllSum
                }

                // 合計の列(一番右の列)
                this.totalSum.MC += MCSum
                this.totalSum.MT += MTSum
                this.totalSum.MI += MISum
                this.totalSum.KC += KCSum
                this.totalSum.other += OtherSum
                this.totalSum.all += AllSum
            }
        }
    },
    mounted() {
        this.years = this.getYears();
        axios.get('/api/util/unique_people_names/sales')
            .then((res) => {
                this.saleses = res.data;
            });
    }
}
</script>
