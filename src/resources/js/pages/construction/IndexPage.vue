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

                <div class="m-2 mt-4 mb-3">
                    <div>
                        <div @click='accordionMenue = !accordionMenue' class="h4 pointer border border-dark p-3">
                            <span v-if='!accordionMenue'>詳細検索を開く</span>
                            <span v-else>詳細検索を閉じる</span>
                        </div>
                        <transition>
                            <div v-show='accordionMenue'>
                                <div class="m-2">
                                    <span>発注者</span>

                                    <input type="text" class="form-control" v-model='filterParams.orderer'>
                                </div>

                                <div class="m-2">
                                    <span>営業担当</span>

                                    <input type="text" class="form-control" v-model='filterParams.sales'>
                                </div>

                                <div class="m-2">
                                    <span>工事担当</span>

                                    <input type="text" class="form-control" v-model='filterParams.supervisor'>
                                </div>

                                <div class="m-2">
                                    <span>現場代理人</span>

                                    <input type="text" class="form-control" v-model='filterParams.agent'>
                                </div>

                                <div class="m-2">
                                    <span>主任技術者</span>

                                    <input type="text" class="form-control" v-model='filterParams.developer'>
                                </div>

                                <div class="m-2">
                                    <span>工事箇所</span>

                                    <input type="text" class="form-control" v-model='filterParams.place'>
                                </div>
                            </div>
                        </transition>
                    </div>
                </div>

                <button type="button" class="btn btn-info m-2" @click='getRows()'>更新</button>
            </div>

            <button type="button" class="btn btn-primary m-2" @click='$router.push({ name: "constructions.create"})'>新規作成</button>
            <button type="button" class="btn btn-success m-2" @click='$router.push({ name: "csv.create"})'>エクセルとして出力</button>
            <button type="button" class="btn btn-warning m-2" @click='$router.push({ name: "summary.index"})'>集計ページ</button>

            <table class="table table-striped table-bordered table-bottom-margin">
                <thead class="thead-dark">
                    <tr>
                        <th v-for="column in columns" :key="column">
                            {{ column }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows" :key="row.id" :class="{ hidden_row: row.hidden_at }" :style="{'background-color': row.row_color }">
                        <td>{{ row.year }}</td>
                        <td>{{ row.number }}</td>
                        <td>{{ row.scale }}</td>
                        <td>{{ row.progress_value }}%</td>
                        <td>{{ row.orderer }}</td>
                        <td>{{ row.contract_date }}</td>
                        <td>{{ row.billing_date }}</td>
                        <td>{{ row.billing_date1 }}</td>
                        <td>{{ row.billing_date2 }}</td>
                        <td>{{ row.billing_date3 }}</td>
                        <td>{{ row.payment_date }}</td>
                        <td>{{ row.payment_date1 }}</td>
                        <td>{{ row.payment_date2 }}</td>
                        <td>{{ row.payment_date3 }}</td>
                        <td>{{ row.score }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.place }}</td>
                        <td><LinkComponent text='書類フォルダURL' :url='googleDrivePath(row.year)'></LinkComponent></td>
                        <td><LinkComponent text='日報URL' :url='dailyreportBasePath + "constructionNumber=" + row.number'></LinkComponent></td>
                        <td class='align-right'><PriceComponent :price='row.price'></PriceComponent></td>
                        <td>{{ row.tax }}%</td>
                        <td class='align-right'><PriceComponent :price='row.price_tax'></PriceComponent></td>
                        <td class='align-right'><PriceComponent :price='row.price_spare1'></PriceComponent></td>
                        <td class='align-right'><PriceComponent :price='row.price_spare2'></PriceComponent></td>
                        <td class='align-right'><PriceComponent :price='row.price_spare3'></PriceComponent></td>
                        <td class='align-right'><PriceComponent :price='row.price_spare4'></PriceComponent></td>
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
                        <td class='align-right'><PriceComponent :price='row.total_price'></PriceComponent></td>
                        <td>{{ row.remarks }}</td>
                        <td><div v-if='!row.hidden_at'><button type="button" class="btn-warning" @click='$router.push({ name: "constructions.copy.create", params: { id: row.id }})'>コピーして作成</button></div></td>
                        <td><div v-if='!row.hidden_at'><button type="button" class="btn-warning" @click='$router.push({ name: "constructions.edit", params: { id: row.id }})'>編集</button></div></td>
                        <td><div v-if='!row.hidden_at'><button type="button" class="btn-danger" @click='deleteConstruction(row.id)'>非表示</button></div></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="construction_category_footer">
            <div class="construction_category_content pointer" v-for='c in categories' :key='c' :value='c' v-bind:class="{ 'construction_category_active': c == filterParams.category }" @click='changeCategory(c)'>
                {{ c }}
            </div>
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
                orderer: '',
                place: '',
                sales: '',
                supervisor: '',
                agent: '',
                developer: '',
                limit: 300
            },
            columns: [],
            rows: [],
            accordionMenue: false,
            dailyreportBasePath: process.env.MIX_APP_DAILYREPORT_BASE_PATH
        }
    },
    methods: {
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
        googleDrivePath(year) {
            const base = 'https://drive.google.com/drive/u/1/folders/';
            let folderId = '0AHC7JJ7vQ1FJUk9PVA';

            switch (year) {
                case 'R4':
                    folderId = '1XIT1mRse-D1sMRLP3pl8-MEARdZ5FUmL'
                    break;
            }

            return base + folderId;
        },
        deleteConstruction(id) {
            const input = window.prompt("非表示にした後は編集が出来なくなります、本当に非表示にする場合は「hidden」と入力してください");
            if(input === 'hidden') {
                axios.delete('/api/constructions/' + id)
                    .then((res) => {
                        this.getRows();
                    });
            }
        },
        changeCategory(category) {
            this.filterParams.category = category;
            this.getRows();
        }
    },
    mounted() {
        this.years = this.getYears();
        this.columns = this.getColumns();
        this.categories = this.getCategories();
        this.getRows();
    }
}
</script>

<style>
    .v-enter {
        opacity: 0;
    }

    .v-enter-to {
        opacity: 1;
    }

    .v-enter-active {
        transition: all 500ms;
    }
</style>
