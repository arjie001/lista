<template>
    <app-layout title="Branches">
        <template #header>
            <jet-button>Add Branch</jet-button>
        </template>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                    <list />
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="true">
            <template #title>Add Branch</template>
            <template #content>
                <jet-label value="Branch Name" />
                <jet-input type="text" class="w-full" required autofocus/>
            </template>
            <template #footer>
                <jet-button>Save</jet-button>
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

    import List from './List.vue'

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetInput,

            List,
        },
    })
</script>
