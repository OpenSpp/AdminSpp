<template>
    <app-layout title="Edit Department">

    <template #header>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="flex leading-none text-indigo-600 divide-x divide-indigo-400">
                        <li class="pr-4"><Link :href="route('dashboard')" >Dashboard</Link></li>
                        <li class="px-4"><Link :href="route('departments.index')" >Departments</Link></li>
                        <li class="px-4 text-gray-700" aria-current="page">Edit Department</li>
                    </ol>
                </nav>
            </div>
            <div></div>
        </div>
    </template>

    <div>
        <div class="max-w-full mx-auto py-10">
            <jet-form @submitted="updateDepartment">

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
                            <jet-label for="queue_code" value="Queue code" />
                            <jet-input id="queue_code" type="text" class="mt-1 block w-full" v-model="form.queue_code" autocomplete="queue_code" />
                            <jet-input-error :message="form.errors.queue_code" class="mt-2" />
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="services_per_day" value="Services per day" />
                            <jet-input id="services_per_day" type="number" class="mt-1 block w-full" v-model="form.services_per_day"  />
                            <jet-input-error :message="form.errors.services_per_day" class="mt-2" />
                        </div>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <table class="min-w-full divide-y divide-red-200 w-full">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-3 bg-red-50 text-left text-xs font-medium text-red-500 uppercase tracking-wider">Service Name</th>
                                        <th scope="col" class="px-6 py-3 bg-red-50 text-left text-xs font-medium text-red-500 uppercase tracking-wider">Active</th>
                                        <th scope="col" class="px-6 py-3 bg-red-50 text-left text-xs font-medium text-red-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(item, index) in form.services" :key="index">
                                        <td class="py-4 whitespace-nowrap text-sm text-gray-900 align-top">
                                            <jet-input type="text" class="mt-1 block w-full" v-model="form.services[index].name"  />
                                            <jet-input-error v-for="(msg, idx) in getErrors('services', index, 'name')" :key="idx" :message="msg" class="mt-2" />
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-sm text-gray-900 align-top">
                                            <jet-select type="text" class="mt-1 block w-full" v-model="form.services[index].is_active" :options="is_active" />
                                            <jet-input-error v-for="(msg, idx) in getErrors('services', index, 'is_active')" :key="idx" :message="msg" class="mt-2" />
                                        </td>
                                        <td class="py-4 whitespace-nowrap text-sm text-gray-900 align-midle align-center" width="1%">
                                            <template v-if="item.id == null">
                                            <jet-danger-button type="button" @click="deleteService(index)"><i class="fas fa-trash-alt"></i></jet-danger-button>
                                            </template>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-4 whitespace-nowrap text-sm text-gray-900" colspan="3">
                                            <jet-button class="bg-red-500 ml-4 hover:bg-red-400" type="button" @click="addService">Add Service</jet-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
        props: ['department', 'success_message', 'errors'],

        data() {
            return {
                itemId :  this.department.id,
                is_active: [{name: 'Active', value: 1}, {name: 'InActive', value: 0}],
                form: this.$inertia.form({
                    _method: "PUT",
                    name: this.department.name,
                    queue_code: this.department.queue_code,
                    services_per_day: this.department.services_per_day,
                    services: this.department.services,
                })
            }
        },
        methods: {
            updateDepartment() {
                this.form.post(route('departments.update', this.itemId), {
                    errorBag: 'updateDepartment',
                    preserveScroll: true,
                    onSuccess: page => {
                        //console.log(page)
                    },
                });
            },
            addService () {
                this.form.services.push({
                    id: null,
                    name: null,
                    is_active: 1,
                })
            },
            deleteService (index) {
                this.form.services.splice(index, 1);
            },
            getErrors(field, idx, sub) {
                let search = field + "." + idx + "." + sub
                const fields = Object.keys(this.form.errors).filter(key => key === search  || key.startsWith(`${search}.`))
                return fields.reduce((carry, key) => {
                    carry.push(this.form.errors[key]);
                    return carry;
                }, []);
            },
        },

        
    })
</script>
