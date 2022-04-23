<template>
    <div class="m-5">
        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>年度</span>
            <select class="form-control" v-model='year'>
                <option disabled value="">選択してください</option>
                <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
            </select>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>工事番号</span>
            <input type="text" class="form-control" v-model='number'>
        </div>

        <div class="m-2 mb-5">
            <span>規模</span>
            <input type="text" class="form-control" v-model='scale'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>出来高</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='progress'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>発注者</span>
            <input type="text" class="form-control" v-model='orderer'>
        </div>

        <div class="m-2 mb-5">
            <span>契約日</span>
            <input type="date" class="form-control" v-model='contract_date'>
        </div>

        <div class="m-2 mb-5">
            <span>請求日</span>
            <input type="date" class="form-control" v-model='billing_date'>
        </div>

        <div class="m-2 mb-5">
            <span>支払日</span>
            <input type="date" class="form-control" v-model='payment_date'>
        </div>

        <div class="m-2 mb-5">
            <span>点数</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='score'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">点</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>工事名</span>
            <input type="text" class="form-control" v-model='name'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>金額（税抜）</span>
            <input type="number" class="form-control" v-model='price'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>税率</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='tax'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>増減1（税込)</span>
            <input type="number" class="form-control" v-model='price_spare1'>
        </div>

        <div class="m-2 mb-5">
            <span>増減2（税込)</span>
            <input type="number" class="form-control" v-model='price_spare2'>
        </div>

        <div class="m-2 mb-5">
            <span>増減3（税込)</span>
            <input type="number" class="form-control" v-model='price_spare3'>
        </div>

        <div class="m-2 mb-5">
            <span>増減4（税込)</span>
            <input type="number" class="form-control" v-model='price_spare4'>
        </div>

        <div class="m-2 mb-5">
            <span>工期自</span>
            <input type="date" class="form-control" v-model='start'>
        </div>

        <div class="m-2 mb-5">
            <span>工期至</span>
            <input type="date" class="form-control" v-model='end'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更1</span>
            <input type="date" class="form-control" v-model='period_spare1'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更2</span>
            <input type="date" class="form-control" v-model='period_spare2'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更3</span>
            <input type="date" class="form-control" v-model='period_spare3'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更4</span>
            <input type="date" class="form-control" v-model='period_spare4'>
        </div>

        <div class="m-2 mb-5">
            <span>営業担当</span>
            <input type="text" class="form-control" v-model='sales'>
        </div>

        <div class="m-2 mb-5">
            <span>工事担当</span>
            <input type="text" class="form-control" v-model='supervisor'>
        </div>

        <div class="m-2 mb-5">
            <span>現場代理人</span>
            <input type="text" class="form-control" v-model='agent'>
        </div>

        <div class="m-2 mb-5">
            <span>主任技術者</span>
            <input type="text" class="form-control" v-model='developer'>
        </div>

        <div class="m-2 mb-5">
            <span>備考</span>
            <textarea type="text" class="form-control" v-model='remarks' rows="5"></textarea>
        </div>

        <button type="button" class="btn btn-primary m-2" @click='save()'>保存</button>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            years: [],
            year: '',
            number: '',
            scale: '',
            progress: 0,
            contract_date: '',
            billing_date: '',
            payment_date: '',
            score: '',
            name: '',
            orderer: '',
            price: 0,
            tax: 0,
            price_spare1: '',
            price_spare2: '',
            price_spare3: '',
            price_spare4: '',
            place: '',
            start: '',
            end: '',
            period_spare1: '',
            period_spare2: '',
            period_spare3: '',
            period_spare4: '',
            sales: '',
            supervisor: '',
            agent: '',
            developer: '',
            remarks: ''
        }
    },
    methods: {
        initYears() {
            for ( let i=3; i<=20; ++i ) this.years.push(`R${i}`);
        },
        save() {
            if (this.validation()) {
                const req = this.createReq();
                this.requestToApi(req);
            }
        },
        validation() {
            let errorMessages = [];

            if(!this.years.includes(this.year)) errorMessages.push('年度を選択してください');
            if(!this.number) errorMessages.push('工事番号を入力してください');
            if(!this.name) errorMessages.push('工事名を入力してください');
            if(this.progress !== 0 && !this.progress) errorMessages.push('出来高に数字を入力してください');
            if(this.price !== 0 && !this.price) errorMessages.push('金額に数字を入力してください');
            if(this.tax !== 0 && !this.tax) errorMessages.push('税率に数字を入力してください');

            if(errorMessages.length) {
                window.alert(errorMessages.join('\n'));
                return false;
            } else {
                return true;
            }
        },
        createReq() {
            return {
                year: this.year,
                number: this.number,
                scale: this.scale,
                progress: this.progress,
                contract_date: this.contract_date,
                billing_date: this.billing_date,
                payment_date: this.payment_date,
                score: this.score,
                name: this.name,
                orderer: this.orderer,
                price: this.price,
                tax: this.tax,
                price_spare1: this.price_spare1,
                price_spare2: this.price_spare2,
                price_spare3: this.price_spare3,
                price_spare4: this.price_spare4,
                place: this.place,
                start: this.start,
                end: this.end,
                period_spare1: this.period_spare1,
                period_spare2: this.period_spare2,
                period_spare3: this.period_spare3,
                period_spare4: this.period_spare4,
                sales: this.sales,
                supervisor: this.supervisor,
                agent: this.agent,
                developer: this.developer,
                remarks: this.remarks
            };
        },
        requestToApi(req) {
            axios.post('/api/constructions', req)
                .then((res) => {
                    window.alert('保存成功');
                    this.$router.push({ name: "constructions.index"});
                })
                .catch(error => {
                    window.alert('↓コピーして管理者に送ってください↓\n\n' + error.response.data.message);
                });
        }
    },
    mounted() {
        this.initYears();
    }
}
</script>
