<template>
    <button :type="type" :class="colors" class="items-center px-4 py-3 rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            color: {
                default: 'black'
            },
            type: {
                type: String,
                default: 'submit',
            },
        },
        computed: {
            sizes() {
                return {
                    'sm': " px-1 py-1 text-sm",
                    'md': " px-3 py-2",
                    'lg': " px-4 py-4"
                }[this.size]
            },
            colors() {
                return {
                    black: "text-white bg-gray-800 border-gray-800 hover:bg-gray-700 hover:border-gray-600 active:bg-gray-900 focus:border-gray-900",
                    blue: "text-white bg-blue-500 border-blue-500 hover:bg-blue-600 hover:border-blue-600",
                    gray: "text-white bg-gray-400 border-gray-400 hover:bg-gray-500 hover:border-gray-500",
                    yellow: "text-white bg-yellow-400 border-yellow-400 hover:bg-yellow-500 hover:border-yellow-500",
                    orange: "text-white bg-orange-400 border-orange-400 hover:bg-orange-500 hover:border-orange-500",
                    red: "text-white bg-red-400 border-red-400 hover:bg-red-500 hover:border-red-500",
                    "outline-blue": "text-gray-700 bg-white border-blue-500 hover:border-blue-600",
                    "outline-gray": "text-gray-700 bg-white border-gray-400 hover:border-gray-500",
                    "outline-yellow": "text-gray-700 bg-white border-yellow-400 hover:border-yellow-500",
                    "outline-orange": "text-gray-700 bg-white border-orange-400 hover:border-orange-500",
                    "outline-red": "text-gray-700 bg-white border-red-400 hover:border-red-500",
                    ssrBlueIcon: "text-gray-400 hover:border-ssr-blue2 hover:text-ssr-blue2 ssrBT",
                    ssrRedIcon: "text-gray-400 hover:border-ssr-red2 hover:text-ssr-red2 ssrBT",
                    ssrOrangeIcon: "text-gray-400 hover:border-ssr-orange2 hover:text-ssr-orange2 ssrBT",
                    ssrBlueIconCret: "text-white bg-ssr-blue4 rounded-full border border-ssr-blue4 ssrBTX",
                }[this.color]
            },
        }
    })
</script>
