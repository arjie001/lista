<template>
    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
        <div class="px-6 py-2 border-t border-gray-200" @click="editUser(user.id)" v-for="user in $page.props.users" :key="user.id">
            <div class="grid grid-cols-6 gap-1">
                <div class="col-span-5">
                    <div>{{ user.name}}</div>
                    <div class="text-xs">{{ moment(user.created_at).format("ddd MMM DD, YYYY")}}</div>
                </div>
                <div class="col-span-1 flex flex-col">
                    <jet-label :value="user.membership?.role[0].toUpperCase() + user.membership?.role.slice(1) || 'Owner'" class="text-center" />
                    <div class="text-xs text-center">Role</div>
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
        name: 'users_list',
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
            editUser(id) {
                this.$emit('editUser', 'add_edit', id) //modal add
            }
        }
    })
</script>
