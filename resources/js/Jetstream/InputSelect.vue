<template>
    <select class="truncate form-select cursor-pointer text-gray-700 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input"
        :class="colors">
        <option :value="list.value" v-for="(list, index) in lists" :key="index">{{ list.text }}</option>
    </select>
</template>

<script>
    export default {
        props: {
            modelValue: {
                default: ''
            },
            color: {
                default: 'black'
            },
            lists: {
                default: []
            }
        },

        emits: ['update:modelValue'],
        computed: {
            colors() {
                return {
                    black: "border-gray-300 focus:border-indigo-300",
                    blue: "border-blue-500 focus:border-blue-600",
                    gray: "border-gray-400 focus:border-gray-500",
                    yellow: "border-yellow-400 focus:border-yellow-500",
                    orange: "border-orange-500 focus:border-orange-600",
                    red: "border-red-400 focus:border-red-500",
                    ssrGray: "border-gray-300 focus:border-ssr-blue3",
                }[this.color]
            }
        },
        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>
