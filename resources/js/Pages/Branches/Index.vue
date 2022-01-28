<template>
    <app-layout title="Branches">
        <template #header v-if="$page.props.admin_user">
            <jet-button color="black" @click="modal.add = true">Add Branch</jet-button>
        </template>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden overflow-y-auto" :class="$page.props.admin_user ? 'content-admin': 'content-editor'">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <wgt-total-header :total="total" />
                    </div>
                    <branch-list />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.add">
            <template #title>Add Branch</template>
            <template #content>
                <jet-label value="Branch Name" />
                <jet-input type="text" class="w-full" v-model="form.name" required autofocus/>
                <jet-input-error :message="form.errors.name" />
            </template>
            <template #footer>
                <jet-button color="none" @click="modal.add = false" class="mr-1">close</jet-button>
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
    import WgtTotalHeader from '@/Widgets/TotalHeader.vue'

    import BranchList from './List.vue'

    export default defineComponent({
        name: 'branches',
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            WgtTotalHeader,
            BranchList,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name:'',
                }, {
                    resetOnSuccess:true,
                }),
                modal: {
                    add: false
                }
            }
        },
        computed: {
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
            }
        },
        mounted() {
            this.$page.props.admin_user = true
        },
        methods: {
            addBranch() {                
                this.form.post(route('branches.store'),{
                    preserveScroll:true,
                    onSuccess:() => {
                        this.$toast.success('Branch Added',{
                            duration:1000
                        })
                        this.modal.add = false
                    },
                })
            }
        }
    })
</script>
