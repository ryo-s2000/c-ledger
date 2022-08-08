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
            <button type="button" class="btn btn-success m-2" @click='$router.push({ name: "csv.create"})'>エクセル作成</button>

            <spreadsheet-view :rows='rows' :columns='columns'></spreadsheet-view>
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
import SpreadsheetView from "@/components/utility/SpreadsheetView";

export default {
    components: {
        LinkComponent,
        PriceComponent,
        SpreadsheetView
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
            columnKeys: [],
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
        this.columnKeys = this.getColumnKeys();
        this.categories = this.getCategories();
        this.getRows();
    }
}
</script>

<style>
    .table-bottom-margin {
        margin-bottom: 100px;
    }

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
