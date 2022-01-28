<template>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
        <div class="px-6 py-2 border-t border-gray-200" @click="editCustomer(customer.id)" v-for="customer in customers" :key="customer.id">
            <div class="grid grid-cols-7 gap-1">
                <div class="col-span-4">
                    <div>{{ customer.name}}</div>
                    <div class="text-xs">{{ moment(customer.created_at).format("ddd MMM DD, YYYY")}}</div>
                </div>
                <div class="col-span-2">
                    <jet-label value="Amount" />
                    <div class="font-semibold" 
                        :class="customer.amount > 0 ? 'text-blue-500': ''">
                        {{ money(customer.amount) }}
                    </div>
                </div>
                <div class="col-span-1">
                    <jet-label value="Balance" />
                    <div class="font-semibold" 
                        :class="customer.balance <= 0 ? 'text-blue-500': 'text-red-400'">
                        {{ money(customer.balance) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetLabel from '@/Jetstream/Label.vue'

    export default defineComponent({
        name: 'customer_lists',
        components: {
            JetApplicationLogo,
            JetButton,
            JetLabel
        },
        data() {
            return {
            }
        },
        computed: {
            customers() {
                let lists = []
                for (const c_key in this.$page.props.customers) {
                    let list = this.assign(this.$page.props.customers[c_key])
                    list['amount'] = 0
                    list['balance'] = 0
                    for (const t_key in list.transactions) {
                        let amount = parseFloat(list.transactions[t_key].data.money_in.amount)
                        list['amount'] += amount

                        let balance = amount - parseFloat(list.transactions[t_key].data.money_in.paid)
                        list['balance'] += balance
                    }
                    lists.push(list)
                }
                return lists
            }
        },
        methods: {
            initialized() {
                
            },
            editCustomer(id) {
                this.$emit('editCustomer', 'add_edit', id) //modal add
            }
        }
    })
</script>
