<template>
    <app-layout title="SPP">
        <template #header>
            <div class="grid grid-cols-2 gap-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="flex leading-none text-indigo-600 divide-x divide-indigo-400">
                        <li class="pr-4"><Link :href="route('dashboard')" >Dashboard</Link></li>
                        <li class="px-4 text-gray-700" aria-current="page">SPP</li>
                    </ol>
                </nav>
            </div>
            <div class="text-right">
              <Link :href="route('spps.create')"><jet-button class="bg-blue-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded">Bayar SPP</jet-button></Link>
            </div>
        </div>
        </template>

        <div class="max-w-full mx-auto py-7">

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="container flex px-2 py-2">              
                                <div class="relative">
                                    <input type="text" class="h-10 w-96 pr-8 pl-5 rounded z-0 focus:shadow focus:outline-none" v-model="seachKey" placeholder="Search..." @keyup.enter="quickSearch">
                                    <div v-if="seachKey" class="absolute top-2 right-9">
                                        <button @click="clearSearchBar">
                                             <i class="fas fa-times text-gray-400 z-20 hover:text-gray-500"></i>
                                        </button>
                                    </div>
                                    <div class="absolute top-2 right-3"> 
                                        <Link :href="route('spps.index', { 'search': seachKey } )">
                                          <i class="fas fa-search text-gray-400 z-20 hover:text-gray-500"></i>
                                        </Link> 
                                    </div>
                                </div>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NO</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angkatan</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan / Tahun</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pembayaran</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated At</th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(item, index) in payments.data" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ (index + 1) + (start)}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item?.user?.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item?.user?.student?.room?.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item?.month }} / {{ item?.year }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.amountRupiah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.formattedCreatedAt }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.formattedUpdatedAt }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link :href="route('spps.edit', item.id)" type="button"><jet-button class="bg-coolGray-500 ml-4 hover:bg-coolGray-400">Edit</jet-button></Link>
                                            &nbsp;<jet-danger-button @click="confirmSppDeletion(item.id)">Hapus </jet-danger-button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :links="payments.links"></pagination> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from "@/Jetstream/Button";
    import JetInput from "@/Jetstream/Input";
    import Pagination from '@/Components/Pagination'
    import { Link } from '@inertiajs/inertia-vue3';
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import ActionMessage from '@/Jetstream/ActionMessage.vue'

    export default defineComponent({
        components: {
          AppLayout,
          JetButton,
          JetInput,
          Pagination,
          Link,
          JetFormSection,
          JetDialogModal, 
          JetDangerButton, 
          JetSecondaryButton, 
          ActionMessage,
        },

        props: [
          'payments',
          'filtersPayments',
          'start',
        ],

        data(){
            return{
                confirmingUserDeletion: false,
                itemId : null,
                start : this.start,
                seachKey : route().params.search ? route().params.search : null,
                form: this.$inertia.form({
                    _method : 'DELETE',
                })
            }
        },
        methods:{
            quickSearch(){                
                this.$inertia.get(route('spps.index', { 'search': this.seachKey } ),{})
            },
            clearSearchBar(){
                if(route().params.search){
                    this.$inertia.get(route('spps.index'),{})
                }else{
                    this.seachKey = null
                }
            },
            confirmSppDeletion(id) {
                this.itemId = id;
                this.confirmingUserDeletion = true;
                if (!confirm('Are you sure want to remove?')) return;
                this.form.delete(route('spps.destroy', this.itemId), {
                    onSuccess: () => this.closeModal(),
                })
            },
        },
        beforeMount() {
            //console.log("======================================================");
            //console.log(this.payments.data);
        }

    })
</script>
