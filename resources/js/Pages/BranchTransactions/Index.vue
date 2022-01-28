<template>
    <app-layout title="Transactions">
        <template #header>
            <inertia-link :href="route('branches.index')">
                <jet-button color="black">Back</jet-button>
            </inertia-link>
            <jet-button class="float-right ml-1" color="black" @click="showModal('add_edit')">Add List</jet-button>
            <!-- <jet-button class="float-right" color="black" @click="showModal('add_edit')">Customers</jet-button> -->
        </template>
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden overflow-y-auto content-admin">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <wgt-total-header :total="total" />
                    </div>
                    <transaction-list @editTransaction="showModal"/>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.add_edit.show">
            <template #title>Add List</template>
            <template #content>
                <jet-label value="Customer" />
                <div class="flex flex-row">
                    <jet-input-select class="w-full" :lists="customers" v-model="form.customer_id" />
                    <jet-button class="ml-1" color="black" @click="showModal('add_edit')"><span>New</span></jet-button>
                </div>
                <div class="flex flex-col flex-grow border border-1 border-gray-300 rounded-sm mt-2">
                    <div class="mb-2"> 
                        <span class="flex justify-left font-semibold text-gray-100 bg-blue-300 rounded-sm QQ pl-1">
                            Money In
                        </span>
                    </div>
                    <div class="grid grid-cols-6 gap-1 my-1 mx-1">
                        <div class="col-span-6">
                            <jet-label value="Wallet" />
                            <jet-input-select class="w-full" :lists="wallets" v-model="form.list_data.money_in.wallet_id" />
                        </div>
                        <div class="col-span-3">
                            <jet-label value="Amount" />
                            <jet-input type="number" placeholder="load + interest" class="w-full" v-model.number="form.list_data.money_in.amount"/>
                        </div>
                        <div class="col-span-3">
                            <jet-label value="Paid" />
                            <jet-input type="number" class="w-full" v-model.number="form.list_data.money_in.paid"/>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col flex-grow border border-1 border-gray-300 rounded-sm mt-2">
                    <div class="mb-2"> 
                        <span class="flex justify-left font-semibold text-gray-100 bg-red-300 rounded-sm QQ pl-1">
                            Money Out
                        </span>
                    </div>
                    <div class="grid grid-cols-6 gap-1 my-1 mx-1">
                        <div class="col-span-6">
                            <jet-label value="Wallet" />
                            <jet-input-select class="w-full" :lists="wallets" v-model="form.list_data.money_out.wallet_id" />
                        </div>
                        <div class="col-span-6">
                            <jet-label value="Amount" />
                            <jet-input type="number" placeholder="load - discount" class="w-full" v-model.number="form.list_data.money_out.amount"/>
                        </div>
                    </div>
                </div>
                
            </template>
            <template #footer>
                <jet-button color="none" @click="modal.add_edit.show = false" class="mr-1">close</jet-button>
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
        name: 'branch-transactions',
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
                    customer_id: 0,
                    id: -1,
                    list_data: {
                        customer: 'Others',
                        money_in: {
                            amount: 0,
                            paid: 0,
                            wallet_id: 0
                        },
                        money_out: {
                            amount: 0,
                            paid: 0,
                            wallet_id: 0
                        }
                    }
                }, {
                    resetOnSuccess:true,
                }),
                modal: {
                    add_edit: {
                        show: false,
                        id: -1,
                        customer_id: 0,
                        default_data: {
                            customer: 'Others',
                            money_in: {
                                amount: '',
                                paid: 0,
                                wallet_id: 0
                            },
                            money_out: {
                                amount: '',
                                wallet_id: 0
                            }
                        }
                    }
                }
            }
        },
        computed: {
            wallets() {
                let list = []
                for (const key in this.$page.props.wallets) {
                    let data = {
                        value: this.$page.props.wallets[key].id,
                        text: this.$page.props.wallets[key].name,
                    }
                    list.push({...data})
                }
                return list
            },
            total() {
                let data = {
                    in: {
                        amount: 0,
                        text: 'Earned'
                    },
                    out: {
                        amount: 0,
                        text: 'Expenses'
                    },
                    balance: {
                        amount: 0,
                        text: 'Total Profit'
                    }
                }
                for (const key in this.$page.props.transactions) {
                    data.in.amount += this.$page.props.transactions[key].data.money_in.amount
                    data.out.amount += this.$page.props.transactions[key].data.money_out.amount
                }
                data.balance.amount = data.in.amount - data.out.amount

                return data
            },
            customers() {
                let data = [
                    {
                        value: 0,
                        text: 'Others'
                    }
                ]
                for (const key in this.$page.props.customers) {
                    data.push({
                        value: this.$page.props.customers[key].id,
                        text: this.$page.props.customers[key].name
                    })
                }
                return data
            }
        },
        mounted() {
            this.initialized()
        },
        methods: {
            initialized() {
                if (this.$page.props.branch.config.default.wallet_in == 0 && this.$page.props.wallets.length > 0) {
                    this.modal.add_edit.default_data.money_in.wallet_id = this.assign(this.$page.props.wallets[0].id)
                    this.modal.add_edit.default_data.money_out.wallet_id = this.assign(this.$page.props.wallets[0].id)
                }else {
                    this.modal.add_edit.default_data.money_in.wallet_id = this.assign(this.$page.props.branch.config.default.wallet_in)
                    this.modal.add_edit.default_data.money_out.wallet_id = this.assign(this.$page.props.branch.config.default.wallet_out)
                }
            },
            showModal(modal, id = -1) {
                this.modal[modal].show = true
                this.modal[modal].id = id
                if (id >= 0) {
                    let trans = this.assign(this.$page.props.transactions.find(t => t.id == id))
                    this.form.list_data = trans.data
                    this.form.customer_id = trans.customer_id
                }else {
                    this.form.list_data = this.assign(this.modal.add_edit.default_data)
                    this.form.customer_id = 0
                }
                
            },
            addTransaction() {    
                if (this.modal.add_edit.id >= 0) { //edit
                    var route_url = 'branch.transactions.update'
                    var route_payload = {
                        'branch_code': this.$page.props.branch.code,
                        'id':this.modal.add_edit.id
                    }
                }else {
                    var route_url = 'branch.transactions.store'
                    var route_payload = {
                        'branch_code': this.$page.props.branch.code
                    }
                }
                this.form.list_data.customer = this.customers.find(c => c.value == this.form.customer_id).text
                this.form.post(route(route_url, route_payload),{
                    preserveScroll:true,
                    onSuccess:() => {
                        this.$toast.success('List Saved',{
                            duration:1000
                        })
                        this.modal.add_edit.show = false
                        this.modal.add_edit.id = -1
                    },
                })
            }
        }
    })
</script>
