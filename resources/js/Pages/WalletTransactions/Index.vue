<template>
    <app-layout title="Transactions">
        <template #header>
            <inertia-link :href="route('wallets.index')">
                <jet-button color="black">Back</jet-button>
            </inertia-link>
            <jet-button class="float-right ml-1" color="blue" @click="showModal('in')">Cash In</jet-button>
            <jet-button class="float-right" color="red" @click="showModal('out')">Cash Out</jet-button>
        </template>
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden overflow-y-auto content-admin">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <wgt-total-header :total="total" />
                    </div>
                    <transaction-list />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.in_out.show">
            <template #title>Cash {{ form.list_data.method }}</template>
            <template #content>
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-6">
                        <jet-label value="Amount" />
                        <jet-input type="number" class="w-full" v-model="form.list_data.amount"/>
                    </div>
                    <!-- <div class="col-span-2">
                        <jet-label value="Fee" />
                        <jet-input type="number" class="w-full" v-model="form.list_data.fee"/>
                    </div> -->
                    <div class="col-span-6">
                        <jet-label value="Note" />
                        <jet-input type="text" class="w-full" placeholder="Description" v-model="form.list_data.note"/>
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-button color="none" @click="modal.in_out.show = false" class="mr-1">close</jet-button>
                <jet-button color="black" @click="addTransaction()" :disabled="form.processing">{{ form.processing ? 'wait': 'save' }}</jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetInputSelect from '@/Jetstream/InputSelect.vue'
    import WgtTotalHeader from '@/Widgets/TotalHeader.vue'

    import TransactionList from './List.vue'

    export default defineComponent({
        name: 'wallet-transactions',
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            JetInputSelect,
            WgtTotalHeader,
            TransactionList,
        },
        data() {
            return {
                form: this.$inertia.form({
                    list_data: {
                        method: 'in',
                        amount: 0,
                        fee: 0,
                        note: ''
                    }
                }, {
                    resetOnSuccess:true,
                }),
                modal: {
                    in_out: {
                        show: false,
                    }
                }
            }
        },
        computed: {
            total() {
                let data = {
                    in: {
                        amount: 0,
                        text: 'Cash in'
                    },
                    out: {
                        amount: 0,
                        text: 'Cash out'
                    },
                    balance: {
                        amount: this.$page.props.wallet.balance,
                        text: 'Balance'
                    }
                }
                for (const key in this.$page.props.transactions) {
                    data[this.$page.props.transactions[key].data.method].amount += parseFloat(this.$page.props.transactions[key].data.amount)
                }
                return data
            }
            /* wallets() {
                let list = []
                for (const key in this.$page.props.wallets) {
                    let data = {
                        value: this.$page.props.wallets[key].id,
                        text: this.$page.props.wallets[key].name,
                    }
                    list.push({...data})
                }
                return list
            } */
        },
        mounted() {
            // this.initialized()
        },
        methods: {
            initialized() {
            },
            showModal(method) {
                this.modal.in_out.show = true
                this.form.list_data.method = method
            },
            addTransaction() {    
                this.form.post(route('wallet.transactions.store', this.$page.props.wallet.code),{
                    preserveScroll:true,
                    onSuccess:() => {
                        this.$toast.success('Transaction Saved',{
                            duration:1000
                        })
                        this.form.reset()
                        this.modal.in_out.show = false
                    },
                })
            }
        }
    })
</script>
