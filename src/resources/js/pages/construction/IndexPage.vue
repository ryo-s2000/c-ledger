<template>
<div>

<div class="table-responsive">
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
        <td>{{ row.progress }}</td>
        <td>{{ row.orderer }}</td>
        <td>{{ row.contract_date }}</td>
        <td>{{ row.score }}</td>
        <td>{{ row.name }}</td>
        <td>{{ row.place }}</td>

        <!-- TODO path -->
        <td><LinkComponent text='注文書URL' :url='testOrderPath'></LinkComponent></td>
        <td><LinkComponent text='請求書URL' :url='testInvoicePath'></LinkComponent></td>
        <td><LinkComponent text='支払依頼書URL' :url='testTotalInvoicePath'></LinkComponent></td>
        <td><LinkComponent text='提出書類URL' :url='testSubmitDocPath'></LinkComponent></td>
        <td><LinkComponent text='日報URL' :url='testDailyreportPath'></LinkComponent></td>

        <td>{{ row.price }}</td>
        <td>TODO calc</td>
        <td>{{ row.price_spare1 }}</td>
        <td>{{ row.price_spare2 }}</td>
        <td>{{ row.price_spare3 }}</td>
        <td>{{ row.price_spare4 }}</td>
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
        <td>TODO calc</td>
        <td>{{ row.remarks }}</td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</template>

<script>
import LinkComponent from "../../components/utility/LinkComponent";

export default {
    components: {
        LinkComponent
    },
    data: function () {
        return {
            columns: [],
            rows: [],
            testOrderPath: process.env.MIX_APP_TEST_OP,
            testInvoicePath: process.env.MIX_APP_TEST_IP,
            testTotalInvoicePath: process.env.MIX_APP_TEST_TIP,
            testSubmitDocPath: process.env.MIX_APP_TEST_SDP,
            testDailyreportPath: process.env.MIX_APP_TEST_DP
        }
    },
    methods: {
        initColumns() {
            this.columns = [
                '年度',
                '工事番号',
                '規模',
                '出来高',
                '発注者',
                '契約日',
                '点数',
                '工事名',
                '工事箇所',
                '注文書',
                '請求書',
                '支払依頼書',
                '提出書類',
                '日報',
                '金額（税抜）',
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
            ];
        },
        getRows() {
            axios.get('/api/constructions')
                .then((res) => {
                    this.rows = res.data;
                });
        },
    },
    mounted() {
        this.initColumns();
        this.getRows();
    }
}
</script>
