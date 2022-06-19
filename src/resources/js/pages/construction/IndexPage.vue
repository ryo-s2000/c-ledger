<template>
    <div>
        <div class="table-responsive">
            <div class="m-4">
                <p class="h5">フィルター</p>

                <div class="m-2">
                    <span>年度</span>

                    <select class="form-select" v-model='filterParams.year'>
                        <option value="">未選択</option>
                        <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
                    </select>
                </div>

                <div class="m-2">
                    <span>種別</span>

                    <select class="form-select" v-model='filterParams.category'>
                        <option value="">未選択</option>
                        <option v-for='c in categories' :key='c' :value='c'>{{ c }}</option>
                    </select>
                </div>

                <div class="m-2">
                    <span>最大表示件数</span>

                    <input type="text" class="form-control" v-model='filterParams.limit'>
                </div>

                <button type="button" class="btn btn-info m-2" @click='getRows()'>更新</button>
            </div>

            <button type="button" class="btn btn-primary m-2" @click='$router.push({ name: "constructions.create"})'>新規作成</button>

            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th v-for="column in columns" :key="column">
                            {{ column }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows" :key="row.id">
                        <td>{{ row.year }}</td>
                        <td>{{ row.number }}</td>
                        <td>{{ row.scale }}</td>
                        <td>{{ row.progress_value }}%</td>
                        <td>{{ row.orderer }}</td>
                        <td>{{ row.contract_date }}</td>
                        <td>{{ row.billing_date }}</td>
                        <td>{{ row.payment_date }}</td>
                        <td>{{ row.score }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.place }}</td>
                        <td><LinkComponent text='書類フォルダURL' :url='googleDrivePath'></LinkComponent></td>
                        <td><LinkComponent text='日報URL' :url='dailyreportBasePath + "constructionNumber=" + row.number'></LinkComponent></td>
                        <td><PriceComponent :price='row.price'></PriceComponent></td>
                        <td>{{ row.tax }}%</td>
                        <td><PriceComponent :price='row.price_tax'></PriceComponent></td>
                        <td><PriceComponent :price='row.price_spare1'></PriceComponent></td>
                        <td><PriceComponent :price='row.price_spare2'></PriceComponent></td>
                        <td><PriceComponent :price='row.price_spare3'></PriceComponent></td>
                        <td><PriceComponent :price='row.price_spare4'></PriceComponent></td>
                        <td>{{ row.start }}</td>
                        <td>{{ row.end }}</td>
                        <td>{{ row.period_spare1 }}</td>
                        <td>{{ row.period_spare2 }}</td>
                        <td>{{ row.period_spare3 }}</td>
                        <td>{{ row.period_spare4 }}</td>
                        <td>{{ row.sales }}</td>
                        <td>{{ row.supervisor }}</td>
                        <td>{{ row.agent }}</td>
                        <td>{{ row.developer }}</td>
                        <td><PriceComponent :price='row.total_price'></PriceComponent></td>
                        <td>{{ row.remarks }}</td>
                        <td><button type="button" class="btn btn-warning" @click='$router.push({ name: "constructions.edit", params: { id: row.id }})'>編集</button></td>
                        <td><button type="button" class="btn btn-danger" @click='deleteConstruction(row.id)'>削除</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import LinkComponent from "@/components/utility/LinkComponent";
import PriceComponent from "@/components/utility/PriceComponent";

export default {
    components: {
        LinkComponent,
        PriceComponent
    },
    data: function () {
        return {
            years: [],
            categories: [],
            filterParams: {
                year: '',
                category: '',
                limit: 300
            },
            columns: [],
            rows: [],
            googleDrivePath: process.env.MIX_APP_GOOGLE_DRIVE_PATH, // HACK fix to dynamic
            dailyreportBasePath: process.env.MIX_APP_DAILYREPORT_BASE_PATH
        }
    },
    methods: {
        initYears() {
            for ( let i=3; i<=20; ++i ) this.years.push(`R${i}`);
        },
        initColumns() {
            this.columns = [
                '年度',
                '工事番号',
                '規模',
                '出来高',
                '発注者',
                '契約日',
                '請求日',
                '支払日',
                '点数',
                '工事名',
                '工事箇所',
                '書類フォルダURL',
                '日報',
                '金額（税抜）',
                '税率',
                '消費税',
                '増減1（税込)',
                '増減2（税込)',
                '増減3（税込)',
                '増減4（税込)',
                '工期自',
                '工期至',
                '工期変更1',
                '工期変更2',
                '工期変更3',
                '工期変更4',
                '営業担当',
                '工事担当',
                '現場代理人',
                '主任技術者',
                '最終請負金額(税込)',
                '備考',
                '編集',
                '削除',
            ];
        },
        initCategories() {
            this.categories = [
                'KA',
                'KA雑',
                'KB',
                'KB雑',
                'KC',
                'KC雑',
                'KD',
                'MA',
                'MA雑',
                'MB',
                'MC',
                'MC雑',
                'MT',
                'MT雑',
                'MI',
                'MI雑',
                'ZA',
                'XA',
                'TO',
            ];
        },
        getRows() {
            let fulter_params = '';

            for (const [key, value] of Object.entries(this.filterParams)) {
                fulter_params += `${key}=${value}&`
            }

            axios.get('/api/constructions?' + fulter_params)
                .then((res) => {
                    this.rows = res.data;
                });
        },
        deleteConstruction(id) {
            const input = window.prompt("本当に削除する場合は「delete」と入力してください");
            if(input === 'delete') {
                axios.delete('/api/constructions/' + id)
                    .then((res) => {
                        this.getRows();
                    });
            }
        }
    },
    mounted() {
        this.initYears();
        this.initColumns();
        this.initCategories();
        this.getRows();
    }
}
</script>
