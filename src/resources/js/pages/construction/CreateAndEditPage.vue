<template>
    <div class="m-5">
        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>年度</span>
            <select class="form-control" v-model='construction.year'>
                <option disabled value="">選択してください</option>
                <option v-for='y in years' :key='y' :value='y'>{{ y }}</option>
            </select>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>工事番号</span>
            <input type="text" class="form-control" v-model='construction.number'>

            <div v-if='numberDuplicate' class="p-3 mb-2 bg-danger text-white">
                工事番号が重複しています。
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>規模</span>
            <input type="text" class="form-control" v-model='construction.scale'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>出来高</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='construction.progress_value'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>発注者</span>
            <input type="text" class="form-control" v-model='construction.orderer'>
        </div>

        <div class="m-2 mb-5">
            <span>契約日</span>
            <input type="date" class="form-control" v-model='construction.contract_date'>
        </div>

        <div class="flex">
            <div class="m-2 mb-5">
                <span>請求日1</span>
                <input type="date" class="form-control" v-model='construction.billing_date'>
            </div>

            <div class="m-2 mb-5">
                <span>請求金額1</span>
                <input type="number" class="form-control" v-model='construction.billing_amount'>
                <PriceComponent :price='parseInt(construction.billing_amount)'></PriceComponent>
            </div>

            <div class="m-2 mb-5">
                <span>入金日1</span>
                <input type="date" class="form-control" v-model='construction.payment_date'>
            </div>
        </div>

        <div class="flex">
            <div class="m-2 mb-5">
                <span>請求日2</span>
                <input type="date" class="form-control" v-model='construction.billing_date1'>
            </div>

            <div class="m-2 mb-5">
                <span>請求金額2</span>
                <input type="number" class="form-control" v-model='construction.billing_amount1'>
                <PriceComponent :price='parseInt(construction.billing_amount1)'></PriceComponent>
            </div>

            <div class="m-2 mb-5">
                <span>入金日2</span>
                <input type="date" class="form-control" v-model='construction.payment_date1'>
            </div>
        </div>

        <div class="flex">
            <div class="m-2 mb-5">
                <span>請求日3</span>
                <input type="date" class="form-control" v-model='construction.billing_date2'>
            </div>

            <div class="m-2 mb-5">
                <span>請求金額3</span>
                <input type="number" class="form-control" v-model='construction.billing_amount2'>
                <PriceComponent :price='parseInt(construction.billing_amount2)'></PriceComponent>
            </div>

            <div class="m-2 mb-5">
                <span>入金日3</span>
                <input type="date" class="form-control" v-model='construction.payment_date2'>
            </div>
        </div>

        <div class="flex">
            <div class="m-2 mb-5">
                <span>請求日4</span>
                <input type="date" class="form-control" v-model='construction.billing_date3'>
            </div>

            <div class="m-2 mb-5">
                <span>請求金額4</span>
                <input type="number" class="form-control" v-model='construction.billing_amount3'>
                <PriceComponent :price='parseInt(construction.billing_amount3)'></PriceComponent>
            </div>

            <div class="m-2 mb-5">
                <span>入金日4</span>
                <input type="date" class="form-control" v-model='construction.payment_date3'>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>点数</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='construction.score'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">点</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>工事名</span>
            <input type="text" class="form-control" v-model='construction.name'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>工事箇所</span>
            <input type="text" class="form-control" v-model='construction.place'>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>金額（税抜）</span>
            <input type="number" class="form-control" v-model='construction.price'>
            <PriceComponent :price='parseInt(construction.price)'></PriceComponent>
        </div>

        <div class="m-2 mb-5">
            <span class="text-danger">[必須]</span><span>税率</span>
            <div class="input-group">
                <input type="number" class="form-control" v-model='construction.tax'>
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">%</span>
                </div>
            </div>
        </div>

        <div class="m-2 mb-5">
            <span>増減1（税込)</span>
            <input type="number" class="form-control" v-model='construction.price_spare1'>
            <PriceComponent :price='parseInt(construction.price_spare1)'></PriceComponent>
        </div>

        <div class="m-2 mb-5">
            <span>増減2（税込)</span>
            <input type="number" class="form-control" v-model='construction.price_spare2'>
            <PriceComponent :price='parseInt(construction.price_spare2)'></PriceComponent>
        </div>

        <div class="m-2 mb-5">
            <span>増減3（税込)</span>
            <input type="number" class="form-control" v-model='construction.price_spare3'>
            <PriceComponent :price='parseInt(construction.price_spare3)'></PriceComponent>
        </div>

        <div class="m-2 mb-5">
            <span>増減4（税込)</span>
            <input type="number" class="form-control" v-model='construction.price_spare4'>
            <PriceComponent :price='parseInt(construction.price_spare4)'></PriceComponent>
        </div>

        <div class="m-2 mb-5">
            <span>工期自</span>
            <input type="date" class="form-control" v-model='construction.start'>
        </div>

        <div class="m-2 mb-5">
            <span>工期至</span>
            <input type="date" class="form-control" v-model='construction.end'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更1</span>
            <input type="date" class="form-control" v-model='construction.period_spare1'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更2</span>
            <input type="date" class="form-control" v-model='construction.period_spare2'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更3</span>
            <input type="date" class="form-control" v-model='construction.period_spare3'>
        </div>

        <div class="m-2 mb-5">
            <span>工期変更4</span>
            <input type="date" class="form-control" v-model='construction.period_spare4'>
        </div>

        <div class="m-2 mb-5">
            <span>営業担当</span>
            <input type="text" class="form-control" v-model='construction.sales'>
        </div>

        <div class="m-2 mb-5">
            <span>工事担当</span>
            <input type="text" class="form-control" v-model='construction.supervisor'>
        </div>

        <div class="m-2 mb-5">
            <span>現場代理人</span>
            <input type="text" class="form-control" v-model='construction.agent'>
        </div>

        <div class="m-2 mb-5">
            <span>主任技術者</span>
            <input type="text" class="form-control" v-model='construction.developer'>
        </div>

        <div class="m-2 mb-5">
            <span>備考</span>
            <textarea type="text" class="form-control" v-model='construction.remarks' rows="5"></textarea>
        </div>

        <div class="m-2 mb-5">
            <span>色</span>
            <select class="form-control" v-model='construction.row_color'>
                <option disabled value="">未設定</option>
                <option v-for='c in row_colors' :key='c.value' :value='c.value' :style="{'background-color': c.value }">{{ c.key }}</option>
            </select>
        </div>

        <button type="button" class="btn btn-primary m-2" @click='save()'>保存</button>
    </div>
