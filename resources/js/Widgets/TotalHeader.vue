<template>
    <div class="text-gray-500 total-container grid grid-cols-9 gap-1">
        <div class="col-span-3 flex flex-col text-blue-500">
            <span class="text-center">{{ money(total.in.amount) }}</span>
            <span class="text-center">{{ total.in.text }}</span>
        </div>
        <div class="col-span-3 flex flex-col flex-col text-red-400">
            <span class="text-center">{{ money(total.out.amount) }}</span>
            <span class="text-center">{{ total.out.text }}</span>
        </div>
        <div class="col-span-3 flex flex-col text-green-500">
            <span class="text-center">{{ money(total.balance.amount) }}</span>
            <span class="text-center">{{ total.balance.text }}</span>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['total'],
    })
</script>