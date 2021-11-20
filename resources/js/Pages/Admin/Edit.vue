<template>
    <app-layout title="Edit Admin">

    <template #header>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="flex leading-none text-indigo-600 divide-x divide-indigo-400">
                        <li class="pr-4"><Link :href="route('dashboard')" >Dashboard</Link></li>
                        <li class="px-4"><Link :href="route('admins.index')" >Admins</Link></li>
                        <li class="px-4 text-gray-700" aria-current="page">Edit Admin</li>
                    </ol>
                </nav>
            </div>
            <div></div>
        </div>
    </template>

    <div>
        <div class="max-w-full mx-auto py-10">
            <jet-form @submitted="updateAdmin">
                    <template #form>
                        <!-- Name -->
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                            <div v-if="errors.name">{{ errors.name }}</div>
                            <div v-if="success_message">{{ success_message }}</div>
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="role" value="Role" />
                            <jet-select type="text" class="mt-1 block w-full" v-model="form.role" :options="role" />
                            <jet-input-error :message="form.errors.role" class="mt-2" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.password" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
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
        props: ['admin', 'success_message', 'errors'],

        data() {
            return {
                itemId :  this.admin.id,
                role: [{name: '==Select==', value: ''}, {name: 'Admin', value: 'admin'}, {name: 'Super Admin', value: 'super-admin'}],
                form: this.$inertia.form({
                    _method: "PUT",
                    name: this.admin.name,
                    email: this.admin.email,
                    password: null,
                    role: this.admin.role,
                })
            }
        },
        methods: {
            updateAdmin() {
                this.form.post(route('admins.update', this.itemId), {
                    errorBag: 'updateAdmin',
                    preserveScroll: true,
                    onSuccess: page => {
                        //console.log(page)
                    },
                });
            },
        },

        
    })
</script>
