<template>
    <app-layout title="Edit Pembayayan Daftar Ulang">

    <template #header>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="flex leading-none text-indigo-600 divide-x divide-indigo-400">
                        <li class="pr-4"><Link :href="route('dashboard')" >Dashboard</Link></li>
                        <li class="px-4"><Link :href="route('registrations.index')" >Angkatan</Link></li>
                        <li class="px-4 text-gray-700" aria-current="page">Edit Pembayayan Daftar Ulang</li>
                    </ol>
                </nav>
            </div>
            <div></div>
        </div>
    </template>

    <div>
        <div class="max-w-full mx-auto py-10">
            <jet-form @submitted="updateRegistration">

                    <template #form>
                        
                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="user_id" value="Siswa" />
                            <student
                                id="user_id"
                                v-model="student"
                                class="mt-1 block w-full"
                                @objectValue="getStudent"
                                :selected="payment.user"
                            />
                            <jet-input-error :message="form.errors.user_id" class="mt-2" />
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <jet-label for="month" value="Bulan" />
                                    <com-select class="mt-1 block w-full"
                                        id="month"
                                        v-model="form.month"
                                        :selectLabel="{value: '==Pilih Bulan=='}"
                                        :options="month"
                                    />
                                    <jet-input-error :message="form.errors.month" class="mt-2" />
                                </div>

                                <div>
                                    <jet-label for="year" value="Tahun" />
                                    <com-select class="mt-1 block w-full"
                                        id="year"
                                        v-model="form.year"
                                        :selectLabel="{value: '==Pilih Tahun=='}"
                                        :options="setYear"
                                    />
                                    <jet-input-error :message="form.errors.year" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6">
                            <jet-label for="amount" value="SPP" />
                            <jet-input id="amount" type="text" class="mt-1 block w-full" v-model="form.amount" />
                            <jet-input-error :message="form.errors.amount" class="mt-2" />
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
    import Student from '@/Components/Payment/Student.vue'
    import ComSelect from '@/Components/Select.vue'
    // import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            AppLayout, JetForm, JetInput, JetLabel, Link, JetButton, JetInputError, JetSelect, JetDangerButton,
            Student, ComSelect
        },
        props: ['payment', 'success_message', 'errors'],

        data() {
            return {
                itemId :  this.payment.id,
                student: null,
                month: [
                    {id: 1, name: "January"},
                    {id: 2, name: "Februari"},
                    {id: 3, name: "Maret"},
                    {id: 4, name: "April"},
                    {id: 5, name: "Mei"},
                    {id: 6, name: "Juni"},
                    {id: 7, name: "Juli"},
                    {id: 8, name: "Agustus"},
                    {id: 9, name: "September"},
                    {id: 10, name: "Oktober"},
                    {id: 11, name: "November"},
                    {id: 12, name: "Desember"}
                ],
                form: this.$inertia.form({
                    _method: "PUT",
                    user_id: this.payment.user_id,
                    type: 'daftar-ulang',
                    month: this.payment.month,
                    year: this.payment.year,
                    amount: this.payment.amount,
                })
            }
        },
        methods: {
            updateRegistration() {
                this.form.post(route('registrations.update', this.itemId), {
                    errorBag: 'updateRegistration',
                    preserveScroll: true,
                    onSuccess: page => {
                        //console.log(page)
                    },
                });
            },
            getStudent(value) {
                this.form.user_id = value?.id
                this.form.amount = value?.student?.room?.re_registration
            }
        },
        computed: {
            setYear: function () {
                let myDate = new Date();
                let start = (myDate.getFullYear()) - 10;
                let end = (myDate.getFullYear()) + 10;
                let arrY = [];
                for(let i =start;i<=end;i++) {
                    arrY.push({id: i, name: i});
                }

                return arrY;
            }
        },
        beforeMount() {
            //console.log("===================================");
            //console.log(this.payment.user.student);
        }

        
    })
</script>
