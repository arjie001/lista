<template>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
        <template v-if="$page.props.wallets.length == 0">
            <inertia-link class="p-1" :href="route('wallets.index')">
                <jet-button class="w-full" color="black"><span>Create Wallet</span></jet-button>
            </inertia-link>
            <div class="w-full p-1">
                <div class="text-center py-5 w-full border border-dashed border-gray-600 bg-gray-100 rounded-sm">There is no Wallet</div>
            </div>
        </template>
        <div class="px-6 py-2 border-t border-gray-200" @click="editTransaction(transaction.id)" v-for="transaction in $page.props.transactions" :key="transaction.id">
            <div class="grid grid-cols-7 gap-1">
                <div class="col-span-4">
                    <div>{{ transaction.data?.customer}}</div>
                    <div class="text-xs">{{ moment(transaction.created_at).format("ddd MMM DD, YYYY")}}</div>
                </div>
                <div class="col-span-2">
                    <jet-label value="Amount" />
                    <div class="font-semibold">{{ money(transaction.data.money_in.amount) }}</div>
                </div>
                <div class="col-span-1">
                    <jet-label value="Paid" />
                    <div class="font-semibold" 
                        :class="transaction.data.money_in.paid >= transaction.data.money_in.amount ? 'text-blue-500': 'text-red-400'">
                        {{ money(transaction.data.money_in.paid) }}
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
        name: 'branch-transaction-lists',
        components: {
            JetApplicationLogo,
            JetButton,
            JetLabel
        },
        methods: {
            editTransaction(id) {
                this.$emit('editTransaction', 'add_edit', id) //modal add
            }
        }
    })
</script>
