<template>
    <div>
        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1">
            <div class="p-6 border-t border-gray-200" v-for="wallet in $page.props.wallets" :key="wallet.id">
                <inertia-link 
                    class="flex items-center"
                    :href="route('wallet.transactions.index', wallet.code)">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    
                    <div class="w-full grid grid-cols-6">
                        <div class="col-span-4 ml-4 text-lg text-gray-600 leading-7 font-semibold">{{ wallet.name }}</div>
                        <div class="col-span-2 ml-4 text-lg text-gray-600 leading-7 font-semibold float-right">{{ money(wallet.balance )}}</div>
                    </div>
                </inertia-link>
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
