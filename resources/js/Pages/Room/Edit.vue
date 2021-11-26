<template>
    <app-layout title="Edit Angkatan">

    <template #header>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="flex leading-none text-indigo-600 divide-x divide-indigo-400">
                        <li class="pr-4"><Link :href="route('dashboard')" >Dashboard</Link></li>
                        <li class="px-4"><Link :href="route('rooms.index')" >Angkatan</Link></li>
                        <li class="px-4 text-gray-700" aria-current="page">Edit Angkatan</li>
                    </ol>
                </nav>
            </div>
            <div></div>
        </div>
    </template>

    <div>
        <div class="max-w-full mx-auto py-10">
            <jet-form @submitted="updateRoom">

                    <template #form>
                        <!-- Name -->
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="name" value="Angkatan" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="price" value="SPP" />
                            <jet-input id="price" type="text" class="mt-1 block w-full" v-model="form.price" />
                            <jet-input-error :message="form.errors.price" class="mt-2" />
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="re_registration" value="Daftar Ulang" />
                            <jet-input id="re_registration" type="text" class="mt-1 block w-full" v-model="form.re_registration" />
                            <jet-input-error :message="form.errors.re_registration" class="mt-2" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="description" value="Keterangan" />
                            <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                            <jet-input-error :message="form.errors.description" class="mt-2" />
                        </div>

                    </template>

                    <template #actions>
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                    </template>
            </jet-form>
        </div>
    </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetForm from '@/Jetstream/Form.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSelect from '@/Jetstream/Select.vue'
    // import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            AppLayout, JetForm, JetInput, JetLabel, Link, JetButton, JetInputError, JetSelect, JetDangerButton
        },
        props: ['room', 'success_message', 'errors'],

        data() {
            return {
                itemId :  this.room.id,
                form: this.$inertia.form({
                    _method: "PUT",
                    name: this.room.name,
                    price: this.room.price,
                    re_registration: this.room.re_registration,
                    description: this.room.description,
                })
            }
        },
        methods: {
            updateRoom() {
                this.form.post(route('rooms.update', this.itemId), {
                    errorBag: 'updateRoom',
                    preserveScroll: true,
                    onSuccess: page => {
                        //console.log(page)
                    },
                });
            },
        },

        
    })
</script>
