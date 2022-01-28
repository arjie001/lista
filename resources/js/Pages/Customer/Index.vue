<template>
    <app-layout title="Transactions">
        <template #header>
            <inertia-link :href="route('branches.index')">
                <jet-button color="black">Back</jet-button>
            </inertia-link>
            <jet-button class="float-right" color="black" @click="showModal('add_edit')">Add Customer</jet-button>
        </template>
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden overflow-y-auto content-admin">
                    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                        <!-- <wgt-total-header :total="total" /> -->
                    </div>
                    <customer-list @editCustomer="showModal"/>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="modal.add_edit.show">
            <template #title>Add Customer</template>
            <template #content>
                <div class="grid grid-cols-6 gap-1 my-1 mx-1">
                    <div class="col-span-6">
                        <jet-label value="Name" />
                        <jet-input type="text" placeholder="Customer name" class="w-full" v-model.number="form.name"/>
                    </div>
                    <div class="col-span-6">
                        <jet-label value="Branch" />
                        <jet-input-select class="w-full" :lists="branches" v-model="form.branch_code" />
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-button color="none" @click="modal.add_edit.show = false" class="mr-1">close</jet-button>
                <jet-button color="black" @click="addCustomer()" :disabled="form.processing">{{ form.processing ? 'wait': 'save' }}</jet-button>
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

    import CustomerList from './List.vue'

    export default defineComponent({
        name: 'customers',
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            JetInputSelect,
            WgtTotalHeader,
            CustomerList,
        },
        data() {
            return {
                form: this.$inertia.form({
                    id: -1,
                    name: '',
                    branch_code: '',
                    info: []
                }, {
                    resetOnSuccess:true,
                }),
                modal: {
                    add_edit: {
                        show: false,
                        default: {
                            infor: [],
                            branch_code: '',
                            name: ''
                        }
                    }
                }
            }
        },
        computed: {
            branches() {
                let list = []
                for (const key in this.$page.props.branches) {
                    let data = {
                        value: this.$page.props.branches[key].code,
                        text: this.$page.props.branches[key].name,
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
                this.form.branch_code = this.assign(this.$page.props.branches[0].code)
            },
            showModal(modal, id = -1) {
                this.modal[modal].show = true
                this.form.id = id
                if (id >= 0) {
                    let customer = this.assign(this.$page.props.customers.find(t => t.id == id))
                    this.form.name = customer.name
                    this.form.branch_code = this.$page.props.branches.find(b => b.id == customer.branch_id).code
                    this.form.info = customer.data
                }
                
            },
            addCustomer() {    
                if (this.form.id >= 0) { //edit
                    var route_url = 'customers.update'
                }else {
                    var route_url = 'customers.store'
                }
                var route_payload = {
                    'id': this.form.id
                }
                this.form.post(route(route_url, route_payload),{
                    preserveScroll:true,
                    onSuccess:() => {
                        this.$toast.success('Customer Saved',{
                            duration:1000
                        })
                        this.modal.add_edit.show = false
                        this.form.id = -1
                    },
                })
            }
        }
    })
</script>
