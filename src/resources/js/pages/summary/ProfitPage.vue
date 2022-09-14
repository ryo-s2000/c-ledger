<template>
    <div>
        <div class="table-responsive">
            <div class="m-4">
                <p class="h5">施工・粗利高・集計</p>

                <div class="m-2">
                    <span>年度</span>

                    <select class="form-select" v-model='filterParams.year'>
                        <option value="">未選択</option>
                        <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
                    </select>
                </div>

                <div class="m-2">
                    <span>名前</span>

                    <select class="form-select" v-model='filterParams.supervisor'>
                        <option value="">未選択</option>
                        <option v-for='s in supervisors' :key='s' :value='s'>{{ s }}</option>
                    </select>
                </div>

                <button type="button" class="btn btn-info m-2" @click='getRows()'>更新</button>
                <DownloadHtml :fileName='`${filterParams.year}_${filterParams.supervisor}`'></DownloadHtml>
            </div>
        </div>

        <div class="m-4">
            <div v-if="rows.length == 0">
                データを更新してください
            </div>
            <table v-else>
                <thead>
                    <tr>
                        <td rowspan="4">工事番号</td>
                        <td rowspan="4">工事名</td>

                        <td>請負金額1</td>
                        <td>請負金額2</td>
                        <td>請負金額3</td>
                        <td>請負金額4</td>
                        <td>請負金額5</td>

                        <!-- 月別 -->
                        <td rowspan="4">項目</td>
                        <td rowspan="4">合計</td>
                        <td rowspan="4">4月</td>
                        <td rowspan="4">5月</td>
                        <td rowspan="4">6月</td>
                        <td rowspan="4">7月</td>
                        <td rowspan="4">8月</td>
                        <td rowspan="4">9月</td>
                        <td rowspan="4">10月</td>
                        <td rowspan="4">11月</td>
                        <td rowspan="4">12月</td>
                        <td rowspan="4">1月</td>
                        <td rowspan="4">2月</td>
                        <td rowspan="4">3月</td>
                    </tr>
                    <tr>
                        <td>実効予算1</td>
                        <td>実効予算2</td>
                        <td>実効予算3</td>
                        <td>実効予算4</td>
                        <td>実効予算5</td>
                    </tr>
                    <tr>
                        <td>粗利高1</td>
                        <td>粗利高2</td>
                        <td>粗利高3</td>
                        <td>粗利高4</td>
                        <td>粗利高5</td>
                    </tr>
                    <tr>
                        <td>変更月1</td>
                        <td>変更月2</td>
                        <td>変更月3</td>
                        <td>変更月4</td>
                        <td>変更月5</td>
                    </tr>
                </thead>

                <tbody v-for="row in rows" :key="row.id">
                    <tr>
                        <td rowspan="4">{{ row.number }}</td>
                        <td rowspan="4">{{ row.name }}</td>

                        <!-- 請負金額 -->
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["1"].amount'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["2"].amount'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["3"].amount'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["4"].amount'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["5"].amount'></PriceComponent></td>

                        <!-- 項目 -->
                        <td rowspan="2">出来高%</td>

                        <!-- 月別出来高 -->
                        <td class="align-right" rowspan="2">{{ row.summarise.total.progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["4"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["5"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["6"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["7"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["8"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["9"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["10"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["11"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["12"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["1"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["2"].progres }}</td>
                        <td class="align-right" rowspan="2">{{ row.summarise["3"].progres }}</td>
                    </tr>
                    <tr>
                        <!-- 実効予算 -->
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["1"].budget'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["2"].budget'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["3"].budget'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["4"].budget'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["5"].budget'></PriceComponent></td>
                    </tr>
                    <tr>
                        <!-- 粗利高 -->
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["1"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["2"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["3"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["4"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.formattedAmountsAndBudgets["5"].profit'></PriceComponent></td>

                        <!-- 項目 -->
                        <td>施工高</td>

                        <!-- 月別施工高 -->
                        <td class="align-right"><PriceComponent :price='row.summarise.total.grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["4"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["5"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["6"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["7"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["8"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["9"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["10"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["11"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["12"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["1"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["2"].grossSales'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["3"].grossSales'></PriceComponent></td>
                    </tr>
                    <tr>
                        <!-- 変更月 -->
                        <td class="align-right">{{ row.formattedAmountsAndBudgets["1"].month }}月</td>
                        <td class="align-right">{{ row.formattedAmountsAndBudgets["2"].month }}月</td>
                        <td class="align-right">{{ row.formattedAmountsAndBudgets["3"].month }}月</td>
                        <td class="align-right">{{ row.formattedAmountsAndBudgets["4"].month }}月</td>
                        <td class="align-right">{{ row.formattedAmountsAndBudgets["5"].month }}月</td>

                        <!-- 項目 -->
                        <td>粗利高</td>

                        <!-- 月別粗利高 -->
                        <td class="align-right"><PriceComponent :price='row.summarise.total.profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["4"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["5"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["6"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["7"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["8"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["9"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["10"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["11"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["12"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["1"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["2"].profit'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='row.summarise["3"].profit'></PriceComponent></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td rowspan="2">合計</td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td rowspan="2"></td>
                        <td>施工高</td>
                        <td class="align-right"><PriceComponent :price='total.grossSales.all'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["4"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["5"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["6"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["7"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["8"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["9"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["10"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["11"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["12"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["1"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["2"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.grossSales["3"]'></PriceComponent></td>
                    </tr>
                    <tr>
                        <td>粗利高</td>
                        <td class="align-right"><PriceComponent :price='total.profit.all'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["4"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["5"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["6"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["7"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["8"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["9"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["10"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["11"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["12"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["1"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["2"]'></PriceComponent></td>
                        <td class="align-right"><PriceComponent :price='total.profit["3"]'></PriceComponent></td>
                    </tr>
                </tbody>
            </table>
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
            supervisors: [],
            filterParams: {
                year: '',
                supervisor: '',
            },
            rows: [],
            total: {
                grossSales: {
                    all: 0,
                    '4': 0,
                    '5': 0,
                    '6': 0,
                    '7': 0,
                    '8': 0,
                    '9': 0,
                    '10': 0,
                    '11': 0,
                    '12': 0,
                    '1': 0,
                    '2': 0,
                    '3': 0,
                },
                profit: {
                    all: 0,
                    '4': 0,
                    '5': 0,
                    '6': 0,
                    '7': 0,
                    '8': 0,
                    '9': 0,
                    '10': 0,
                    '11': 0,
                    '12': 0,
                    '1': 0,
                    '2': 0,
                    '3': 0,
                },
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

            axios.get('/api/summary/profit?' + fulter_params)
                .then((res) => {
                    this.rows = res.data;

                    this.calTotal();
                });
        },
        validation() {
            let errorMessages = [];

            if(!this.filterParams.year) errorMessages.push('年度を選択してください');
            if(!this.filterParams.supervisor) errorMessages.push('名前を選択してください');

            if(errorMessages.length) {
                window.alert(errorMessages.join('\n'));
                return false;
            } else {
                return true;
            }
        },
        calTotal() {
            this.total.grossSales.all = 0;
            this.total.profit.all = 0;
            for (let i=1; i<=12; i++) {
                this.total.grossSales[`${i}`] = 0;
                this.total.profit[`${i}`] = 0;
            }

            for (let i=0; i<this.rows.length; i++) {
                let row = this.rows[i];

                this.total.grossSales.all += row.summarise.total.grossSales;
                this.total.grossSales["4"] += row.summarise["4"].grossSales;
                this.total.grossSales["5"] += row.summarise["5"].grossSales;
                this.total.grossSales["6"] += row.summarise["6"].grossSales;
                this.total.grossSales["7"] += row.summarise["7"].grossSales;
                this.total.grossSales["8"] += row.summarise["8"].grossSales;
                this.total.grossSales["9"] += row.summarise["9"].grossSales;
                this.total.grossSales["10"] += row.summarise["10"].grossSales;
                this.total.grossSales["11"] += row.summarise["11"].grossSales;
                this.total.grossSales["12"] += row.summarise["12"].grossSales;
                this.total.grossSales["1"] += row.summarise["1"].grossSales;
                this.total.grossSales["2"] += row.summarise["2"].grossSales;
                this.total.grossSales["3"] += row.summarise["3"].grossSales;

                this.total.profit.all += row.summarise.total.profit;
                this.total.profit["4"] += row.summarise["4"].profit;
                this.total.profit["5"] += row.summarise["5"].profit;
                this.total.profit["6"] += row.summarise["6"].profit;
                this.total.profit["7"] += row.summarise["7"].profit;
                this.total.profit["8"] += row.summarise["8"].profit;
                this.total.profit["9"] += row.summarise["9"].profit;
                this.total.profit["10"] += row.summarise["10"].profit;
                this.total.profit["11"] += row.summarise["11"].profit;
                this.total.profit["12"] += row.summarise["12"].profit;
                this.total.profit["1"] += row.summarise["1"].profit;
                this.total.profit["2"] += row.summarise["2"].profit;
                this.total.profit["3"] += row.summarise["3"].profit;
            }
        }
    },
    mounted() {
        this.years = this.getYears();
        axios.get('/api/util/unique_people_names/supervisor')
            .then((res) => {
                this.supervisors = res.data;
            });
    }
}
</script>