</template>

<script>
import PriceComponent from "@/components/utility/PriceComponent";

export default {
    components: {
        PriceComponent
    },
    data: function () {
        return {
            years: [],
            row_colors: [],
            isCopy: (new URL(window.location.href)).href.match(/copy/),
            numberDuplicate: false,
            construction: {
                id: this.$route.params.id,
                year: '',
                number: '',
                scale: '',
                progress_value: 0,
                contract_date: '',
                billing_date: '',
                billing_date1: '',
                billing_date2: '',
                billing_date3: '',
                billing_amount: '',
                billing_amount1: '',
                billing_amount2: '',
                billing_amount3: '',
                payment_date: '',
                payment_date1: '',
                payment_date2: '',
                payment_date3: '',
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
                remarks: '',
                row_color: ''
            }
        }
    },
    methods: {
        getRowColors() {
            return [
                { key: 'オレンジ', value: '#FFB266' },
                { key: '黄色', value: '#FFFF66' },
                { key: '明るい緑', value: '#CCFFCC' },
            ]
        },
        initConstruction() {
            if(!this.construction.id) return;

            axios.get('/api/constructions/' + this.construction.id)
                .then((res) => {
                    this.construction = res.data;
                });
        },
        save() {
            if (this.validation()) {
                const req = this.createReq();
                this.requestToApi(req);
            }
        },
        validation() {
            let errorMessages = [];

            if(!this.years.includes(this.construction.year)) errorMessages.push('年度を選択してください');
            if(!this.construction.number) errorMessages.push('工事番号を入力してください');
            if(!this.construction.name) errorMessages.push('工事名を入力してください');
            if(this.construction.progress_value !== 0 && !this.construction.progress_value) errorMessages.push('出来高に数字を入力してください');
            if(this.construction.price !== 0 && !this.construction.price) errorMessages.push('金額に数字を入力してください');
            if(this.construction.tax !== 0 && !this.construction.tax) errorMessages.push('税率に数字を入力してください');

            if(errorMessages.length) {
                window.alert(errorMessages.join('\n'));
                return false;
            } else {
                return true;
            }
        },
        createReq() {
            return {
                year: this.construction.year,
                number: this.construction.number,
                scale: this.construction.scale,
                progress_value: this.construction.progress_value,
                contract_date: this.construction.contract_date,
                billing_date: this.construction.billing_date,
                billing_date1: this.construction.billing_date1,
                billing_date2: this.construction.billing_date2,
                billing_date3: this.construction.billing_date3,
                billing_amount: this.construction.billing_amount,
                billing_amount1: this.construction.billing_amount1,
                billing_amount2: this.construction.billing_amount2,
                billing_amount3: this.construction.billing_amount3,
                payment_date: this.construction.payment_date,
                payment_date1: this.construction.payment_date1,
                payment_date2: this.construction.payment_date2,
                payment_date3: this.construction.payment_date3,
                score: this.construction.score,
                name: this.construction.name,
                orderer: this.construction.orderer,
                price: this.construction.price,
                tax: this.construction.tax,
                price_spare1: this.construction.price_spare1,
                price_spare2: this.construction.price_spare2,
                price_spare3: this.construction.price_spare3,
                price_spare4: this.construction.price_spare4,
                place: this.construction.place,
                start: this.construction.start,
                end: this.construction.end,
                period_spare1: this.construction.period_spare1,
                period_spare2: this.construction.period_spare2,
                period_spare3: this.construction.period_spare3,
                period_spare4: this.construction.period_spare4,
                sales: this.deleteAllWiteSpace(this.construction.sales),
                supervisor: this.deleteAllWiteSpace(this.construction.supervisor),
                agent: this.deleteAllWiteSpace(this.construction.agent),
                developer: this.deleteAllWiteSpace(this.construction.developer),
                remarks: this.construction.remarks,
                row_color: this.construction.row_color,
            };
        },
        async requestToApi(req) {
            if(this.construction.id && !this.isCopy) {
                const res = await axios.put('/api/constructions/' + this.construction.id, req);
                if(res) this.successRequest();
            } else {
                const res = await axios.post('/api/constructions', req);
                if(res) this.successRequest();
            }
        },
        successRequest() {
            window.alert('保存成功');
            this.$router.push({ name: "constructions.index"});
        },
        deleteAllWiteSpace(text) {
            if (!text) return;
            return text.replaceAll(/\s/g,'');
        },
        constructionsNumberValidate() {
            if(!this.construction.id || this.isCopy) {
                if(this.construction.year && this.construction.number) {
                    axios.get(`/api/constructions/number/validate/${this.construction.year}/${this.construction.number}`).then(res => {
                        this.numberDuplicate = Boolean(res.data)
                    });
                }
            }
        }
    },
    watch: {
        'construction.year'() {
            this.constructionsNumberValidate();
        },
        'construction.number'() {
            this.constructionsNumberValidate();
        }
    },
    mounted() {
        this.years = this.getYearsWithForward();
        this.row_colors = this.getRowColors();
        this.initConstruction();
    }
}
</script>
