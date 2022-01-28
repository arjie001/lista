<template>
    <div>
        <div class="bg-gray-200 bg-opacity-25">
            <div class="px-6 py-2 border-t border-gray-200" v-for="transaction in $page.props.transactions" :key="transaction.id">
                <div class="grid grid-cols-6 gap-1">
                    <div class="col-span-3 flex flex-col">
                        <span>
                            {{ transaction.user.name }}
                        </span>
                        <div class="text-sm">{{ transaction.data.note || 'n/a' }}</div>
                        <div class="text-xs">{{ moment(transaction.created_at).format("ddd MMM DD, YYYY")}}</div>
                    </div>
                    <div class="col-span-1 flex flex-col" :class="{'text-red-400': transaction.data.fee > 0}">
                        <span class="text-center">
                            {{ money(transaction.data.fee) }}
                        </span>
                        <span class="text-center">
                            Fee
                        </span>
                    </div>
                    <div class="col-span-2 flex flex-col" :class="transaction.data.method == 'in'? 'text-blue-500': 'text-red-400'">
                        <span class="text-center">
                            {{ money(transaction.data.amount) }}
                        </span>
                        <span class="text-center">
                            {{ 'Cash '+transaction.data.method }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'

    export default defineComponent({
        components: {
            JetApplicationLogo,
        },
    })
</script>
