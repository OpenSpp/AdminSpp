<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="max-w-full mx-auto py-7">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <welcome :payment="payment" :yearFilter="yearFilter"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },

        props: ['payment', 'yearFilter'],

        beforeMount() {
            console.log("=========================================");
            console.log(this.payment);
        }
    })
</script>
