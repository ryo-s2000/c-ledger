require('./bootstrap');

import VueRouter from 'vue-router';
import ConstructionIndexPage from "@/pages/construction/IndexPage";
import ConstructionCreateAndEditPage from "@/pages/construction/CreateAndEditPage";
import CsvCreatePage from "@/pages/csv/CreatePage";
import SummaryIndexPage from "@/pages/summary/IndexPage";
import SummaryOrderPage from "@/pages/summary/OrderPage";
import SummaryProfitPage from "@/pages/summary/ProfitPage";
import NotFoundPage from "@/pages/utility/NotFoundPage";

window.Vue = require('vue').default;
Vue.use(VueRouter);

const router = new VueRouter({
     mode: 'history',
     routes: [
        {
            path: '/',
            name: 'top',
            component: ConstructionIndexPage
        },
        {
            path: '/constructions',
            name: 'constructions.index',
            component: ConstructionIndexPage
        },
        {
            path: '/constructions/create',
            name: 'constructions.create',
            component: ConstructionCreateAndEditPage
        },
        {
            path: '/constructions/:id/copy/create',
            name: 'constructions.copy.create',
            component: ConstructionCreateAndEditPage
        },
        {
            path: '/constructions/:id/edit',
            name: 'constructions.edit',
            component: ConstructionCreateAndEditPage
        },
        {
            path: '/csv/create',
            name: 'csv.create',
            component: CsvCreatePage
        },
        {
            path: '/summary',
            name: 'summary.index',
            component: SummaryIndexPage
        },
        {
            path: '/summary/order',
            name: 'summary.order',
            component: SummaryOrderPage
        },
        {
            path: '/summary/profit',
            name: 'summary.profit',
            component: SummaryProfitPage
        },
        {
            path: '*',
            name: '404',
            component: NotFoundPage
        },
     ]
});

const yearStart = 3;
const yearEnd = 20;
const baseYears = [...Array(yearEnd-yearStart+1).keys()].map(i => i+=yearStart);
Vue.mixin({
    methods: {
        getYears() {
            return baseYears.flatMap(y => [`R${y}`]);
        },
        getYearsWithForward() {
            return baseYears.flatMap(y => [`R${y}`, `R${y}-R${y+1}`, `R${y}-R${y+1}-R${y+2}`]);
        },
        getColumns(csv=false) {
            let columns = [
                '年度',
                '工事番号',
                '規模',
                '出来高',
                '発注者',
                '契約日',
            ];

            if (!csv) {
                columns = columns.concat([
                    '請求日1',
                    '請求日2',
                    '請求日3',
                    '請求日4',
                    '入金日1',
                    '入金日2',
                    '入金日3',
                    '入金日4',
                ]);
            } else {
                columns = columns.concat([
                    '請求日',
                    '入金日',
                ]);
            }

            columns = columns.concat([
                '点数',
                '工事名',
                '工事箇所',
            ]);

            if (!csv) {
                columns = columns.concat([
                    '書類フォルダURL',
                    '日報',
                ]);
            }

            columns = columns.concat([
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
            ]);

            if (!csv) {
                columns = columns.concat([
                    'コピー',
                    '編集',
                    '削除',
                ]);
            }

            return columns;
        },
        getCategories() {
            return [
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
        }
    }
})

const app = new Vue({
    el: '#app',
    router
});
