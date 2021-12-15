<template>
    <app-layout title="Transactions">
        <template #header>
            <jet-button color="black" @click="showModal('add')">Add List</jet-button>
        </template>
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden overflow-y-auto content-admin">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <div class="text-gray-500 total-container grid grid-cols-9 gap-1">
                            <div class="col-span-3 flex flex-col">
                                <span class="text-center">23,000</span>
                                <span class="text-center">Widrawn</span>
                            </div>
                            <div class="col-span-3 flex flex-col">
                                <span class="text-center">23,000</span>
                                <span class="text-center">Investment</span>
                            </div>
                            <div class="col-span-3 flex flex-col">
                                <span class="text-center">23,000</span>
                                <span class="text-center">Capital</span>
                            </div>
                        </div>
                    </div>
                    <transaction-list />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.add.show">
            <template #title>Add Branch</template>
            <template #content>
                <jet-label value="Customer" />
                <jet-input-select class="w-full" :lists="[{value: 'Others', text: 'Others'}, {value: 'Arjie', text: 'Arjie'}]" v-model="modal.add.data.customer" />
                
                <div class="flex flex-col flex-grow border border-1 border-gray-300 rounded-sm mt-2">
                    <div class="mb-2"> 
                        <span class="flex justify-left font-semibold text-gray-500 bg-blue-300 rounded-sm QQ pl-1">
                            Money In
                        </span>
                    </div>
                    <div class="grid grid-cols-6 gap-1 my-1 mx-1">
                        <div class="col-span-6">
                            <jet-label value="Wallet" />
                            <jet-input-select class="w-full" :lists="wallets" v-model="modal.add.data.money_in.wallet_id" />
                        </div>
                        <div class="col-span-6">
                            <jet-label value="Amount" />
                            <jet-input type="number" class="w-full" v-model="modal.add.data.money_in.amount"/>
                        </div>
                        <div class="col-span-6">
                            <jet-label value="Paid" />
                            <jet-input type="number" class="w-full" v-model="modal.add.data.money_in.paid"/>
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
                            <jet-input-select class="w-full" :lists="wallets" v-model="modal.add.data.money_out.wallet_id" />
                        </div>
                        <div class="col-span-6">
                            <jet-label value="Amount" />
                            <jet-input type="number" class="w-full" v-model="modal.add.data.money_out.amount"/>
                        </div>
                    </div>
                </div>
                
            </template>
            <template #footer>
                <jet-button color="none" @click="modal.add.show = false" class="mr-1">close</jet-button>
                <jet-button color="black" @click="addBranch()" :disabled="form.processing">{{ form.processing ? 'wait': 'save' }}</jet-button>
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

    import TransactionList from './List.vue'

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            JetInputSelect,

            TransactionList,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name:'',
                }, {
                    resetOnSuccess:true,
                }),
                modal: {
                    add: {
                        show: false,
                        data: {
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
                        },
                        default_data: {
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
            }
        },
        mounted() {
            this.initialized()
        },
        methods: {
            initialized() {
                this.modal.add.default_data.money_in.wallet_id = this.assign(this.$page.props.wallets[0].id)
                this.modal.add.default_data.money_out.wallet_id = this.assign(this.$page.props.wallets[0].id)
            },
            showModal(modal) {
                this.modal[modal].show = true
                this.modal[modal].data = this.assign(this.modal[modal].default_data)
            },
            addTransaction() {    
                this.$toast.success('Transaction Saved',{
                    duration:1000
                })            
                /* this.form.post(route('branches.store'),{
                    preserveScroll:true,
                    onSuccess:() => {
                        this.$toast.success('Branch Added',{
                            duration:1000
                        })
                        this.modal.add = false
                    },
                }) */
            }
        }
    })
</script>
