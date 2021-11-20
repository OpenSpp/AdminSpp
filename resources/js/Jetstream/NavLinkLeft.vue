<template>
    <Link :href="href" :class="classes">
        <span class="inline-block overflow-visible h-5 w-5 text-sm  mr-5">
            <i :class="icons"></i>
        </span>
        <span class="text-sm not-italic font-medium leading-5"><slot /></span>
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active', 'icons'],

        computed: {
            classes() {
                return this.active
                    ? 'block py-2.5 px-4 transition duration-200 hover:bg-blue-700 hover:text-white bg-blue-700 text-white'
                    : 'block py-2.5 px-4 transition duration-200 hover:bg-blue-700 hover:text-white'
            }
        }
    })
</script>
