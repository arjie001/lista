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
                <div class="grid grid-cols-6 gap-1 mt-1">
                    <div class="col-span-1">
                        <jet-label value="Amount" />
                        <jet-input type="number" class="w-full" v-model="form.name" required autofocus/>
                        <jet-input-error :message="form.errors.name" />
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
        methods: {
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
