<template>
    <div>
        <div class="table-responsive">
            <div class="m-4">
                <p class="h5">受注・施工・粗利高・総合集計</p>

                <div class="m-2">
                    <span>年度</span>

                    <select class="form-select" v-model='filterParams.year'>
                        <option value="">未選択</option>
                        <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
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
                TODO 合計処理書いて
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
            filterParams: {
                year: '',
            },
            rows: [],
            total: {},
        }
    },
    methods: {
        getRows() {
            if (!this.validation()) { return };

            let fulter_params = '';
            for (const [key, value] of Object.entries(this.filterParams)) {
                fulter_params += `${key}=${value}&`
            }

            axios.get('/api/summary/comprehensive?' + fulter_params)
                .then((res) => {
                    console.log(res);
                    this.rows = res.data;
                });
        },
        validation() {
            let errorMessages = [];

            if(!this.filterParams.year) errorMessages.push('年度を選択してください');

            if(errorMessages.length) {
                window.alert(errorMessages.join('\n'));
                return false;
            } else {
                return true;
            }
        },
    },
    mounted() {
        this.years = this.getYears();
    }
}
</script>
